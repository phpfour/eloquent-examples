<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateProductPerformanceReportJob;
use App\Models\GeneratedReport;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProductPerformanceReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $key = sha1("product_performance_report_$startDate-$endDate");

        $products = Cache::remember($key, 30 * 60, function () use ($startDate, $endDate) {
            return Product::query()
                ->whereHas('orderLines', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                })
                ->withCount('orderLines')
                ->withSum('orderLines', 'quantity')
                ->orderByDesc('order_lines_count')
                ->limit(25)
                ->get();
        });

        return view('reports.product_performance', [
            'products' => $products,
        ]);
    }
}
