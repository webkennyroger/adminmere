---
description: How to fix the missing Google Maps issue
---

To fix the issue where maps are not appearing on the web or in the app, you need to set your Google Maps API Key in the server's environment.

1. Open the `.env` file in `c:\Users\Defensoria\Herd\adminmere\.env`.
2. Find the line that starts with `GOOGLE_MAPS_KEY=`.
3. Add your Google Maps API Key after the equals sign (e.g., `GOOGLE_MAPS_KEY=AIza...`).
4. Save the file.
5. Restart your local server if necessary.

// turbo
6. Run the following command to clear the configuration cache:
```powershell
php artisan config:clear
```
