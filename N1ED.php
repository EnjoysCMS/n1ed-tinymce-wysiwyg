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
        $this->initialize(new TinyMCE());

        $this->twigTemplate = $twigTemplate ?? '@wysisyg/n1ed-tinymce/n1ed.twig';
        $this->apiKey = $apiKey ?? $_ENV['N1ED_API_KEY'] ?? '';
    }

    public function getTwigTemplate()
    {
        return $this->twigTemplate;
    }

    private function initialize(TinyMCE $tinymce)
    {
        $reflector = new \ReflectionClass($tinymce);
        $path = str_replace($_ENV['PROJECT_DIR'], '', realpath(dirname($reflector->getFileName()).'/..'));

        Assets::createSymlink(
            sprintf('%s/assets%s/node_modules/tinymce/plugins/n1ed', $_ENV['PUBLIC_DIR'], $path),
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