# Changelog

All notable changes to the Fosa Framework will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-12-30

### Added
- Initial stable release of Fosa Framework
- Lightweight PHP web framework with minimal dependencies
- PSR-4 autoloading support
- Request/Response handling
- Router system for URL routing
- Template engine for view rendering
- Middleware support for request/response pipeline
- Session management
- Database abstraction layer with MySQL driver
- Repository pattern for data access
- Email support via PHPMailer
- Multi-language/Locale support
- Error and Exception handling
- Comprehensive installer for Composer
- Environment configuration management
- Complete documentation and examples

### Features
- **Framework Core**
  - Controller base class
  - Request object for HTTP requests
  - Response object for HTTP responses
  - Router for URL routing
  - Template engine for views
  - Middleware pipeline
  - Session handler
  - Error handler

- **Database**
  - Database abstraction layer
  - MySQL driver implementation
  - EntityManager for ORM-like functionality
  - Repository pattern
  - Basic CRUD operations

- **Additional Features**
  - PHPMailer integration for email
  - Stripe integration for payments
  - Multi-language support with locales
  - Configuration management
  - Environment variables support

- **Developer Tools**
  - Composer installer with automatic setup
  - Example controller and template
  - .env.example for configuration
  - Apache .htaccess configuration
  - Built-in development server

### Security
- Environment variable protection
- Session management
- Input validation framework
- Error suppression for production

### Documentation
- README with quick start guide
- Installation guide in French and English
- Contributing guidelines
- MIT License
- Composer integration

## [0.1.0] - Beta

### Initial Development
- Beta version with core functionality
- Community feedback incorporated
- Foundation for 1.0 release

---

## Guidelines for Future Versions

### When releasing new versions:
1. Update the version in `composer.json`
2. Add changes to this file under a new version heading
3. Tag the release in Git
4. Push to GitHub

### Version Format
- MAJOR.MINOR.PATCH (e.g., 1.0.1)
- Use semantic versioning
- Document breaking changes clearly

### Change Categories
- **Added**: New features
- **Changed**: Changes in existing functionality
- **Deprecated**: Soon-to-be removed features
- **Removed**: Removed features
- **Fixed**: Bug fixes
- **Security**: Security vulnerability fixes
