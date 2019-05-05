<?php

namespace ByRobots\TwigWebpackManifestExtension\TokenParser;

abstract class AbstractWebpackTokenParser extends \Twig_TokenParser
{
    /**
     * @var string
     */
    protected $manifestFile;

    /**
     * @var string
     */
    protected $publicPrefix;

    /**
     * @param string $manifestFile
     * @param string $publicPrefix
     */
    public function __construct($manifestFile, $publicPrefix)
    {
        $this->manifestFile = $manifestFile;
        $this->publicPrefix = $publicPrefix;
    }

    /**
     * @param \Twig_Token $token
     * @return \Twig_Node_Text
     * @throws \Twig_Error_Loader
     */
    public function parse(\Twig_Token $token)
    {
        $stream = $this->parser->getStream();
        $entryFile = $stream->expect(\Twig_Token::STRING_TYPE)->getValue();
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        if (!file_exists($this->manifestFile)) {
            throw new \Twig_Error_Loader('Webpack manifest file not exists.');
        }

        $manifest = json_decode(file_get_contents($this->manifestFile), true);
        if (!isset($manifest[$entryFile])) {
            throw new \Twig_Error_Loader(
                'Webpack entry ' . $entryFile . ' does not exist in the manifest.json.',
                $token->getLine(),
                $stream->getSourceContext()->getName()
            );
        }

        return new \Twig_Node_Text(
            $this->render($this->publicPrefix . $manifest[$entryFile]),
            $token->getLine()
        );
    }

    /**
     * @param string $entryPath
     * @return string
     */
    abstract protected function render($entryPath);
}
