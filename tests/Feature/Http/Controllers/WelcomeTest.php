<?php declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Tests\TestCase;

final class WelcomeTest extends TestCase
{
    public function test_welcome_page_is_visible()
    {
        // Act
        $response = $this->get('/');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Laravel');
        $response->assertSee('Laracasts');
        $response->assertDontSee('Bangladesh');
        $response->assertSee(route('login'));
        $response->assertDontSee(route('dashboard'));
    }

    public function test_logged_in_user_can_see_dashboard()
    {
        // Arrange
        $user = User::factory()->createOne();

        // Act
        $response = $this->actingAs($user)->get(route('dashboard'));

        // Assert
        $response->assertSee('Dashboard');
        $response->assertSee($user->name);
    }
}
