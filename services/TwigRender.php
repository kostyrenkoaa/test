<?php
namespace App\services;

class TwigRender
{
    /**
     * @param $template
     * @param $params
     * @return string
     * @throws
     */
    public function render($template, $params)
    {
        $loader = new \Twig\Loader\FilesystemLoader([
            dirname(__DIR__ ) . "/views/twig/",
            dirname(__DIR__ ) . "/views/",
        ]);
        $twig = new \Twig\Environment($loader);
        $template .= '.twig';
        return $twig->render($template, $params);
    }
}
