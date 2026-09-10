<?php

namespace App\Controller;

use App\Rendering\ResponseRendererInterface;

abstract class AbstractController
{
    public function __construct(
        private ResponseRendererInterface $renderer
    ) {}

    protected function renderView(string $view, array $data = []): void
    {
        $this->renderer->render($view, $data);
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}