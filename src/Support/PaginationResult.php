<?php

namespace App\Support;

use Illuminate\Pagination\LengthAwarePaginator;

final class PaginationResult
{
    public function __construct(
        public readonly array $items,
        public readonly int $total,
        public readonly int $page,
        public readonly int $parPage
    ) {}

    public static function depuisEloquent(LengthAwarePaginator $paginator): self
    {
        return new self(
            $paginator->items(),
            $paginator->total(),
            $paginator->currentPage(),
            $paginator->perPage()
        );
    }

    public function totalPages(): int
    {
        return max(1, (int) ceil($this->total / $this->parPage));
    }

    public function aPagePrecedente(): bool
    {
        return $this->page > 1;
    }

    public function aPageSuivante(): bool
    {
        return $this->page < $this->totalPages();
    }
}