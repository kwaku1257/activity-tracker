# Railway Deployment Guide (Easier Alternative)

Railway auto-detects Laravel, so no need to select PHP manually!

---

## Step 1: Sign Up for Railway

1. Go to [railway.app](https://railway.app)
2. Click **"Start a New Project"**
3. Sign up with **GitHub** (easiest)
4. Authorize Railway to access your GitHub

---

## Step 2: Deploy Your Repository

1. Click **"New Project"**
2. Select **"Deploy from GitHub repo"**
3. Find and select your `activity-tracker` repository
4. Click **"Deploy Now"**

Railway will automatically:
- Detect it's a Laravel app
- Install dependencies
- Run migrations
- Start the server

---

## Step 3: Add Environment Variables

1. Click on your deployed service
2. Go to **"Variables"** tab
3. Click **"New Variable"**

Add these one by one:

1. **APP_NAME**
   - Key: `APP_NAME`
   - Value: `Activity Tracker`

2. **APP_ENV**
   - Key: `APP_ENV`
   - Value: `production`

3. **APP_KEY** ⭐
   - Key: `APP_KEY`
   - Value: `base64:...` (paste your full APP_KEY)

4. **APP_DEBUG**
   - Key: `APP_DEBUG`
   - Value: `false`

5. **DB_CONNECTION**
   - Key: `DB_CONNECTION`
   - Value: `sqlite`

6. **SESSION_DRIVER**
   - Key: `SESSION_DRIVER`
   - Value: `database`

After adding each variable, Railway will auto-redeploy.

---

## Step 4: Get Your URL

1. Go to **"Settings"** tab
2. Scroll to **"Domains"**
3. Click **"Generate Domain"**
4. Copy your URL (e.g., `activity-tracker-production.up.railway.app`)

---

## Step 5: Update APP_URL

1. Go back to **"Variables"** tab
2. Add or edit:
   - Key: `APP_URL`
   - Value: `https://your-railway-url.up.railway.app` (your actual URL)

---

## Step 6: Test Your App

1. Open your Railway URL
2. You should see the login page
3. Register and test!

---

## That's It!

Railway is much simpler - it handles everything automatically. No need to configure build commands or start commands - it just works!

---

## Railway Free Tier

- $5 free credit per month
- Usually enough for small apps
- Auto-scales
- Very easy to use
