<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {

        $ongoingCount = Repair::where('status', 'ongoing')->count();
        $pendingCount = Repair::where('status', 'pending')->count();
        $completedTodayCount = Repair::where('status', 'completed')
            ->whereDate('updated_at', today())
            ->count();


        $dailyEstimatesSum = Repair::whereIn('status', ['ongoing', 'pending', 'completed'])
            ->sum(DB::raw('CAST(estimated_cost AS NUMERIC)'));

      
        $repairs = Repair::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.dashboard', compact(
            'ongoingCount',
            'pendingCount',
            'completedTodayCount',
            'dailyEstimatesSum',
            'repairs'
        ));
    }
}
