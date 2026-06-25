# Laravel Deploy Guide for cPanel Shared Hosting

> **Option B: Separate Folders** — App in `~/net-app/`, public in `~/public_html/`
> Clean URLs without `/public/` in the address.

---

## 📋 Server Requirements

| Item | Minimum | Notes |
|------|---------|-------|
| PHP | **8.3 or higher** | This project needs PHP ^8.3. Check in cPanel → Select PHP Version. |
| MySQL/MariaDB | 5.7+ | For the app database. |
| Storage Writable | Yes | `storage/` and `bootstrap/cache/` must be writable. |
| Composer | Not needed | `vendor/` is included in the zip. |

---

## 📦 Deploy Files

Files you have:

```
deploy-[timestamp].zip     ← Build output zip
DEPLOY.md                  ← This file (guide)
```

**Zip contents:**
- `net-app/` — Full Laravel app (except `public/` folder)
- `public/` — Public folder (will be moved to `public_html/`)
- `vendor/` — PHP dependencies (included, no `composer install` needed)
- `public/build/` — Compiled frontend assets (Vite)
- Database migrations in `database/migrations/`

**NOT in the zip:**
- `.env` — You provide your own (production file)
- `node_modules/` — Not needed on the server
- `tests/` — Not needed in production
- Logs, cache, session — Folders exist but empty, ready to be written on the server

---

## 🚀 Deploy Steps

### 1. Upload the Zip to cPanel

1. Log in to **cPanel File Manager**
2. Go to the folder **above** `public_html/` (usually `~/` or `/home/username/`)
3. Upload `deploy-[timestamp].zip`
4. Extract the zip — a `net-app/` folder will appear

Folder structure after extract:

```
/home/username/
├── net-app/              ← Laravel app (from zip)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/           ← [1] Will be moved to public_html/
│   ├── resources/
│   ├── routes/
│   ├── storage/          ← Empty, ready to be written
│   ├── vendor/
│   └── ...
├── public_html/          ← [2] Destination for public/
└── ...
```

### 2. Move the `public/` Folder to `public_html/`

In cPanel File Manager:

1. Open `net-app/public/`
2. **Select All** → **Move**
3. Destination: `public_html/` (or `public_html/net-app/` for subdomains)
4. Confirm move

**Note:** If you use a **subdomain** (e.g. `app.domain.com`):
- Extract zip to `~/app-domain-com/`
- Move `public/` to `public_html/app-domain-com/` or your subdomain folder

### 3. Upload the Production `.env` File

1. In File Manager, open `net-app/`
2. Upload your production `.env` file here
3. Make sure `.env` matches your cPanel database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=localhost          # or host from cPanel
   DB_PORT=3306
   DB_DATABASE=database_name
   DB_USERNAME=db_username
   DB_PASSWORD=db_password
   ```

### 4. Set Folder Permissions

These folders **MUST** be writable (chmod 755 or 775):

```bash
# If you have terminal access (optional):
chmod -R 775 /home/username/net-app/storage
chmod -R 775 /home/username/net-app/bootstrap/cache
chmod -R 775 /home/username/net-app/storage/logs
chmod -R 775 /home/username/net-app/storage/framework/cache
chmod -R 775 /home/username/net-app/storage/framework/sessions
chmod -R 775 /home/username/net-app/storage/framework/views
chmod -R 775 /home/username/net-app/storage/framework/testing
chmod -R 775 /home/username/net-app/storage/debugbar
```

**If no terminal**, use cPanel File Manager:
1. Right-click folder → **Change Permissions**
2. Check: Read, Write, Execute for User and Group
3. Numeric: `755` or `775`
4. Apply to folder and subfolders

### 5. Import Database (via phpMyAdmin)

If the database does not exist yet:

1. Open **phpMyAdmin** in cPanel
2. Create a new database (or use an existing one)
3. Select database → **Import** tab
4. Upload SQL file from `net-app/database/migrations/` — BUT migrations cannot be imported directly!

**How to import migrations:**

Laravel migrations cannot be imported directly into phpMyAdmin. You need to:

**Option A — If you have terminal/SSH (rare on shared hosting):**
```bash
cd /home/username/net-app
php artisan migrate --force
```

**Option B — If you do NOT have terminal:**
1. Use an online or local tool to generate SQL from migrations
2. Or ask the developer for a `.sql` file from `php artisan migrate`
3. Import that `.sql` file into phpMyAdmin

**Option C — Use the built-in SQL script (if available):**
If the developer provided `script-table-mysql.sql`, import that file directly into phpMyAdmin.

### 6. Verify Deployment

Open your domain in the browser:

```
https://your-domain.com
```

**If error, check the following:**

| Error | Fix |
|-------|-----|
| `500 Internal Server Error` | Check `storage/` and `bootstrap/cache/` permissions. Check `.env` exists. |
| `404 Not Found` | Check `public_html/index.php` exists. Check `.htaccess` in `public_html/`. |
| `Whoops` / Debug screen | Edit `net-app/.env`, set `APP_DEBUG=false`. |
| Database error | Check DB config in `.env`. Make sure database is created and user has access. |

---

## 🔧 Troubleshooting

### Rename the App Folder

If you don't use `net-app/`, e.g. you use `wifi-app/`:

1. Rename folder `net-app/` → `wifi-app/`
2. Edit `public_html/index.php`, change this line:
   ```php
   $appPath = __DIR__ . '/../net-app';
   ```
   To:
   ```php
   $appPath = __DIR__ . '/../wifi-app';
   ```

### Add .htaccess in public_html (if needed)

If URLs don't work, add `.htaccess` in `public_html/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [L]
</IfModule>
```

### Error Logs

If the app errors, check logs at:
```
net-app/storage/logs/laravel.log
```

Open via cPanel File Manager or download the file.

---

## ✅ Deploy Checklist

- [ ] PHP version in cPanel ≥ 8.3
- [ ] Zip file uploaded and extracted
- [ ] `public/` folder moved to `public_html/`
- [ ] Production `.env` file uploaded to app folder
- [ ] `storage/` and `bootstrap/cache/` permissions set to 755/775
- [ ] Database created and imported (via phpMyAdmin)
- [ ] App accessible in browser
- [ ] `APP_DEBUG=false` in `.env` (production)
- [ ] `APP_ENV=production` in `.env`

---

## 📞 Need Help?

If there's an error you can't fix:
1. Check `net-app/storage/logs/laravel.log`
2. Check folder permissions
3. Check `.env` configuration
4. Make sure PHP version matches

---

*Created: 2026-06-24*
*Deploy Option B — Separate folders, clean URLs*
