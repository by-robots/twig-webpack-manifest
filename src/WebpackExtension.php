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
     * Options dictating how to handle the Twig tag.
     *
     * @var array
     */
    protected $options;

    /**
     * Engage!
     *
     * @param string $manifestFile
     * @param array $options
     */
    public function __construct(string $manifestFile, array $options = [])
    {
        $this->manifestFile = $manifestFile;
        $this->options = $options;
    }

    /**
     * Get the token parsers.
     *
     * @return array
     */
    public function getTokenParsers(): array
    {
        return array(
            new TokenParser\EntryTokenParserJs($this->manifestFile, $this->options),
            new TokenParser\EntryTokenParserCss($this->manifestFile, $this->options),
        );
    }
}
