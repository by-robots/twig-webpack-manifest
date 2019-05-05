<?php

namespace ByRobots\TwigWebpackManifestExtension;

class WebpackExtension extends \Twig_Extension
{
    /**
     * Location of the manifest file.
     *
     * @var string
     */
    protected $manifestFile;

    /**
     * @var string
     */
    protected $publicJavascriptPrefix;

    /**
     * @var string
     */
    protected $publicCssPrefix;

    /**
     * @param string $manifestFile
     * @param string $publicJavascriptPrefix
     * @param string $publicCssPrefix
     */
    public function __construct($manifestFile, $publicJavascriptPrefix = '', $publicCssPrefix = '')
    {
        $this->manifestFile = $manifestFile;
        $this->publicJavascriptPrefix = $publicJavascriptPrefix;
        $this->publicCssPrefix = $publicCssPrefix;
    }

    /**
     * @return array
     */
    public function getTokenParsers()
    {
        return array(
            new TokenParser\EntryTokenParserJs($this->manifestFile, $this->publicJavascriptPrefix),
            new TokenParser\EntryTokenParserCss($this->manifestFile, $this->publicCssPrefix),
        );
    }
}
