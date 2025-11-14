#!/bin/bash

# BookKu Quick Deploy Script for Railway
# This script helps you quickly deploy BookKu to Railway

set -e

echo "======================================"
echo "  BookKu - Quick Deploy to Railway  "
echo "======================================"
echo ""

# Check if Railway CLI is installed
if ! command -v railway &> /dev/null; then
    echo "⚠️  Railway CLI not found!"
    echo ""
    echo "Installing Railway CLI..."
    npm install -g @railway/cli
    echo "✅ Railway CLI installed!"
    echo ""
fi

# Login to Railway
echo "🔐 Logging in to Railway..."
railway login

# Check if already in a Railway project
if railway status &> /dev/null; then
    echo "✅ Already linked to a Railway project"
else
    echo ""
    echo "📦 Initializing new Railway project..."
    railway init
fi

# Add MySQL database
echo ""
echo "🗄️  Setting up MySQL database..."
read -p "Do you want to add MySQL database? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    railway add -d mysql
    echo "✅ MySQL database added!"
fi

# Set environment variables
echo ""
echo "⚙️  Setting environment variables..."
railway variables set CI_ENVIRONMENT=production

# Deploy the application
echo ""
echo "🚀 Deploying to Railway..."
railway up

# Generate domain
echo ""
read -p "Do you want to generate a public domain? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    railway domain
    echo "✅ Domain generated!"
fi

echo ""
echo "======================================"
echo "  ✅ Deployment Complete!            "
echo "======================================"
echo ""
echo "📝 Next steps:"
echo "1. Import database schema:"
echo "   railway connect mysql"
echo "   mysql> SOURCE db_bookku.sql;"
echo ""
echo "2. Open your application:"
echo "   railway open"
echo ""
echo "3. View logs:"
echo "   railway logs"
echo ""
echo "🎉 Your BookKu app is now live!"
echo ""
