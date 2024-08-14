<?php declare(strict_types=1);

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class PostQueryBuilder extends Builder
{
    public function getPostCountWithApprovedComments(): int
    {
        return $this->hasApprovedComments()
            ->count();
    }

    public function getAll(?string $keyword = null)
    {
        return $this->with(['user'])
            ->when($keyword, function (Builder $query) use ($keyword) {
                return $query->keyword($keyword);
            })
            ->withCount(['comments' => function (Builder $query) {
                $query->where('is_approved', true);
            }])
            ->orderBy('published_at', 'desc');
    }

    public function keyword(string $value): self
    {
        return $this->where('title', 'like', '%' . $value . '%');
    }

    public function hasApprovedComments(): self
    {
        return $this->whereHas('comments', function (Builder $query) {
            $query->where('is_approved', true);
        });
    }
}
