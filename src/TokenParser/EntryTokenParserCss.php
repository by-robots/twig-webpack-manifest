<?php

namespace ByRobots\TwigWebpackManifestExtension\TokenParser;

class EntryTokenParserCss extends AbstractWebpackTokenParser
{
    /**
     * Return the Twig tag that corresponds to this parser.
     *
     * @return string
     */
    public function getTag(): string
    {
        return 'webpack_css';
    }

    /**
     * @inheritDoc
     */
    protected function render(string $path): string
    {
        return '<link type="text/css" href="' . $this->entryUri($path) . '" rel="stylesheet">';
    }
}
