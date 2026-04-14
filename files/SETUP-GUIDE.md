# GymSathi AI Chatbot — Complete Setup Guide
> Google Gemini 1.5 Flash (Free) + Markdown Knowledge Base + Laravel Integration
> Built with Antigravity

---

## Overview

You will build a floating chat widget for GymSathi that:
- Uses **Google Gemini 1.5 Flash** (fast, stable, and free tier available)
- Reads all your **Markdown knowledge files** as context
- Appears as a **floating bubble** on every page of your Laravel site
- Answers customer questions automatically — 24/7

**Total cost: NPR 0/month** (within Gemini free limits ~1,500 queries/day)

---

## Step 1: Get Your Free Gemini API Key

1. Go to [https://aistudio.google.com/app/apikey](https://aistudio.google.com/app/apikey)
2. Sign up with your Google account (no credit card needed).
3. Click **"Create API Key"**.
4. Copy the key — it looks like: `AIzaSy...`
5. Save it somewhere safe.

---

## Step 2: Project Structure

Your final file structure will look like this:

```
your-laravel-project/
├── knowledge-base/
│   ├── 01-general-faq.md
│   ├── 02-pricing-billing.md
│   ├── 03-features-usage.md
│   ├── 04-account-auth.md
│   ├── 05-security-privacy.md
│   ├── 06-troubleshooting.md
│   ├── 07-contact-support.md
│   └── 08-sectors.md
├── app/
│   └── Http/
│       └── Controllers/
│           └── ChatbotController.php   ← UPDATED
├── routes/
│   └── web.php                         ← ADD ROUTE
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── public.blade.php        ← ADD WIDGET
│       └── components/
│           └── chatbot-widget.blade.php ← UPDATED
└── .env                                ← ADD API KEY
```

---

## Step 3: Add Gemini API Key to .env

Open your `.env` file and add:

```env
GEMINI_API_KEY=your_actual_key_here
GEMINI_MODEL=gemini-1.5-flash
```

---

## Step 4: Create/Update the ChatbotController

**File:** `app/Http/Controllers/ChatbotController.php`

The controller reads your `.md` files and sends them as context to Gemini.

```php
// ... (Refer to the actual file for the full implementation using Google HTTP client)
```

---

## Step 5: Add Gemini Config to services.php

Open `config/services.php` and add inside the array:

```php
'gemini' => [
    'api_key' => env('GEMINI_API_KEY'),
    'model'   => env('GEMINI_MODEL', 'gemini-1.5-flash'),
],
```

---

## Step 6: Add the Route

Open `routes/web.php` and add:

```php
use App\Http\Controllers\ChatbotController;

Route::post('/chatbot', [ChatbotController::class, 'chat'])
    ->middleware('throttle:30,1') // Max 30 requests per minute per IP
    ->name('chatbot');
```

---

## Step 7: Create the Chat Widget Component

**File:** `resources/views/components/chatbot-widget.blade.php`

The widget is styled with GymSathi's Lime Green and Dark theme, using **Material Symbols** for a premium look.

---

## Step 8: Add Widget to Layout

Open `resources/views/layouts/public.blade.php` and add these two things:

1. **In the `<head>` section**, include the Material Symbols font and CSRF token:
```html
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
```

2. **Before the closing `</body>` tag**, add:
```html
@include('components.chatbot-widget')
```

---

## Step 9: Copy Knowledge Base Files

Place all markdown files in your Laravel project root under `knowledge-base/`.

---

## Step 10: Clear Cache & Test

Run these commands:

```bash
# Clear config cache so .env changes load
php artisan config:clear
php artisan cache:clear

# Visit your website — you should see a lime-green bubble!
```

---

## Step 11: Updating the Knowledge Base

To update the chatbot's knowledge (e.g., new pricing, new features):
1. Edit the relevant `.md` file in the `knowledge-base/` folder.
2. The chatbot will immediately use the updated info (no code changes needed!).

---

## Troubleshooting

| Problem | Solution |
|---|---|
| Connection error | Check your GEMINI_API_KEY in .env and run `php artisan config:clear` |
| 403 Forbidden | Ensure your API key is active in Google AI Studio |
| 404 Model Not Found | Ensure GEMINI_MODEL is set to `gemini-1.5-flash` |
| Icons missing | Ensure the Material Symbols link is in your `<head>` |

---

## Summary

You now have a fully working, free AI chatbot for GymSathi that matches your branding and answers questions instantly using Google's world-class Gemini engine.
