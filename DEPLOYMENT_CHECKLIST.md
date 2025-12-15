# Deployment Checklist for Sisaku Chatbot

## Before Deployment

### 1. Environment Variables (.env)
Ensure these are set on your hosting server:

```
# Required for online mode (with AI)
GROQ_API_KEY=your_actual_api_key_here

# Required for database
DB_HOST=your_database_host
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
DB_DATABASE=your_database_name

# Other essential configs
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

### 2. Deploy Steps
```bash
# 1. Pull latest from GitHub
git pull origin main

# 2. Install dependencies
composer install --no-dev

# 3. Generate app key (if new installation)
php artisan key:generate

# 4. Run migrations
php artisan migrate --force

# 5. Clear caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# 6. Build assets
npm install
npm run build

# 7. Optimize for production
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Offline Mode Behavior

### When GROQ_API_KEY is NOT set (Offline Mode)
The chatbot will:
1. ✅ Detect missing API key
2. ✅ Log "Groq API Key is not set"
3. ✅ Return intelligent fallback responses
4. ✅ Answer questions based on regex pattern matching
5. ✅ Provide helpful information about system features

### When GROQ_API_KEY is set (Online Mode)
The chatbot will:
1. ✅ Use GROQ API for intelligent responses
2. ✅ Fall back to database answers if API fails
3. ✅ Fall back to general knowledge if database fails
4. ✅ Handle all errors gracefully

## Testing After Deployment

### Test Online Mode (with API key)
```bash
# Query something that needs real AI
"Jelaskan lebih detail tentang dampak lingkungan bank sampah?"
```
Expected: Detailed explanation from GROQ API

### Test Offline Mode (without API key)
Remove GROQ_API_KEY from .env or deploy without it

```bash
# Query pricing (pattern-matched response)
"Berapa harga plastik?"
Expected: "Untuk informasi harga sampah terbaru, silakan lihat menu Master Data..."

# Query about transactions
"Bagaimana cara input transaksi?"
Expected: "Untuk melakukan transaksi penjualan sampah: 1. Menu Transaksi..."

# Query system info
"Apa itu bank sampah?"
Expected: "Sisaku adalah platform untuk mengelola bank sampah dengan 3 role..."
```

### Test Frontend
1. Open chatbot (green robot icon, bottom-right)
2. Click icon to open chat window
3. Send messages
4. Verify responses appear correctly
5. Check browser console for errors (F12 → Console)

## Common Issues & Solutions

### Problem: Chat icon doesn't appear
**Solutions:**
- Hard refresh browser: `Ctrl+Shift+R`
- Clear browser cache: DevTools → Application → Clear storage
- Check console for errors: `F12 → Console`
- Verify Tailwind CSS built: check `public/build/assets/app-*.css`

### Problem: Chat sends message but no response
**Solutions:**
1. Check server logs for errors
   ```bash
   tail -f storage/logs/laravel.log
   ```
2. Verify GROQ_API_KEY is set (or intentionally left blank for offline mode)
3. Check that `/chatbot/send` route is accessible:
   ```bash
   curl -X POST http://your-domain/chatbot/send
   ```
4. Verify database connection is working
5. Check that chatbot component is included in layout

### Problem: Chatbot works locally but not on server
**Solutions:**
- Check environment variables match production config
- Verify Tailwind CSS is built: `npm run build`
- Clear Laravel caches: `php artisan cache:clear`
- Check file permissions on `storage/` directory
- Verify CORS headers if on subdomain

### Problem: API timeout on slow connections
**Solutions:**
- Timeout is set to 20 seconds (frontend) and 30 seconds (backend HTTP)
- Users will see: "⏱️ Permintaan timeout. Server tidak merespons."
- This triggers fallback responses automatically

## Monitoring

### Check if API is being used
```bash
# Look for these log lines
tail -f storage/logs/laravel.log | grep "Groq API"

# Expected logs:
# - "Groq API Key is not set" (offline mode)
# - "Groq API Error: ..." (API error, fallback activated)
# - "Groq API Exception: ..." (network error, fallback activated)
```

### Monitor chat history
```bash
# View chat messages in database
SELECT * FROM chat_histories ORDER BY created_at DESC LIMIT 20;
```

## Rollback Plan

If chatbot has issues after deployment:
```bash
# 1. Disable chatbot temporarily (comment out @include in layouts)
# 2. Clear cache
php artisan cache:clear
php artisan view:clear

# 3. Revert to previous version if needed
git revert HEAD
git push origin main
```

## Key Differences: Local vs Hosted

| Aspect | Local | Hosted |
|--------|-------|--------|
| **GROQ_API_KEY** | Set in .env | Must be in hosting panel env vars |
| **Database** | Local MySQL | Remote database |
| **Storage path** | Local filesystem | May need cloud storage |
| **Log location** | `storage/logs/laravel.log` | Hosting provider logs |
| **Asset building** | `npm run build` | Must run before deploy |
| **Cache clearing** | Local artisan commands | May need hosting panel |

## Success Indicators

✅ Chatbot icon visible on all pages
✅ Click icon opens/closes chat window
✅ Chat window displays messages correctly
✅ Fallback responses work when offline
✅ Responses show with proper styling
✅ No console errors in DevTools
✅ Messages saved to chat_histories table
✅ Works on all user roles (admin, karang_taruna, guest)
