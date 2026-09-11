<?php

namespace App\Middleware;

use App\Rendering\RenderModeResolver;

class RenderModeMiddleware implements MiddlewareInterface
{
    public function __construct(private RenderModeResolver $resolver) {}

    public function verifier(): void
    {
        $mode = $_ENV['RENDER_MODE'] ?? 'html';
        $this->resolver->setMode($mode);
    }
}