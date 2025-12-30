# Contributing to Fosa Framework

Thank you for your interest in contributing to Fosa Framework! We welcome contributions from the community. This document provides guidelines and instructions for contributing.

## Code of Conduct

Please be respectful and constructive in all interactions with other contributors.

## How to Contribute

### Reporting Bugs

1. Check existing issues to avoid duplicates
2. Create a detailed issue report including:
   - PHP version
   - Framework version
   - Step-by-step reproduction instructions
   - Expected behavior
   - Actual behavior
   - Any relevant code snippets or stack traces

### Suggesting Enhancements

1. Open an issue describing the feature
2. Explain the use case and benefits
3. Provide examples if possible

### Submitting Pull Requests

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Add or update tests as needed
5. Ensure all tests pass
6. Commit your changes (`git commit -m 'Add amazing feature'`)
7. Push to the branch (`git push origin feature/amazing-feature`)
8. Open a Pull Request with a clear description

## Development Setup

```bash
# Clone the repository
git clone https://github.com/fosa-framework/fosa-php.git
cd fosa-php

# Install dependencies
composer install

# Run tests
./vendor/bin/phpunit
```

## Coding Standards

- Follow PSR-2 and PSR-4 standards
- Use meaningful variable and function names
- Add PHPDoc comments for all public methods
- Write clean, readable code
- Include tests for new features

## Testing

- Write unit tests for new features
- Ensure all existing tests pass
- Aim for good test coverage
- Test edge cases and error conditions

## Documentation

- Update README.md if adding features
- Add PHPDoc comments to your code
- Update changelog if making significant changes

## Commit Messages

- Use clear, descriptive commit messages
- Reference issues when applicable (e.g., "Fixes #123")
- Use present tense ("Add feature" not "Added feature")

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

## Questions?

Feel free to contact the maintainers or open an issue if you have questions.

Thank you for contributing to Fosa Framework!
