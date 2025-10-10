# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Support for Twig 3.x
- Support for PHP 8.0+
- Support for PHPUnit 9.6+
- Multi-extension support (.twig, .ctp, and custom extensions)
- Configure-based cache configuration with `TwigView.cache`
- Custom Twig extensions support via `Configure::write('TwigView.extensions', [...])`
- Comprehensive test suite (81 tests, 141 assertions)
- Test coverage for:
  - Element tag rendering
  - Theme support
  - Layout rendering
  - Custom file extensions
  - `_getViewFileName()` method
  - Multi-path template loading
- Permanent test fixtures in `tests/test_app/templates/`
- `.editorconfig` for consistent coding style
- `.gitattributes` for Git configuration
- `phpcs.xml` for PHP CodeSniffer configuration
- `phpunit.xml.dist` for PHPUnit configuration

### Changed
- Updated from Twig 1.x to Twig 3.x API
  - `Twig_Filter` → `TwigFilter`
  - `Twig_Node` → `TwigNode`
  - `Twig_TokenParser` → `TokenParser`
  - `Twig_Compiler` → `Compiler`
- Migrated tests from PHPUnit 3.x to PHPUnit 9.6+
- Replaced regex assertions with exact assertions for better test precision
- Fixed trans node binary output issue by removing `$return` flag from `__()` and `__n()`
- Extension initialization now preserves custom extensions from Controller
- Cache path configuration moved to Configure with fallback to `TMP . 'views'`
- Optimized loop in constructor to avoid `count()` in loop condition
- Improved code organization with early return pattern in `_render()`
- Moved `ob_start()` closer to actual rendering for better performance
- All test files now use permanent fixtures instead of temporary files
- Theme test files moved to `tests/test_app/templates/Themed/`
- README updated with current requirements and configuration examples
- Renamed `license` to `LICENSE` for consistency
- Renamed `readme.md` to `README.md` for consistency

### Fixed
- File extension handling after parent constructor call
- Proper support for multiple View paths in Twig loader
- Trans tag rendering now outputs strings correctly instead of binary values
- Code now fully compliant with PSR-2 and PHP CodeSniffer standards

### Removed
- Twig submodule (now uses Composer dependency)
- Global `TWIG_VIEW_CACHE` constant (replaced with Configure)
- Example layout template files (outdated)
- Temporary test file generation
- Unused imports and variables
- `tmp/views/` directory structure

## [0.5.0] - Previous Release

Initial release with Twig 1.x support for CakePHP 2.x.
