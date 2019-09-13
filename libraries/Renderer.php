<?php

class Renderer
{
    static public function render(string $path, array $variables = [])
    {
        extract($variables);
        ob_start();
        require('../../templates/' . $path . '.phtml');
        $pageContent = ob_get_clean();

        require('../../templates/layout.phtml');
    }

}
