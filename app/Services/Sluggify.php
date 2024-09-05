<?php declare(strict_types=1);

namespace App\Services;

final class Sluggify
{
    public function getSlug(string $text): string
    {
        $slug = strtolower($text);
        $slug = str_replace(' ', '-', $slug);
        $slug = str_replace('"', '', $slug);
        $slug = str_replace(':', '', $slug);

        return $slug;
    }
}
