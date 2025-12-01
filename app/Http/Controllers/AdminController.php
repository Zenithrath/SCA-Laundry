<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;


class AdminController extends Controller
{
public function getData()
    {
        $orders = Order::with(['user', 'service']) 
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($order) {
                return [
                    'id' => $order->order_code,
                    'name' => $order->name, 
                    'phone' => $order->phone, 
                    'service' => $order->service ? $order->service->name : 'Layanan Dihapus',
                    'weight' => $order->weight . 'kg',
                    'total' => $order->total_price,
                    'status' => $order->status,
                    'date' => $order->created_at->format('d M Y'),
                    'address' => $order->pickup_address,
                    'pickup_date' => $order->pickup_date,
                    'pickup_time' => $order->pickup_time,
                ];
            });

        $services = Service::all();

        return response()->json([
            'orders' => $orders,
            'services' => $services
        ]);
    }
   
    public function addService(Request $request)
    {
      
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

       
        $service = Service::create([
            'name' => $request->name,
            'price' => $request->price,
            'unit' => '/kg'
        ]);

      
        return response()->json([
            'message' => 'Layanan berhasil ditambahkan', 
            'data' => $service
        ], 201);
    }

    // UPDATE STATUS ORDER
    public function updateStatus(Request $request, $order_code)
    {
        $order = Order::where('order_code', $order_code)->first();
        if($order) {
            $order->update(['status' => $request->status]);
        }
        return response()->json(['message' => 'Status updated']);
    }

    // UPDATE HARGA LAYANAN
    public function updateService(Request $request, $id)
    {
        $service = Service::find($id);
        if($service) {
            $service->update(['price' => $request->price]);
        }
        return response()->json(['message' => 'Price updated']);
    }
    
    // HAPUS LAYANAN
    public function deleteService($id)
    {
        $service = Service::find($id);
        if ($service) {
            $service->delete();
            return response()->json(['message' => 'Layanan dihapus']);
        }
        return response()->json(['message' => 'Gagal hapus'], 404);
    }
}