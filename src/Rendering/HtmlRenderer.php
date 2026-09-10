<?php

namespace App\Rendering;

class HtmlRenderer implements ResponseRendererInterface
{
    public function render(string $view, array $data = []): void
    {
        extract($data);

        $viewPath = __DIR__ . "/../../templates/{$view}.php";

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("La vue [{$view}] est introuvable à l'emplacement : {$viewPath}");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        $layoutPath = __DIR__ . '/../../templates/layout/base.php';

        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            echo $content;
        }
    }
}