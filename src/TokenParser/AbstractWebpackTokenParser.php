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

        $manifestContent = file_get_contents($this->manifestFile);
        if ($manifestContent === false) {
            throw new \Twig_Error_Loader(
                'Manifest file can not be read.',
                $token->getLine(),
                $stream->getSourceContext()->getName()
            );
        }

        $manifest = json_decode($manifestContent, true);
        if (!isset($manifest[$entryFile])) {
            throw new \Twig_Error_Loader(
                'Entry `' . $entryFile . '` does not exist in the manifest file.',
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
     * Build the path to the file entry. Prepends the path to the manifest file
     * so that if the manifest file is at a remote domain then the entry file
     * itself will be too.
     *
     * @param string $entry
     *
     * @return string
     */
    protected function entryUri($entry)
    {
        $path = explode('/', $this->manifestFile);
        array_pop($path);
        $path = implode('/', $path);

        return "$path/$entry";
    }

    /**
     * @param string $entryPath
     * @return string
     */
    abstract protected function render($entryPath);
}
