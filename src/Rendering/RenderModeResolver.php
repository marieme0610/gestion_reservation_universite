<?php

namespace App\Rendering;


class RenderModeResolver
{
    private string $mode = 'html';

    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }

    public function getMode(): string
    {
        return $this->mode;
    }
}