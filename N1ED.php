<?php


namespace EnjoysCMS\WYSIWYG\N1ED;


use App\Components\Helpers\Assets;
use App\Components\WYSIWYG\WysiwygInterface;
use EnjoysCMS\WYSIWYG\TinyMCE\TinyMCE;

class N1ED implements WysiwygInterface
{
    private string $twigTemplate;

    public function __construct(string $twigTemplate = null)
    {
        new TinyMCE();
        $this->initialize();

        $this->twigTemplate = $twigTemplate ?? '@wysisyg/n1ed-tinymce/n1ed.twig';

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