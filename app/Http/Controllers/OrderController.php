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
           
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'weight' => 'required|numeric|min:1',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'pickup_address' => 'required|string',
                'pickup_date' => 'required|date',
                'pickup_time' => 'required|string',
            ]);

           
            if (!Auth::check()) {
                return response()->json(['message' => 'Silakan login terlebih dahulu'], 401);
            }

          
            $service = Service::find($request->service_id);
            $biayaLayanan = $service->price * $request->weight;
            $biayaJemput = 5000; 
            $biayaAntar = 5000; 
            $total = $biayaLayanan + $biayaJemput + $biayaAntar;

           
            $order = Order::create([
                'order_code' => 'LDY-' . strtoupper(Str::random(6)),
                'user_id' => Auth::id(),
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

            return response()->json([
                'message' => 'Pesanan berhasil dibuat!',
                'order_code' => $order->order_code
            ], 201);

        } catch (\Exception $e) {
           
            return response()->json([
                'message' => 'Gagal membuat pesanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}