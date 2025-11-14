#!/bin/bash

# BookKu Configuration Validation Script
# This script validates all deployment configurations

set -e

echo "======================================"
echo "  BookKu Configuration Validator     "
echo "======================================"
echo ""

ERRORS=0

# Function to check file exists
check_file() {
    if [ -f "$1" ]; then
        echo "✅ $1 exists"
    else
        echo "❌ $1 is missing"
        ERRORS=$((ERRORS + 1))
    fi
}

# Function to validate JSON
validate_json() {
    if python3 -m json.tool "$1" > /dev/null 2>&1; then
        echo "✅ $1 is valid JSON"
    else
        echo "❌ $1 has JSON syntax errors"
        ERRORS=$((ERRORS + 1))
    fi
}

# Check required files
echo "📁 Checking required files..."
check_file "Dockerfile"
check_file "railway.json"
check_file "railway.toml"
check_file "railway-template.json"
check_file "docker-compose.yml"
check_file "db_bookku.sql"
check_file "healthz.php"
check_file "DEPLOYMENT.md"
check_file "deploy-railway.sh"
check_file ".env.example"
check_file "composer.json"
echo ""

# Validate JSON files
echo "🔍 Validating JSON configuration files..."
validate_json "railway.json"
validate_json "railway-template.json"
validate_json "composer.json"
echo ""

# Check if Dockerfile has required commands
echo "🐋 Validating Dockerfile..."
if grep -q "FROM php:8.1-apache" Dockerfile; then
    echo "✅ Dockerfile uses correct base image"
else
    echo "❌ Dockerfile base image not correct"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "EXPOSE 80" Dockerfile; then
    echo "✅ Dockerfile exposes port 80"
else
    echo "❌ Dockerfile doesn't expose port 80"
    ERRORS=$((ERRORS + 1))
fi

if grep -q "composer install" Dockerfile; then
    echo "✅ Dockerfile installs Composer dependencies"
else
    echo "❌ Dockerfile doesn't install dependencies"
    ERRORS=$((ERRORS + 1))
fi
echo ""

# Check database file
echo "🗄️  Checking database schema..."
if [ -s "db_bookku.sql" ]; then
    echo "✅ Database schema file exists and has content"
    
    # Check for required tables
    if grep -q "CREATE TABLE" db_bookku.sql; then
        echo "✅ Database schema contains table definitions"
    else
        echo "⚠️  Database schema might be empty"
    fi
else
    echo "❌ Database schema file is missing or empty"
    ERRORS=$((ERRORS + 1))
fi
echo ""

# Check app configuration
echo "⚙️  Checking application configuration..."
if [ -d "app/Config" ]; then
    echo "✅ CodeIgniter Config directory exists"
    
    if [ -f "app/Config/Database.php" ]; then
        echo "✅ Database configuration file exists"
        
        # Check if it uses environment variables
        if grep -q "getenv('MYSQLHOST')" app/Config/Database.php; then
            echo "✅ Database config uses Railway environment variables"
        else
            echo "⚠️  Database config might not use environment variables"
        fi
    else
        echo "❌ Database configuration file missing"
        ERRORS=$((ERRORS + 1))
    fi
else
    echo "❌ CodeIgniter Config directory missing"
    ERRORS=$((ERRORS + 1))
fi
echo ""

# Check writable directories
echo "📝 Checking writable directories..."
for dir in writable/cache writable/logs writable/session writable/uploads; do
    if [ -d "$dir" ]; then
        echo "✅ $dir exists"
    else
        echo "❌ $dir is missing"
        ERRORS=$((ERRORS + 1))
    fi
done
echo ""

# Check public directory
echo "🌐 Checking public directory..."
if [ -d "public" ]; then
    echo "✅ Public directory exists"
    
    if [ -f "public/index.php" ]; then
        echo "✅ Public index.php exists"
    else
        echo "❌ Public index.php missing"
        ERRORS=$((ERRORS + 1))
    fi
else
    echo "❌ Public directory missing"
    ERRORS=$((ERRORS + 1))
fi
echo ""

# Summary
echo "======================================"
if [ $ERRORS -eq 0 ]; then
    echo "✅ ALL CHECKS PASSED!"
    echo "======================================"
    echo ""
    echo "Your BookKu application is ready for deployment!"
    echo ""
    echo "Next steps:"
    echo "1. Deploy to Railway:"
    echo "   ./deploy-railway.sh"
    echo ""
    echo "2. Or use the Railway button in README.md"
    echo ""
    exit 0
else
    echo "❌ FOUND $ERRORS ERROR(S)"
    echo "======================================"
    echo ""
    echo "Please fix the errors above before deploying."
    echo ""
    exit 1
fi
