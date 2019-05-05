<?php

namespace ByRobots\TwigWebpackManifestExtension\TokenParser;

class EntryTokenParserCss extends AbstractWebpackTokenParser
{
    /**
     * @return string
     */
    public function getTag()
    {
        return 'webpack_css';
    }

    /**
     * @param string $path
     * @return string
     */
    protected function render($path)
    {
        return '<link type="text/css" href="' . $this->entryUri($path) . '" rel="stylesheet">';
    }
}
