#!/bin/bash
echo "=== Fixing Storage Symlink ==="
cd /var/www/adminmere

echo "1. Removing old symlink..."
rm -f public/storage

echo "2. Creating new symlink..."
ln -s ../storage/app/public public/storage

echo "3. Checking symlink..."
ls -la public/storage

echo ""
echo "4. Checking if photos exist..."
ls -la storage/app/public/posts/1/ 2>/dev/null | head -10

echo ""
echo "5. Setting permissions..."
chown -R www-data:www-data storage/app/public
chmod -R 755 storage/app/public

echo ""
echo "=== DONE ==="
echo "Now reload the page and images should work!"
