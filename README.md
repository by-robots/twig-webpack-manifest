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
    __DIR__ . '/public/assets/manifest.json'
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
