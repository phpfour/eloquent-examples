<?php

namespace App\Jobs;

use App\Models\GeneratedReport;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateProductPerformanceReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private GeneratedReport $report)
    {
    }

    public function handle(): void
    {
        $startDate = $this->report->criteria['start_date'];
        $endDate = $this->report->criteria['end_date'];

        $products = Product::query()
            ->whereHas('orderLines', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->withCount('orderLines')
            ->withSum('orderLines', 'quantity')
            ->orderByDesc('order_lines_count')
            ->limit(25)
            ->get();

        $filename = 'product_performance_report_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $csv = fopen(storage_path('app/public/reports/' . $filename), 'w');
        fputcsv($csv, ['Product Name', 'Price', 'Total Orders', 'Total Quantity', 'Revenue']);

        foreach ($products as $product) {
            fputcsv($csv, [
                $product->name,
                $product->price,
                $product->order_lines_count ?? 0,
                $product->order_lines_sum_quantity ?? 0,
                number_format($product->price * ($product->order_lines_sum_quantity ?? 0), 2),
            ]);
        }

        fclose($csv);

        $this->report->update([
            'status' => 'completed',
            'filename' => $filename,
        ]);


    }
}
