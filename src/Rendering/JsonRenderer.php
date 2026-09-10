<?php

namespace App\Rendering;

class JsonRenderer implements ResponseRendererInterface
{
    public function render(string $view, array $data = []): void
    {
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }
}