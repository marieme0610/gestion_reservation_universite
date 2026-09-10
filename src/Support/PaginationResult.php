<?php

namespace App\Support;

final class PaginationResult
{
    public function __construct(
        public readonly array $items,
        public readonly int $total,
        public readonly int $page,
        public readonly int $parPage
    ) {}

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