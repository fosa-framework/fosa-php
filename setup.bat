@echo off
REM Fosa Framework - Setup and Deployment Script (Windows)
REM This script helps validate and prepare the Fosa Framework for Packagist deployment

setlocal enabledelayedexpansion

cls
echo.
echo ╔═════════════════════════════════════════════════════════════════════╗
echo ║                   Fosa Framework Setup Script                       ║
echo ║              Preparing for Packagist Deployment                     ║
echo ╚═════════════════════════════════════════════════════════════════════╝
echo.

set CHECKS_PASSED=0
set CHECKS_FAILED=0

REM ============================================================
REM Step 1: Checking Prerequisites
REM ============================================================
echo.
echo ════════════════════════════════════════════════════════════
echo Step 1: Checking Prerequisites
echo ════════════════════════════════════════════════════════════
echo.

where php >nul 2>nul
if %errorlevel% equ 0 (
    for /f "tokens=*" %%i in ('php -r "echo PHP_VERSION;"') do set PHP_VERSION=%%i
    echo [OK] PHP installed (version: !PHP_VERSION!)
    set /a CHECKS_PASSED+=1
) else (
    echo [FAIL] PHP not found - required for development
    set /a CHECKS_FAILED+=1
)

where composer >nul 2>nul
if %errorlevel% equ 0 (
    echo [OK] Composer installed
    set /a CHECKS_PASSED+=1
) else (
    echo [FAIL] Composer not found - please install Composer
    set /a CHECKS_FAILED+=1
)

where git >nul 2>nul
if %errorlevel% equ 0 (
    echo [OK] Git installed
    set /a CHECKS_PASSED+=1
) else (
    echo [FAIL] Git not found - required for version control
    set /a CHECKS_FAILED+=1
)

REM ============================================================
REM Step 2: Validating composer.json
REM ============================================================
echo.
echo ════════════════════════════════════════════════════════════
echo Step 2: Validating composer.json
echo ════════════════════════════════════════════════════════════
echo.

if exist composer.json (
    composer validate --no-interaction >nul 2>nul
    if %errorlevel% equ 0 (
        echo [OK] composer.json is valid
        set /a CHECKS_PASSED+=1
    ) else (
        echo [FAIL] composer.json validation failed
        set /a CHECKS_FAILED+=1
        composer validate
    )
) else (
    echo [FAIL] composer.json not found
    set /a CHECKS_FAILED+=1
)

REM ============================================================
REM Step 3: Checking Required Files
REM ============================================================
echo.
echo ════════════════════════════════════════════════════════════
echo Step 3: Checking Required Files
echo ════════════════════════════════════════════════════════════
echo.

set FILES=composer.json README.md LICENSE CONTRIBUTING.md INSTALLATION.md CHANGELOG.md .env.example
for %%F in (%FILES%) do (
    if exist %%F (
        echo [OK] Found: %%F
        set /a CHECKS_PASSED+=1
    ) else (
        echo [FAIL] Missing: %%F
        set /a CHECKS_FAILED+=1
    )
)

if exist "src\Fosa\Installer\ProjectInstaller.php" (
    echo [OK] Found: src\Fosa\Installer\ProjectInstaller.php
    set /a CHECKS_PASSED+=1
) else (
    echo [FAIL] Missing: src\Fosa\Installer\ProjectInstaller.php
    set /a CHECKS_FAILED+=1
)

if exist "src\Fosa\Installer\ComposerScripts.php" (
    echo [OK] Found: src\Fosa\Installer\ComposerScripts.php
    set /a CHECKS_PASSED+=1
) else (
    echo [FAIL] Missing: src\Fosa\Installer\ComposerScripts.php
    set /a CHECKS_FAILED+=1
)

REM ============================================================
REM Step 4: Checking Directory Structure
REM ============================================================
echo.
echo ════════════════════════════════════════════════════════════
echo Step 4: Checking Directory Structure
echo ════════════════════════════════════════════════════════════
echo.

set DIRS=src\Fosa src\Fosa\Installer app\controllers app\middlewares app\templates
for %%D in (%DIRS%) do (
    if exist %%D\ (
        echo [OK] Directory exists: %%D
        set /a CHECKS_PASSED+=1
    ) else (
        echo [FAIL] Missing directory: %%D
        set /a CHECKS_FAILED+=1
    )
)

REM ============================================================
REM Step 5: Git Status
REM ============================================================
echo.
echo ════════════════════════════════════════════════════════════
echo Step 5: Git Status
echo ════════════════════════════════════════════════════════════
echo.

if exist ".git\" (
    echo [OK] Git repository initialized
    set /a CHECKS_PASSED+=1
    
    git rev-parse HEAD >nul 2>nul
    if %errorlevel% equ 0 (
        for /f "tokens=*" %%i in ('git rev-parse --short HEAD') do set COMMIT=%%i
        echo [OK] At least one commit exists (!COMMIT!)
        set /a CHECKS_PASSED+=1
    ) else (
        echo [WARN] No commits found - please make your first commit
    )
) else (
    echo [WARN] Not a Git repository - initialize with: git init
)

REM ============================================================
REM Summary
REM ============================================================
echo.
echo ════════════════════════════════════════════════════════════
echo Summary
echo ════════════════════════════════════════════════════════════
echo.

echo Checks Passed: %CHECKS_PASSED%
echo Checks Failed: %CHECKS_FAILED%
echo.

if %CHECKS_FAILED% equ 0 (
    echo [SUCCESS] All checks passed!
    echo.
    echo Next steps:
    echo 1. Ensure your repository is on GitHub: https://github.com/fosa-framework/fosa-php
    echo 2. Tag your release: git tag -a v1.0.0 -m "Version 1.0.0"
    echo 3. Push tags: git push origin --tags
    echo 4. Register on Packagist: https://packagist.org
    echo 5. Submit your package to Packagist
    echo 6. Configure webhook for automatic updates
    echo.
    echo Users will then be able to install with:
    echo    composer create-project fosa-framework/fosa my-app
) else (
    echo [ERROR] Some checks failed. Please fix the issues above.
    pause
    exit /b 1
)

echo.
echo For more information, see:
echo   - READINESS.md - Deployment readiness report
echo   - PUBLICATION_PACKAGIST.md - Publishing guide
echo   - COMPOSER_STRUCTURE.md - Technical details
echo.

pause
