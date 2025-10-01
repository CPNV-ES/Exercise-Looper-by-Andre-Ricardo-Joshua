<?php

namespace App;

class Renderer
{
    private string $sourceDir;

    public function __construct(string $sourceDir)
    {
        $this->sourceDir = $sourceDir;
    }

    /**
     * Renders the view based on the provided options.
     *
     * @param array $rendering_options Options for rendering, including status code, view, and data.
     * @param string|null $route The current request route, used to adjust the layout.
     */
    public function render(array $rendering_options, ?string $route): void
    {
        // Set a default route if null is passed, to prevent errors in the view.
        $route = $route ?? '';
        $data = $rendering_options['data'] ?? [];
        extract($data);

        // Handle specific status codes like 404 or 500 by rendering an error page.
        if (array_key_exists('status_code', $rendering_options)) {
            http_response_code($rendering_options['status_code']);
            $error_view_path = $this->sourceDir . '/views/errors/' . $rendering_options['status_code'] . '.php';

            // Ensure the error view file exists before trying to include it.
            if (file_exists($error_view_path)) {
                $view_content_path = $error_view_path;
            } else {
                // Fallback for a missing error view.
                $view_content_path = $this->sourceDir . '/views/errors/500.php';
            }
        }
        // Handle regular page rendering.
        elseif (array_key_exists('view', $rendering_options)) {
            $view_content_path = $this->sourceDir . '/' . $rendering_options['view'] . '.php';
        }
        // If no view and no status code is provided, something is wrong.
        else {
            http_response_code(500);
            $view_content_path = $this->sourceDir . '/views/errors/500.php';
        }

        // The $route, $view_content_path, and extracted $data variables are all
        // available in the scope of the included Gabarit.php file.
        include $this->sourceDir . '/views/Gabarit.php';
    }
}
