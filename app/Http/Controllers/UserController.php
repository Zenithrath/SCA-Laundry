<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getLandingData()
    {
        try {
            $services = Service::all();
            $user = Auth::user();
            
            $userData = null;
            $latestOrder = null;

            if ($user) {
                $orders = Order::where('user_id', $user->id)->get();
                
                $userData = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'total_order' => $orders->count(),
                    'total_expense' => $orders->sum('total_price'),
                    'points' => floor($orders->sum('total_price') / 10000),
                ];

                $latestOrderObj = Order::where('user_id', $user->id)
                    ->with('service')
                    ->latest()
                    ->first();

                if ($latestOrderObj) {
                    $latestOrder = [
                        'id' => $latestOrderObj->order_code,
                        'service' => $latestOrderObj->service->name,
                        'weight' => $latestOrderObj->weight,
                        'total' => $latestOrderObj->total_price,
                        'status' => $latestOrderObj->status,
                    ];
                }
            }

            return response()->json([
                'services' => $services,
                'user' => $userData,
                'latest_order' => $latestOrder,
                'is_logged_in' => Auth::check(),
                'role' => $user ? $user->role : 'guest'
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}