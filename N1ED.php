<?php

namespace EnjoysCMS\WYSIWYG\N1ED;

use EnjoysCMS\Core\Components\Helpers\Assets;
use EnjoysCMS\Core\Components\WYSIWYG\WysiwygInterface;
use EnjoysCMS\WYSIWYG\TinyMCE\TinyMCE;

class N1ED implements WysiwygInterface
{
    private string $twigTemplate;
    private string $apiKey;

    public function __construct(string $twigTemplate = null, string $apiKey = null)
    {
        new TinyMCE();
        $this->initialize();

        $this->twigTemplate = $twigTemplate ?? '@wysisyg/n1ed-tinymce/n1ed.twig';
        $this->apiKey = $apiKey ?? $_ENV['N1ED_API_KEY'] ?? '';
    }

    public function getTwigTemplate()
    {
        return $this->twigTemplate;
    }

    private function initialize()
    {
        Assets::createSymlink(
            $_ENV['PUBLIC_DIR'] . '/assets/WYSIWYG/tinymce/node_modules/tinymce/plugins/n1ed',
            __DIR__ . '/plugins/n1ed'
        );
//        Assets::js(__DIR__ . '/plugins/n1ed/plugin.min.js');
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }
}