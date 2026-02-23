# Complete Deployment Steps

## Step 1: Get Your APP_KEY ✅ (You're doing this now)

In your terminal, run:
```bash
cd /Users/kd/nPOntu
cat .env | grep APP_KEY
```

Copy the entire line that looks like:
```
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

**Save this somewhere** - you'll need it in Step 4.

---

## Step 2: Push Code to GitHub

### 2.1 Initialize Git (if not done)
```bash
cd /Users/kd/nPOntu
git init
```

### 2.2 Add All Files
```bash
git add .
```

### 2.3 Commit
```bash
git commit -m "Activity Tracker Assignment"
```

### 2.4 Create GitHub Repository

1. Go to [github.com](https://github.com) and sign in
2. Click the **"+"** icon (top right) → **"New repository"**
3. Repository name: `activity-tracker` (or any name you like)
4. Description: "Laravel Activity Tracking System"
5. **Make it Public** (or Private - your choice)
6. **DO NOT** check "Initialize with README"
7. Click **"Create repository"**

### 2.5 Connect and Push

GitHub will show you commands. Use these (replace YOUR_USERNAME):

```bash
git remote add origin https://github.com/YOUR_USERNAME/activity-tracker.git
git branch -M main
git push -u origin main
```

**If asked for credentials:**
- Username: Your GitHub username
- Password: Use a **Personal Access Token** (not your password)
  - Create token: GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic) → Generate new token
  - Give it `repo` permission
  - Copy and use as password

---

## Step 3: Verify Code is on GitHub

1. Go to your repository on GitHub
2. You should see all your files:
   - `app/` folder
   - `routes/` folder
   - `database/migrations/` folder
   - `composer.json`
   - `README.md`
   - etc.

**Make sure `.env` is NOT there** (it should be in .gitignore)

---

## Step 4: Deploy on Render.com

### 4.1 Sign Up for Render

1. Go to [render.com](https://render.com)
2. Click **"Get Started for Free"**
3. Click **"Sign up with GitHub"**
4. Authorize Render to access your GitHub account

### 4.2 Create Web Service

1. Once logged in, click **"New +"** button (top right)
2. Select **"Web Service"**
3. Click **"Connect account"** if it asks
4. Find and select your `activity-tracker` repository
5. Click **"Connect"**

### 4.3 Configure Settings

Fill in these settings:

**Basic Settings:**
- **Name:** `activity-tracker` (or any name)
- **Region:** Choose closest to you (e.g., "Oregon (US West)")
- **Branch:** `main`
- **Root Directory:** (leave empty)

**Build & Deploy:**
- **Runtime:** Select **"PHP"**
- **Build Command:** 
  ```
  composer install --no-dev --optimize-autoloader && php artisan key:generate --force && php artisan migrate --force
  ```
- **Start Command:**
  ```
  php artisan serve --host=0.0.0.0 --port=$PORT
  ```

### 4.4 Add Environment Variables

Click **"Advanced"** → Scroll to **"Environment Variables"** → Click **"Add Environment Variable"**

Add these **one by one**:

1. **APP_NAME**
   - Key: `APP_NAME`
   - Value: `Activity Tracker`

2. **APP_ENV**
   - Key: `APP_ENV`
   - Value: `production`

3. **APP_KEY** ⭐ (The one you copied!)
   - Key: `APP_KEY`
   - Value: `base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx`
   - (Paste the full value you copied from Step 1)

4. **APP_DEBUG**
   - Key: `APP_DEBUG`
   - Value: `false`

5. **APP_URL**
   - Key: `APP_URL`
   - Value: `https://activity-tracker-xxxx.onrender.com`
   - (You'll get the actual URL after first deploy - you can update this later)

6. **DB_CONNECTION**
   - Key: `DB_CONNECTION`
   - Value: `sqlite`

7. **SESSION_DRIVER**
   - Key: `SESSION_DRIVER`
   - Value: `database`

### 4.5 Deploy

1. Scroll down
2. Click **"Create Web Service"**
3. Wait 5-10 minutes for deployment
4. Watch the build logs - you'll see it installing dependencies and running migrations

---

## Step 5: After Deployment

### 5.1 Get Your URL

Once deployment completes, you'll see:
- **Your URL:** `https://activity-tracker-xxxx.onrender.com`
- Copy this URL

### 5.2 Update APP_URL (if needed)

1. Go to **Environment** tab in Render
2. Find `APP_URL`
3. Edit it to match your actual URL: `https://activity-tracker-xxxx.onrender.com`
4. Save
5. Render will auto-redeploy (takes 2-3 minutes)

### 5.3 Test Your Application

1. Open your URL in browser: `https://activity-tracker-xxxx.onrender.com`
2. You should see the **login page**
3. Click **"Register"**
4. Create a test account:
   - Name: Test User
   - Email: test@example.com
   - Password: password123
   - Password Confirmation: password123
5. Click **"Register"**
6. You should be logged in and see the **Dashboard**

### 5.4 Test All Features

- ✅ Create an activity
- ✅ Update activity status with remarks
- ✅ Check Daily View
- ✅ Test Reports
- ✅ Export CSV

---

## Step 6: Update README with Your URLs

Edit `README.md` and add:

```markdown
## Live Demo

**Deployed Application:** https://activity-tracker-xxxx.onrender.com

**GitHub Repository:** https://github.com/YOUR_USERNAME/activity-tracker
```

Then commit and push:
```bash
git add README.md
git commit -m "Update README with deployment URLs"
git push
```

---

## Step 7: Submit Your Assignment

Submit to your professor:

1. **GitHub Repository Link:**
   ```
   https://github.com/YOUR_USERNAME/activity-tracker
   ```

2. **Live Application URL:**
   ```
   https://activity-tracker-xxxx.onrender.com
   ```

3. **README.md** (with setup instructions)

---

## Troubleshooting

### Build Fails
- Check build logs in Render
- Common issues:
  - Missing environment variables
  - Wrong build command
  - Check that all migrations are in `/database/migrations/`

### App Shows 500 Error
- Check logs in Render dashboard
- Usually means:
  - APP_KEY not set correctly
  - Database migration failed
  - Missing environment variable

### Can't Access App
- Wait a few minutes (first deploy takes time)
- Check if service shows "Live" in Render dashboard
- Free tier spins down after 15 min inactivity - first access will be slow (30-60 seconds)

### Database Issues
- SQLite should work automatically
- If migrations fail, check logs in Render

---

## Quick Checklist

- [ ] Got APP_KEY from .env
- [ ] Pushed code to GitHub
- [ ] Created Render account
- [ ] Created Web Service on Render
- [ ] Added all environment variables
- [ ] Deployment successful
- [ ] App accessible via URL
- [ ] Tested registration
- [ ] Tested creating activity
- [ ] Tested all features
- [ ] Updated README with URLs
- [ ] Ready to submit!

---

## Time Estimate

- Step 1 (APP_KEY): 1 minute
- Step 2 (GitHub): 10 minutes
- Step 3 (Verify): 2 minutes
- Step 4 (Render setup): 15 minutes
- Step 5 (Deploy & test): 10 minutes
- Step 6 (Update README): 5 minutes

**Total: ~45 minutes**

Good luck! 🚀
