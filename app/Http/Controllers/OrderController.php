<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'weight' => 'required|numeric|min:1',
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                'pickup_address' => 'required|string',
                'pickup_date' => 'required|date',
                'pickup_time' => 'required|string',
            ]);

            $user = Auth::user();

            // Hitung harga total
            $service = Service::find($request->service_id);
            $biayaLayanan = $service->price * $request->weight;
            $biayaAntar = 10000;
            $total = $biayaLayanan + $biayaAntar;

            $isDiscounted = false;

            if ($user->points >= 10) {
                $total *= 0.40;             
                $user->decrement('points', 10);
                $isDiscounted = true;
            }

            // Buat kode pesanan 
            $orderCode = 'LDY-' . strtoupper(Str::random(6));

            $order = Order::create([
                'order_code' => $orderCode,
                'user_id' => $user->id,
                'service_id' => $service->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'pickup_address' => $request->pickup_address,
                'pickup_date' => $request->pickup_date,
                'pickup_time' => $request->pickup_time,
                'weight' => $request->weight,
                'total_price' => $total,
                'status' => 'Menunggu',
            ]);

            // Generate pesan 
            $adminNumber = '6287783923671';

            $message  = "Halo Admin SCA Laundry, saya baru saja membuat pesanan.\n\n";
            $message .= "Kode: *$orderCode*\n";
            $message .= "Nama: $request->name\n";
            $message .= "Layanan: {$service->name}\n";
            $message .= "Berat: {$request->weight}kg\n";
            $message .= "Total: Rp " . number_format($total, 0, ',', '.') . "\n";

            if ($isDiscounted) {
                $message .= "(Menggunakan Penukaran Poin - Diskon 60%)\n";
            }

            $message .= "\nMohon segera diproses. Terima kasih.";

            $waUrl = "https://wa.me/{$adminNumber}?text=" . urlencode($message);

            return response()->json([
                'message' => 'Pesanan berhasil.',
                'order_code' => $order->order_code,
                'wa_url' => $waUrl
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat pesanan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
