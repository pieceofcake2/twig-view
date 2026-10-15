# TwigView plugin for CakePHP 2

[![GitHub License](https://img.shields.io/github/license/pieceofcake2/twig-view?label=License)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/pieceofcake2/twig-view?label=Packagist)](https://packagist.org/packages/pieceofcake2/twig-view)
![PHP](https://img.shields.io/packagist/dependency-v/pieceofcake2/twig-view/php?logo=php&logoColor=%23FFFFFF&label=PHP&labelColor=%23777bb4&color=%23ffffff)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%205-brightgreen?label=PHPStan)](https://github.com/pieceofcake2/twig-view/actions/workflows/CI.yml)
![CakePHP](https://img.shields.io/packagist/dependency-v/pieceofcake2/twig-view/pieceofcake2/cakephp?logo=cakephp&logoColor=%23ffffff&label=CakePHP&labelColor=%23D33C43&color=%23ffffff)
![Twig](https://img.shields.io/packagist/dependency-v/pieceofcake2/twig-view/twig%2Ftwig?logo=data%3Aimage%2Fsvg%2Bxml%3Bbase64%2CPHN2ZyB3aWR0aD0iMTIiIGhlaWdodD0iMTIiIHZpZXdCb3g9IjAgMCAxMiAxMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBjbGlwLXBhdGg9InVybCgjY2xpcDBfMV8xMCkiPjxwYXRoIGQ9Ik0zLjI3MjcxIDAuNzcxNDg0QzQuNzUyMjkgMC41MzM3OCA2LjA5MDU5IDIuNDIxMDcgNi40NzY4MSAyLjk2Mjg5QzcuMTg1NTkgMy45NzY0NyA3LjYyMTQzIDUuMTU1NjQgNy43NDA0OCA2LjM4NjcyQzcuNzI4MDYgNi40MDQwOSA3LjcxNTU0IDYuNDIxOTIgNy43MDMzNyA2LjQzOTQ1QzguMzc2NTIgNS41NTkxNCA5LjQyMzIyIDQuODcwNzcgMTAuMjAzNCA1LjE4OTQ1QzExLjAxNjIgNS41MjE3OCAxMS4yMTggNi44MTE4MyAxMS4xNTM2IDYuODUwNTlDMTEuMDk3NyA2Ljg3OTQ2IDEwLjgxNzQgNi4wMjI5MSAxMC4yNjc4IDUuOTc0NjFDOS43ODM3MSA1LjkzMjY0IDkuMzcyOTEgNi41NjE0OCA5LjMwMDA1IDYuNjcyODVDOS4wMDAwNSA3LjEyODQ4IDguOTI2OTEgNy42MjAwMyA4Ljk2MjE2IDguODMyMDNDOC45ODY4MiA5LjY0MDUgOS4wNDk0MSAxMC40NDc0IDkuMTQ5NjYgMTEuMjVMNi42OTA2NyAxMS4yNTFWMTEuMjVIMy44OTQ3OEMzLjkzMzc4IDEwLjY3MTkgMy45MTE5OSAxMC4wOTExIDMuODI5MzUgOS41MTc1OEMzLjc1ODA5IDguNTU4NDkgMy40Mzk3MSA3LjYzNDM3IDIuOTA2NDkgNi44MzM5OEMyLjAzOTg3IDUuNjg1MzYgMC43NzA0ODYgNS40Mzc0NiAwLjgzOTExMSA1LjIyNTU5QzAuODk0NTEzIDUuMDU4NDEgMS43NjQ4NyA1LjEyOTE1IDIuNTQxMjYgNS4zMzU5NEMzLjE2NDU5IDUuNTAxOTkgNC4xMTg3OCA1LjgzNzExIDUuMjAxNDIgNi43MzI0MkM0Ljg4NzgxIDMuMDA1NzQgNC4xNTY2MiAxLjc4OTk5IDMuMzg1MDEgMS42MTMyOEMyLjY1MjU3IDEuNDQ2MSAxLjgxMzcxIDIuMTk4MjQgMS43MTUwOSAyLjA0ODgzQzEuNjEyMzQgMS44OTU0NSAyLjMxODcxIDAuOTI0NDg0IDMuMjcyNzEgMC43NzE0ODRaIiBmaWxsPSJ3aGl0ZSIvPjwvZz48L3N2Zz4%3D&label=Twig&labelColor=%237fa020&color=%23ffffff)
[![CI](https://img.shields.io/github/actions/workflow/status/pieceofcake2/twig-view/CI.yml?label=CI)](https://github.com/pieceofcake2/twig-view/actions/workflows/CI.yml)
[![Codecov](https://img.shields.io/codecov/c/gh/pieceofcake2/twig-view?label=Coverage)](https://codecov.io/gh/pieceofcake2/twig-view)

pieceofcake2/twig-view integrates the [Twig Templating Language](https://twig.symfony.com/)
(Twig 3.x) with CakePHP 2, providing access to helpers, elements and themes from Twig
templates. It is a modernized fork of predominant/TwigView with PSR-4 namespaces and
PHP 8.1+ support.

> [!NOTE]
> For CakePHP 5.x, use the official [cakephp/twig-view](https://github.com/cakephp/twig-view) package instead.

## Documentation

- Website: https://pieceofcake2.github.io/twig-view/
- Markdown: [docs/README.md](docs/README.md) (for AI tools and offline reading)

The Markdown documentation is also included in the Composer package, in the plugin's directory: `plugins/TwigView/docs/README.md` (the location depends on your `installer-paths`). Install the package with `--dev` if you only need it for development.

## Requirements

- PHP 8.1+
- pieceofcake2/cakephp 2.12+
- Twig 3.x

## Installation

```bash
composer require pieceofcake2/twig-view
```

Then load the plugin and set `TwigView.Twig` as the view class.
See [Installation](docs/README.md#installation) and [Quick Start](docs/README.md#quick-start).

## Contributing

See the [contribution guidelines](https://github.com/pieceofcake2/.github/blob/master/CONTRIBUTING.md).

## License

MIT License. See [LICENSE](LICENSE).
