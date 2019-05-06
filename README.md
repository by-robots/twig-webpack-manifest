# Twig Webpack Manifest

## Introduction

Injects the correct CSS and JS files from a manifest file into a Twig template.

Forked from [https://github.com/tdeNL/twig-webpack-manifest](tdeNL/twig-webpack-manifest)
and modified to:

- support manifest files at a remote URL; this allows for Hot Module Replacement.

## Installation

```bash
composer require by-robots/twig-webpack-manifest
```

## Requirements

- [PHP >= 7.2](http://php.net/releases/7_2_0.php)
- [Twig 1.2+ or 2.x](https://twig.symfony.com)

## Basic usage

First, extend Twig:

```php
$twig = new Twig_Environment($loader);
$twig->addExtension(new \ByRobots\TwigWebpackManifestExtension\WebpackExtension(
    __DIR__ . '/public/assets/manifest.json',
    []
));
```

Once Twig is entended, you can load files from the manifest file in your Twig
templates like so:

```twig
<!DOCTYPE html>
<html>
    <head>
        {# ... #}
        {% webpack_css 'app.css' %}
    </head>

    <body>
        {# ... #}
        {% webpack_js 'vendor.js' %}
        {% webpack_js 'app.js' %}
    </body>
</html>
```

## Options

Options can be specified with an array of key => value pairs sent as the second
argument to the `\ByRobots\TwigWebpackManifestExtension\WebpackExtension`
constructor.

Available options are as follows:

- `missingResources` (_string_): How to handle a missing resource. When a file
is not found the extension will handle it as either with an `exception`, or
will do `nothing`. **Default:** `exception`.
- `publicPath` (_string_): Will be prepended to the URL to the resource. For
example, if the entry for `main.js` in the manifest file is `/foo/main.js` and
`publicPath` has a value of `https://www.by-robots.dev` then the returned URL
will be `https://by-robots.dev/foo/main.js`. **Default:** ``.

## TODOs

- [ ] Add unit tests.
- [ ] Re-feactor options so option existence doesn't have to keep being checked.
