<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $unfinishedCount = Order::where('status', '!=', 'Selesai')->count();
        $totalIncome = Order::sum('total_price');
        $totalOrders = Order::count();
        $orders = Order::latest()->take(5)->get();

        return view('admin.index', compact('orders', 'unfinishedCount', 'totalIncome', 'totalOrders'))
            ->with('page', 'dashboard')
            ->with('title', 'Dashboard Overview');
    }

    // Data pelanggan
    public function customers()
    {
        $orders = Order::latest()->get();

        return view('admin.index', compact('orders'))
            ->with('page', 'customers')
            ->with('title', 'Data Pelanggan');
    }

    // Data layanan
    public function services()
    {
        $services = Service::all();

        return view('admin.index', compact('services'))
            ->with('page', 'services')
            ->with('title', 'Kelola Layanan');
    }

    // Laporan keuangan
    public function finance(Request $request)
    {
        $availableYears = Order::selectRaw('YEAR(created_at) as year')
            ->distinct()->orderBy('year', 'desc')->pluck('year');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([date('Y')]);
        }

        $requestedYear = $request->input('year');
        $selectedYear = ($requestedYear && $availableYears->contains($requestedYear))
            ? $requestedYear
            : $availableYears->first();

        $availableMonths = Order::whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month')
            ->distinct()->orderBy('month', 'desc')->pluck('month');

        if ($availableMonths->isEmpty()) {
            $lastOrder = Order::latest()->first();
            if ($lastOrder) {
                $availableMonths = collect([(int) $lastOrder->created_at->format('n')]);
                $selectedYear = (int) $lastOrder->created_at->format('Y');
            } else {
                $availableMonths = collect([date('n')]);
            }
        }

        $requestedMonth = $request->input('month');
        $selectedMonth = ($requestedMonth && $availableMonths->contains($requestedMonth))
            ? $requestedMonth
            : $availableMonths->first();

        // Data chart
        $financeData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total')
            )
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartLabels = [];
        $chartValues = [];
        $chartColors = [];

        foreach ($financeData as $data) {
            $chartLabels[] = Carbon::parse($data->date)->format('d M');
            $chartValues[] = (float) $data->total;
            $chartColors[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }

        // Tabel transaksi
        $filteredOrders = Order::whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->latest()->take(10)->with('service')->get();

        return view('admin.index', compact(
            'filteredOrders',
            'chartLabels', 'chartValues', 'chartColors',
            'selectedMonth', 'selectedYear',
            'availableYears', 'availableMonths'
        ))
        ->with('page', 'finance')
        ->with('title', 'Laporan Keuangan');
    }

    // Update status order
    public function updateStatus(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->status = $request->input('status');
            $order->save();

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'status' => $order->status]);
            }

            return back()->with('success', 'Status pesanan diperbarui');
        } catch (\Exception $e) {
            \Log::error('Update Status Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // Tambah layanan baru + foto
    public function addService(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'name'  => $request->name,
            'price' => $request->price,
            'unit'  => '/kg'
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $data['image'] = $path;
        }

        Service::create($data);

        return back()->with('success', 'Layanan berhasil ditambahkan');
    }

    // Update harga layanan
    // Update Layanan (Bisa Nama atau Harga via AJAX)
public function updateService(Request $request, $id)
{
    $service = \App\Models\Service::findOrFail($id);

    // Cek apa yang dikirim: 'price' atau 'name'
    if ($request->has('price')) {
        $service->price = $request->price;
    }
    
    if ($request->has('name')) {
        $request->validate(['name' => 'required|string|max:255']);
        $service->name = $request->name;
    }

    $service->save();

    return response()->json(['success' => true]);
}

    // Update foto layanan
    public function updateServiceImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $service = Service::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }

            $path = $request->file('image')->store('services', 'public');
            $service->image = $path;
            $service->save();
        }

        return back()->with('success', 'Foto layanan diperbarui');
    }

    // Hapus layanan
    public function deleteService($id)
    {
        $service = Service::findOrFail($id);

        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return back()->with('success', 'Layanan berhasil dihapus');
    }
}
