<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Halaman utama user 
    public function index()
    {
        // Ambil semua layanan
        $services = Service::all();

        //ambil data user
        $user = Auth::user();

        $latestOrder = null;
        $totalOrder = 0;
        $totalExpense = 0;
        $points = 0;

        if ($user) {
            // Statistik
            $orders = Order::where('user_id', $user->id)->get();
            $totalOrder = $orders->count();
            $totalExpense = $orders->sum('total_price');
            $points = $user->points ?? 0;

            //tracking
            $latestOrder = Order::where('user_id', $user->id)
                ->with('service')
                ->latest()
                ->first();
        }

        return view('user.userpage', compact(
            'services', 
            'user', 
            'latestOrder', 
            'totalOrder', 
            'totalExpense', 
            'points'
        ));
    }
}
