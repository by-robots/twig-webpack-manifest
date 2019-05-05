<?php

namespace ByRobots\TwigWebpackManifestExtension\TokenParser;

abstract class AbstractWebpackTokenParser extends \Twig_TokenParser
{
    /**
     * Path to the manifest file.
     *
     * @var string
     */
    protected $manifestFile;

    /**
     * Options for modifying the output.
     *
     * @var array
     */
    protected $options;

    /**
     * @param string $manifestFile
     * @param array $options
     */
    public function __construct(string $manifestFile, array $options = [])
    {
        $this->manifestFile = $manifestFile;
        $this->options = $options;
    }

    /**
     * Parse the Twig tag.
     *
     * @param \Twig_Token $token
     *
     * @return \Twig_Node_Text
     * @throws \Twig_Error_Loader
     */
    public function parse(\Twig_Token $token): \Twig_Node_Text
    {
        // Get the entry to check for from Twig.
        $stream = $this->parser->getStream();
        $entryFile = $stream->expect(\Twig_Token::STRING_TYPE)->getValue();
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        // Get the manifest file's contents.
        $manifestContent = file_get_contents($this->manifestFile);
        if ($manifestContent === false) {
            throw new \Twig_Error_Loader(
                'Manifest file can not be read',
                $token->getLine(),
                $stream->getSourceContext()->getName()
            );
        }

        // Get the entry from the manifest file.
        $manifest = json_decode($manifestContent, true);
        if (!isset($manifest[$entryFile])) {
            throw new \Twig_Error_Loader(
                'Entry `' . $entryFile . '` does not exist in the manifest file',
                $token->getLine(),
                $stream->getSourceContext()->getName()
            );
        }

        // Render the HTML required to include the entry.
        return new \Twig_Node_Text(
            $this->render($manifest[$entryFile]),
            $token->getLine()
        );
    }

    /**
     * Build the path to the entry.
     *
     * @param string $entry
     *
     * @return string
     */
    protected function entryUri(string $entry): string
    {
        $prepend = '';
        if (!empty($this->options['publicPath'])) {
            $prepend = $this->options['publicPath'];
        }

        return "$prepend$entry";
    }

    /**
     * Renders the HTML required for the entry.
     *
     * @param string $entryPath
     *
     * @return string
     */
    abstract protected function render(string $entryPath): string;
}
