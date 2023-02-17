<?php

declare(strict_types=1);

namespace EnjoysCMS\ContentEditor\N1ED;

use Enjoys\AssetsCollector;
use EnjoysCMS\ContentEditor\TinyMCE\TinyMCE;
use EnjoysCMS\Core\Components\ContentEditor\ContentEditorInterface;
use Psr\Log\LoggerInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class N1ED implements ContentEditorInterface
{
    private ?string $selector = null;
    private string $apiKey;

    /**
     * @throws \Exception
     */
    public function __construct(
        TinyMCE $tinyMCE,
        private Environment $twig,
        private LoggerInterface $logger,
        private ?string $template = null,
        string $apiKey = null
    ) {
        $this->initialize($tinyMCE);
        $this->apiKey = $apiKey ?? $_ENV['N1ED_API_KEY'] ?? '';
    }

    private function getTemplate(): ?string
    {
        return $this->template ?? __DIR__ . '/n1ed.twig';
    }


    /**
     * @throws \Exception
     */
    private function initialize(TinyMCE $tinymce): void
    {
        $reflector = new \ReflectionClass($tinymce);
        $path = str_replace(getenv('ROOT_PATH'), '', realpath(dirname($reflector->getFileName()) . '/..'));

        AssetsCollector\Helpers::createSymlink(
            sprintf('%s/assets%s/node_modules/tinymce/plugins/n1ed', $_ENV['PUBLIC_DIR'], $path),
            __DIR__ . '/plugins/n1ed',
            $this->logger
        );
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }


    public function setSelector(string $selector): void
    {
        $this->selector = $selector;
    }

    public function getSelector(): string
    {
        if ($this->selector === null) {
            throw new \RuntimeException('Selector not set');
        }
        return $this->selector;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function getEmbedCode(): string
    {
        $twigTemplate = $this->getTemplate();
        if (!$this->twig->getLoader()->exists($twigTemplate)) {
            throw new \RuntimeException(
                sprintf("ContentEditor: (%s): Нет шаблона в по указанному пути: %s", self::class, $twigTemplate)
            );
        }
        return $this->twig->render(
            $twigTemplate,
            [
                'editor' => $this,
                'selector' => $this->getSelector()
            ]
        );
    }

}
