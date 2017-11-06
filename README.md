Twig Webpack manifest
=========================

## Introduction

Injects CSS/JS in HTML templates, based on the generated Webpack manifest.json

## Instalation

The easiest way to install GTwig Webpack manifest is through [Composer](http://getcomposer.org).

```bash
composer require tde/twig-webpack-manifest
```

Requirements
------------
 - [PHP >= 5.3](http://php.net/releases/5_3_0.php)
 - [Twig 1.2+ or 2.x](https://twig.symfony.com)

Basic usage
-----------

```php
$twig = new Twig_Environment($loader);
$twig->addExtension(new \TDE\TwigWebpackManifestExtension\WebpackExtension(
    __DIR__ . '/public/assets/manifest.json'
));
```

```twig
{# base.html.twig #}
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

Maintainers
-------
 - Jordi Kroon | [Github](https://github.com/jordikroon) | [Twitter](https://twitter.com/jordi12100)
 - John van Hulsen | [Github](https://github.com/johnvanhulsen) | [Twitter](https://twitter.com/johnvanhulsen)
 

[TDE.nl](https://tde.nl) - We craft digital connections in sports
