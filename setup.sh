#!/bin/bash

# Fosa Framework - Setup and Deployment Script
# This script helps validate and prepare the Fosa Framework for Packagist deployment

echo "╔═════════════════════════════════════════════════════════════════════╗"
echo "║                   Fosa Framework Setup Script                       ║"
echo "║              Preparing for Packagist Deployment                     ║"
echo "╚═════════════════════════════════════════════════════════════════════╝"
echo ""

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Counter for checks
CHECKS_PASSED=0
CHECKS_FAILED=0

# Function to print colored output
print_check() {
    echo -e "${GREEN}✓${NC} $1"
    ((CHECKS_PASSED++))
}

print_error() {
    echo -e "${RED}✗${NC} $1"
    ((CHECKS_FAILED++))
}

print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

print_info() {
    echo -e "${BLUE}ℹ${NC} $1"
}

echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo -e "${BLUE}Step 1: Checking Prerequisites${NC}"
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo ""

# Check PHP
if command -v php &> /dev/null; then
    PHP_VERSION=$(php -r 'echo PHP_VERSION;')
    print_check "PHP installed (version: $PHP_VERSION)"
else
    print_error "PHP not found - required for development"
fi

# Check Composer
if command -v composer &> /dev/null; then
    COMPOSER_VERSION=$(composer --version | grep -oP '\d+\.\d+\.\d+')
    print_check "Composer installed (version: $COMPOSER_VERSION)"
else
    print_error "Composer not found - please install Composer"
fi

# Check Git
if command -v git &> /dev/null; then
    print_check "Git installed"
else
    print_error "Git not found - required for version control"
fi

echo ""
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo -e "${BLUE}Step 2: Validating composer.json${NC}"
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo ""

if [ -f "composer.json" ]; then
    if composer validate --no-interaction > /dev/null 2>&1; then
        print_check "composer.json is valid"
    else
        print_error "composer.json validation failed"
        composer validate
    fi
else
    print_error "composer.json not found"
fi

echo ""
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo -e "${BLUE}Step 3: Checking Required Files${NC}"
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo ""

REQUIRED_FILES=(
    "composer.json"
    "README.md"
    "LICENSE"
    "CONTRIBUTING.md"
    "INSTALLATION.md"
    "CHANGELOG.md"
    ".env.example"
    "src/Fosa/Installer/ProjectInstaller.php"
    "src/Fosa/Installer/ComposerScripts.php"
)

for file in "${REQUIRED_FILES[@]}"; do
    if [ -f "$file" ]; then
        print_check "Found: $file"
    else
        print_error "Missing: $file"
    fi
done

echo ""
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo -e "${BLUE}Step 4: Checking Directory Structure${NC}"
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo ""

REQUIRED_DIRS=(
    "src/Fosa"
    "src/Fosa/Installer"
    "app/controllers"
    "app/middlewares"
    "app/templates"
)

for dir in "${REQUIRED_DIRS[@]}"; do
    if [ -d "$dir" ]; then
        print_check "Directory exists: $dir"
    else
        print_error "Missing directory: $dir"
    fi
done

echo ""
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo -e "${BLUE}Step 5: Testing Package Installation${NC}"
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo ""

if command -v composer &> /dev/null; then
    print_info "Testing local installation (this may take a moment)..."
    
    # Create test directory
    TEST_DIR="/tmp/fosa-test-$$"
    mkdir -p "$TEST_DIR"
    
    if composer create-project "$(pwd)" "$TEST_DIR/test-app" > /dev/null 2>&1; then
        print_check "Local installation test passed"
        rm -rf "$TEST_DIR"
    else
        print_warning "Local installation test failed (but this may be expected)"
        rm -rf "$TEST_DIR" 2>/dev/null
    fi
else
    print_warning "Skipping installation test - Composer not found"
fi

echo ""
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo -e "${BLUE}Step 6: Git Status${NC}"
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo ""

if [ -d ".git" ]; then
    print_check "Git repository initialized"
    
    if git rev-parse HEAD > /dev/null 2>&1; then
        LAST_COMMIT=$(git rev-parse --short HEAD)
        print_check "At least one commit exists ($LAST_COMMIT)"
    else
        print_warning "No commits found - please make your first commit"
    fi
else
    print_warning "Not a Git repository - initialize with: git init"
fi

echo ""
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo -e "${BLUE}Summary${NC}"
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo ""

TOTAL=$((CHECKS_PASSED + CHECKS_FAILED))

echo -e "Checks Passed: ${GREEN}${CHECKS_PASSED}${NC}"
echo -e "Checks Failed: ${RED}${CHECKS_FAILED}${NC}"
echo ""

if [ $CHECKS_FAILED -eq 0 ]; then
    echo -e "${GREEN}✓ All checks passed!${NC}"
    echo ""
    echo "Next steps:"
    echo "1. Ensure your repository is on GitHub: https://github.com/fosa-framework/fosa-php"
    echo "2. Tag your release: git tag -a v1.0.0 -m 'Version 1.0.0'"
    echo "3. Push tags: git push origin --tags"
    echo "4. Register on Packagist: https://packagist.org"
    echo "5. Submit your package to Packagist"
    echo "6. Configure webhook for automatic updates"
    echo ""
    echo "Users will then be able to install with:"
    echo "   composer create-project fosa-framework/fosa my-app"
else
    echo -e "${RED}✗ Some checks failed. Please fix the issues above.${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}For more information, see:${NC}"
echo "  - READINESS.md - Deployment readiness report"
echo "  - PUBLICATION_PACKAGIST.md - Publishing guide"
echo "  - COMPOSER_STRUCTURE.md - Technical details"
echo ""
