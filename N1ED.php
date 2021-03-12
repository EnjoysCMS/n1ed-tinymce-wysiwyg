<?php


namespace EnjoysCMS\WYSIWYG\N1ED;


use App\Components\Helpers\Assets;
use App\Components\WYSIWYG\WysiwygInterface;

class N1ED implements WysiwygInterface
{
    private string $twigTemplate;

    public function __construct(string $twigTemplate = null)
    {
        $this->twigTemplate = $twigTemplate ?? '@wysisyg/n1ed-tinymce/n1ed.twig';
        $this->initialize();
    }

    public function getTwigTemplate()
    {
        return $this->twigTemplate;
    }

    private function initialize()
    {
        Assets::js(__DIR__ . '/plugins/n1ed/plugin.min.js');
    }
}