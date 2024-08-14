<?php declare(strict_types=1);

namespace App\DataTransferObjects;

final class PostDTO
{
    public function __construct(
        public int $id,
        public ?string $title = null,
        public ?string $body = null,
        public ?\DateTimeImmutable $publishedAt = null
    ) {
    }
}
