<?php

namespace App\Rendering;


interface ResponseRendererInterface
{
    public function render(string $view, array $data = []): void;
}