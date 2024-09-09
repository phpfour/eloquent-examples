<?php declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ProductPerformanceReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_performance_report_is_displayed()
    {
        // Arrange
        $user = User::factory()->createOne();

        // Act
        $response = $this->actingAs($user)->get(route('reports.product_performance'));

        // Assert
        $response->assertOk();
    }

    public function test_product_performance_report_does_not_display_product_without_orders()
    {
        // Arrange
        $user = User::factory()->createOne();
        $product = Product::factory()->createOne();

        // Act
        $response = $this->actingAs($user)->get(route('reports.product_performance'));

        // Assert
        $response->assertDontSee($product->name);
    }

    public function test_product_performance_report_displays_product_with_orders_in_current_month_by_default()
    {
        // Arrange
        $user = User::factory()->createOne();
        $product = Product::factory()->createOne();
        $order = Order::factory()->createOne();
        $orderLine = OrderLine::factory()->createOne([
            'product_id' => $product->id,
            'order_id' => $order->id,
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('reports.product_performance'));

        // Assert
        $response->assertSee($product->name);
    }

    public function test_product_performance_report_does_not_display_product_with_orders_in_previous_month_by_default()
    {
        // Arrange
        $user = User::factory()->createOne();
        $product = Product::factory()->createOne();
        $order = Order::factory()->createOne([
            'created_at' => now()->subMonth()
        ]);
        $orderLine = OrderLine::factory()->createOne([
            'product_id' => $product->id,
            'order_id' => $order->id,
            'created_at' => now()->subMonths()
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('reports.product_performance'));

        // Assert
        $response->assertDontSee($product->name);
    }

    public function test_product_performance_report_displays_product_with_orders_in_previous_month_for_last_month_date_range()
    {
        // Arrange
        $user = User::factory()->createOne();
        $product = Product::factory()->createOne();
        $order = Order::factory()->createOne([
            'created_at' => now()->subMonth()
        ]);
        $orderLine = OrderLine::factory()->createOne([
            'product_id' => $product->id,
            'order_id' => $order->id,
            'created_at' => now()->subMonths()
        ]);

        // Act
        $response = $this->actingAs($user)->post(route('reports.product_performance'), [
            'start_date' => now()->subMonth()->startOfMonth(),
            'end_date' => now()->subMonth()->endOfMonth(),
        ]);

        // Assert
        $response->assertSee($product->name);
    }
}
