<?php

namespace ByRobots\TwigWebpackManifestExtension\TokenParser;

class EntryTokenParserJs extends AbstractWebpackTokenParser
{
    /**
     * Return the Twig tag that corresponds to this parser.
     *
     * @return string
     */
    public function getTag(): string
    {
        return 'webpack_js';
    }

    /**
     * @inheritDoc
     */
    protected function render(string $path): string
    {
        return '<script type="text/javascript" src="' . $this->entryUri($path) . '"></script>';
    }
}
