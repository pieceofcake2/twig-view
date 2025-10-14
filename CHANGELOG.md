# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

This is a major release that migrates the codebase to PSR-4 autoloading with proper namespaces, while maintaining full compatibility with CakePHP 2.x and Twig 3.x.

### Added
- **PSR-4 Namespace Structure**
  - New `src/` directory with PSR-4 autoloading
  - All classes now use proper namespaces (`TwigView\*`)
  - Backward compatibility via `src/legacy.php` with `spl_autoload_register`
  - Automatic aliasing of legacy class names (`TwigView`, `CompileShell`)
- **Comprehensive Documentation**
  - `docs/reference.md` - Complete Twig functions and filters reference
  - `docs/helpers.md` - Guide for using CakePHP helpers in Twig
  - `docs/configuration.md` - Advanced configuration options
  - `docs/extensions.md` - Popular Twig extensions guide
- **New Test Coverage**
  - FileLoader tests (22 tests covering path resolution, theme support, template loading)
  - TransTokenParser tests (6 tests for translation tag parsing)
  - LayoutTokenParser tests (4 tests for layout tag parsing)
  - TransNode tests (6 tests for translation node compilation)
  - LayoutNode tests (3 tests for layout node compilation)
  - Total: 290 tests, 408 assertions

### Changed
- **Architecture Migration**
  - Migrated from legacy flat structure to PSR-4 namespaced architecture
  - `Lib/` → `src/Twig/` (Extensions, Nodes, TokenParsers)
  - `View/` → `src/View/` (TwigView class)
  - `Console/Command/` → `src/Console/Command/` (CompileShell)
- **Code Quality Improvements**
  - All code now fully compliant with CakePHP coding standards
  - Removed verbose inline comments, keeping only essential PHPDoc
  - Use `::class` constants instead of string class names in tests
  - Exact string assertions instead of loose `assertStringContainsString`
  - Fixed all PHPCS violations (declare statements, file endings, unused imports)
- **Test Improvements**
  - More precise assertions for compiled Twig code verification
  - Better test organization under `tests/TestCase/Twig/` namespace
  - Improved test naming and documentation
- **Documentation Updates**
  - Simplified README with links to detailed docs
  - Added note about cakephp/twig-view for CakePHP 5.x users
  - Added Twig version badge
  - Added variable expression support documentation for element tag

### Fixed
- Element tag now supports variable expressions (`{% element elementName %}`)
- PHPCS configuration updated to check only existing directories
- Removed references to non-existent `Twig` and `View` directories in phpcs.xml

### Removed
- Legacy non-namespaced class files from `Lib/` directory
  - `Lib/Cake_Number_Filters.php`
  - `Lib/Twig_Extension_Ago.php`
  - `Lib/Twig_Extension_Basic.php`
  - `Lib/Twig_Extension_I18n.php`
  - `Lib/Twig_Extension_Number.php`
  - `Lib/Twig_Node_Element.php`
  - `Lib/Twig_Node_Trans.php`
  - `Lib/Twig_TokenParser_Element.php`
  - `Lib/Twig_TokenParser_Trans.php`
- Legacy wrapper files
  - `View/TwigView.php`
  - `Console/Command/CompileShell.php`
- Legacy test files from `tests/TestCase/Lib/`
  - `tests/TestCase/Lib/CakeNumberFiltersTest.php`
  - `tests/TestCase/Lib/TwigExtensionAgoTest.php`
  - `tests/TestCase/Lib/TwigExtensionBasicTest.php`
  - `tests/TestCase/Lib/TwigExtensionI18nTest.php`
  - `tests/TestCase/Lib/TwigExtensionNumberTest.php`
  - `tests/TestCase/Lib/TwigNodeElementTest.php`
  - `tests/TestCase/Lib/TwigNodeTransTest.php`
  - `tests/TestCase/Lib/TwigTokenParserElementTest.php`
  - `tests/TestCase/Lib/TwigTokenParserTransTest.php`
  - `tests/TestCase/View/TwigViewHelperTest.php`

### Migration Guide
No code changes are required for existing users. Legacy class names (`TwigView`, `CompileShell`) are automatically aliased to their namespaced equivalents via `src/legacy.php`, which is loaded automatically by Composer.

## [2.0.2] - 2025-10-10

### Changed
- Updated minimum PHP version from 8.0 to 8.1
- GitHub Actions CI workflow now tests PHP 8.1-8.5 (removed PHP 8.0)

## [2.0.1] - 2025-10-10

### Added
- CompileShell command for pre-compiling Twig templates in production
  - Manually writes cache files using Twig 3.x `compileSource()` API
  - Supports both `View/` and `templates/` directory structures
  - Ensures cache is actually used by runtime (verified with rendering output, timestamp, and file count checks)
  - Command: `./Console/cake TwigView.compile all`
  - Comprehensive test coverage (9 tests, 17 assertions)
- GitHub Actions CI workflow
  - PHPUnit tests across PHP 8.1-8.5
  - Code coverage reporting to Codecov and Qlty
  - PHPCS code style checks

## [2.0.0] - 2025-10-10

This is a major release that updates TwigView to support Twig 3.x and PHP 8.1+, while maintaining compatibility with CakePHP 2.x.

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

## Earlier Versions

This project was forked from [predominant/TwigView](https://github.com/predominant/TwigView), which itself was forked from [m3nt0r-legacy/cakephp-twig-view](https://github.com/m3nt0r-legacy/cakephp-twig-view).

The original repositories supported Twig 1.x with CakePHP 2.x but are now archived and no longer maintained.
