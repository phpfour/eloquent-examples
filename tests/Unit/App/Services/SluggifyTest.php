<?php declare(strict_types=1);

namespace Tests\Unit\App\Services;

use App\Services\Sluggify;
use Tests\TestCase;

final class SluggifyTest extends TestCase
{
    public function test_sluggify_can_convert_text_to_slug()
    {
        // Arrange
        $sluggify = new Sluggify();

        // Act
        $slug = $sluggify->getSlug('Efficiently handling large Eloquent results in Laravel');

        // Assert
        $this->assertEquals('efficiently-handling-large-eloquent-results-in-laravel', $slug);
    }

    public function test_sluggify_can_remove_special_characters()
    {
        // Arrange
        $sluggify = new Sluggify();

        // Act
        $slug = $sluggify->getSlug('Efficiently handling "large" Eloquent results in: Laravel');

        // Assert
        $this->assertEquals('efficiently-handling-large-eloquent-results-in-laravel', $slug);
    }
}
