# Step-by-Step Deployment Guide for Assignment

## Prerequisites
- GitHub account (free)
- Render.com account (free)

---

## Step 1: Prepare Your Code

### 1.1 Get your APP_KEY
```bash
cd /Users/kd/nPOntu
cat .env | grep APP_KEY
```
Copy the entire `APP_KEY=base64:...` line - you'll need it later.

### 1.2 Make sure .gitignore is correct
Your `.gitignore` should already exclude:
- `.env`
- `/vendor`
- `/node_modules`

---

## Step 2: Push Code to GitHub

### 2.1 Initialize Git (if not already done)
```bash
cd /Users/kd/nPOntu
git init
```

### 2.2 Add all files
```bash
git add .
```

### 2.3 Commit
```bash
git commit -m "Activity Tracker - Assignment Submission"
```

### 2.4 Create GitHub Repository
1. Go to [github.com](https://github.com)
2. Click "+" → "New repository"
3. Name it: `activity-tracker` (or any name)
4. **DO NOT** check "Initialize with README"
5. Click "Create repository"

### 2.5 Push to GitHub
```bash
# Replace YOUR_USERNAME with your GitHub username
git remote add origin https://github.com/YOUR_USERNAME/activity-tracker.git
git branch -M main
git push -u origin main
```

**If asked for credentials:**
- Use a Personal Access Token (not password)
- Create one: GitHub → Settings → Developer settings → Personal access tokens → Generate new token
- Give it "repo" permissions

---

## Step 3: Deploy on Render.com

### 3.1 Sign Up
1. Go to [render.com](https://render.com)
2. Click "Get Started for Free"
3. Sign up with GitHub (easiest option)
4. Authorize Render to access your GitHub

### 3.2 Create Web Service
1. Click "New +" button
2. Select "Web Service"
3. Click "Connect account" if needed
4. Find and select your `activity-tracker` repository
5. Click "Connect"

### 3.3 Configure Settings

**Basic Settings:**
- **Name:** `activity-tracker` (or any name)
- **Region:** Choose closest to you
- **Branch:** `main`
- **Root Directory:** (leave empty)
- **Runtime:** `PHP`
- **Build Command:** 
  ```
  composer install --no-dev --optimize-autoloader && php artisan key:generate --force && php artisan migrate --force
  ```
- **Start Command:**
  ```
  php artisan serve --host=0.0.0.0 --port=$PORT
  ```

### 3.4 Add Environment Variables
Click "Advanced" → "Add Environment Variable"

Add these one by one:

1. **APP_NAME**
   - Key: `APP_NAME`
   - Value: `Activity Tracker`

2. **APP_ENV**
   - Key: `APP_ENV`
   - Value: `production`

3. **APP_KEY**
   - Key: `APP_KEY`
   - Value: `base64:...` (paste the full value from your local .env)

4. **APP_DEBUG**
   - Key: `APP_DEBUG`
   - Value: `false`

5. **APP_URL**
   - Key: `APP_URL`
   - Value: `https://your-app-name.onrender.com` (you'll get this after first deploy)

6. **DB_CONNECTION**
   - Key: `DB_CONNECTION`
   - Value: `sqlite`

7. **SESSION_DRIVER**
   - Key: `SESSION_DRIVER`
   - Value: `database`

### 3.5 Deploy
1. Scroll down
2. Click "Create Web Service"
3. Wait 5-10 minutes for deployment
4. You'll see build logs - watch for errors

---

## Step 4: After Deployment

### 4.1 Get Your URL
Once deployed, you'll see:
- **Your URL:** `https://activity-tracker-xxxx.onrender.com`
- Copy this URL

### 4.2 Update APP_URL
1. Go to Environment Variables in Render
2. Edit `APP_URL`
3. Set it to your actual URL: `https://activity-tracker-xxxx.onrender.com`
4. Save changes
5. Render will auto-redeploy

### 4.3 Test Your App
1. Open your URL in browser
2. You should see the login page
3. Register a test user
4. Test creating activities
5. Test all features

---

## Step 5: For Assignment Submission

### What to Submit:

1. **GitHub Repository Link:**
   ```
   https://github.com/YOUR_USERNAME/activity-tracker
   ```

2. **Live Application URL:**
   ```
   https://activity-tracker-xxxx.onrender.com
   ```

3. **README.md** (update it with):
   ```markdown
   # Activity Tracker
   
   Live Demo: https://activity-tracker-xxxx.onrender.com
   GitHub: https://github.com/YOUR_USERNAME/activity-tracker
   
   ## Test Credentials
   - Register your own account to test
   - Or use: [if you create test account]
   ```

---

## Troubleshooting

### Build Fails
- Check build logs in Render dashboard
- Common issues:
  - Missing environment variables
  - Wrong build command
  - PHP version mismatch

### App Shows 500 Error
- Check logs in Render dashboard
- Usually means:
  - APP_KEY not set
  - Database migration failed
  - Missing environment variable

### Database Issues
- SQLite should work automatically
- If not, check storage permissions in Render

### Can't Access App
- Wait a few minutes (first deploy takes time)
- Check if service is "Live" in Render dashboard
- Free tier spins down after 15 min inactivity - first access will be slow

---

## Quick Checklist

- [ ] Code pushed to GitHub
- [ ] Render account created
- [ ] Web service created
- [ ] Environment variables added
- [ ] Build command set
- [ ] Start command set
- [ ] Deployment successful
- [ ] App accessible via URL
- [ ] Tested registration
- [ ] Tested creating activity
- [ ] Tested all features
- [ ] Ready to submit!

---

## Time Estimate
- GitHub setup: 5 minutes
- Render setup: 10 minutes
- Deployment: 5-10 minutes
- Testing: 5 minutes
- **Total: ~25-30 minutes**

---

## Need Help?
If you get stuck at any step, check:
1. Render logs (very helpful)
2. GitHub repository (make sure code is there)
3. Environment variables (all set correctly?)

Good luck with your assignment! 🚀
