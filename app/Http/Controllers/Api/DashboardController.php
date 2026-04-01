<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Item::count();
        
        return response()->json([
            'totalBarang' => $totalBarang
        ]);
    }
}