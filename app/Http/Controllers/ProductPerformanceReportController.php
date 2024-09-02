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

    public function deferred(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        if ($request->method() === 'POST') {
            $generatedReport = GeneratedReport::create([
                'name' => 'Product Performance Report',
                'user_id' => auth()->id(),
                'status' => 'pending',
                'criteria' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ],
            ]);

            GenerateProductPerformanceReportJob::dispatch($generatedReport);

            return redirect()->route('reports.product_performance.def')->with('success', 'Report is being generated. You will be notified once it is ready.');
        }

        $generatedReports = GeneratedReport::query()
            ->whereBelongsTo(Auth::user())
            ->where('name', 'Product Performance Report')
            ->get();

        return view('reports.product_performance_deferred', [
            'reports' => $generatedReports,
        ]);
    }
}
