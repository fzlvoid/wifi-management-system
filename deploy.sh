#!/bin/bash
set -e

# ============================================================
# Laravel Deploy Script for cPanel Shared Hosting (Option B)
# Separate folders: net-app/ (above public_html/)
# ============================================================

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
DEPLOY_NAME="deploy-${TIMESTAMP}"
TEMP_DIR="/tmp/${DEPLOY_NAME}"
ZIP_FILE="${PROJECT_DIR}/${DEPLOY_NAME}.zip"

echo "=========================================="
echo "  Laravel Deploy Builder"
echo "  Target: cPanel Shared Hosting (Option B)"
echo "=========================================="
echo ""

# 1. Create temp folder
echo "[1/6] Preparing temp folder..."
rm -rf "${TEMP_DIR}"
mkdir -p "${TEMP_DIR}"

# 2. Copy entire project (except excluded)
echo "[2/6] Copying project files..."
rsync -a \
  --exclude='.git' \
  --exclude='.gitignore' \
  --exclude='.gitattributes' \
  --exclude='.env' \
  --exclude='.env.*' \
  --exclude='node_modules' \
  --exclude='tests' \
  --exclude='phpunit.xml' \
  --exclude='.phpunit.result.cache' \
  --exclude='storage/logs/*' \
  --exclude='storage/framework/cache/*' \
  --exclude='storage/framework/sessions/*' \
  --exclude='storage/framework/views/*' \
  --exclude='storage/framework/testing/*' \
  --exclude='storage/debugbar/*' \
  --exclude='storage/pail/*' \
  --exclude='storage/*.key' \
  --exclude='database/*.sqlite' \
  --exclude='.DS_Store' \
  --exclude='Thumbs.db' \
  --exclude='*.log' \
  --exclude='.idea' \
  --exclude='.vscode' \
  --exclude='.fleet' \
  --exclude='.nova' \
  --exclude='.zed' \
  --exclude='.agents' \
  --exclude='.gemini' \
  --exclude='opencode.json' \
  --exclude='boost.json' \
  --exclude='ponytail-audit-backlog.md' \
  --exclude='AGENTS.md' \
  --exclude='GEMINI.md' \
  --exclude='Dockerfile' \
  --exclude='script-table-mysql.sql' \
  --exclude='script-table-pgsql.sql' \
  --exclude='deploy-*.zip' \
  --exclude='deploy.sh' \
  "${PROJECT_DIR}/" "${TEMP_DIR}/"

# 3. Clean storage folders (keep empty folders)
echo "[3/6] Cleaning storage folders..."
mkdir -p "${TEMP_DIR}/storage/logs"
mkdir -p "${TEMP_DIR}/storage/framework/cache"
mkdir -p "${TEMP_DIR}/storage/framework/sessions"
mkdir -p "${TEMP_DIR}/storage/framework/views"
mkdir -p "${TEMP_DIR}/storage/framework/testing"
mkdir -p "${TEMP_DIR}/storage/debugbar"
mkdir -p "${TEMP_DIR}/storage/pail"
mkdir -p "${TEMP_DIR}/storage/app/public"
mkdir -p "${TEMP_DIR}/storage/app/private"
touch "${TEMP_DIR}/storage/logs/.gitkeep"
touch "${TEMP_DIR}/storage/framework/cache/.gitkeep"
touch "${TEMP_DIR}/storage/framework/sessions/.gitkeep"
touch "${TEMP_DIR}/storage/framework/views/.gitkeep"
touch "${TEMP_DIR}/storage/framework/testing/.gitkeep"
touch "${TEMP_DIR}/storage/debugbar/.gitkeep"
touch "${TEMP_DIR}/storage/pail/.gitkeep"
touch "${TEMP_DIR}/storage/app/public/.gitkeep"
touch "${TEMP_DIR}/storage/app/private/.gitkeep"

# 4. Clean bootstrap/cache (except .gitignore)
echo "[4/6] Cleaning bootstrap/cache..."
rm -f "${TEMP_DIR}/bootstrap/cache/packages.php"
rm -f "${TEMP_DIR}/bootstrap/cache/services.php"
touch "${TEMP_DIR}/bootstrap/cache/.gitkeep"

# 5. Prepare index.php adjusted for Option B
echo "[5/6] Preparing index.php for Option B..."
cat > "${TEMP_DIR}/public/index.php" << 'PHPEOF'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// ponytail: path adjusted for deploy Option B (net-app/ above public_html/)
// If your app folder has a different name, change ../net-app/ to match

$appPath = __DIR__ . '/../net-app';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $appPath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $appPath . '/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $appPath . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
PHPEOF

# 6. Create zip
echo "[6/6] Creating zip..."
cd "$(dirname "${TEMP_DIR}")"
zip -r -q "${ZIP_FILE}" "$(basename "${TEMP_DIR}")"

# 7. Cleanup
echo "Cleaning up temp folder..."
rm -rf "${TEMP_DIR}"

# 8. Info
echo ""
echo "=========================================="
echo "  Deploy zip ready!"
echo "=========================================="
echo "  File: ${DEPLOY_NAME}.zip"
echo "  Size: $(du -h "${ZIP_FILE}" | cut -f1)"
echo "  Location: ${ZIP_FILE}"
echo ""
echo "  Notes:"
echo "  - vendor/ included (Composer not available on cPanel)"
echo "  - public/build/ included (assets already compiled)"
echo "  - .env NOT included (use your production .env)"
echo "  - storage/ cleaned (empty folders, ready to write on server)"
echo ""
echo "  See DEPLOY.md for upload guide to cPanel."
echo "=========================================="
