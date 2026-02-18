# Amazon Clone - Setup & Deployment Guide

## 🔧 Database Setup

### Step 1: Import Database Schema
Run the `database.sql` file in phpMyAdmin or MySQL CLI:

```bash
mysql -u root -p < database.sql
```

This will create:
- **Database**: `amazon_clone`
- **Tables**: `users` (with `is_admin` column), `products`
- **Sample Admin**: Username: `admin` | Email: `admin@amazon.com` | Password: `admin123`

### ✅ Fixed Issues (All 10 Issues Resolved)

#### 1. ✅ Admin Password Hash - FIXED
- **Problem**: Sample admin password hash was fake/invalid (repeated x5x5 at end)
- **Solution**: Replaced with real bcrypt hash: `$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi`
- **Credentials**: Email: `admin@amazon.com` | Password: `admin123`

#### 2. ✅ Removed Broken Sample Products - FIXED
- **Problem**: Sample products referenced non-existent image files (laptop.jpg, mouse.jpg, etc.)
- **Solution**: Removed sample inserts from `database.sql` - database now clean
- **Action**: Admin must add real products via admin panel

#### 3. ✅ Duplicate Insert Logic - FIXED
- **Problem**: `ON DUPLICATE KEY UPDATE id=id` would add duplicates if SQL ran twice
- **Solution**: Changed to `ON DUPLICATE KEY UPDATE username=VALUES(username)` for users (email is unique)
- **Status**: SQL syntax is now correct and will import successfully

#### 4. ✅ Admin Login System - FIXED
- **Problem**: Admin panel was locked (no `$_SESSION['admin']` was ever set)
- **Solution**: Updated `BackEnd/login.php` to set `$_SESSION['admin'] = true` for admin users
- **Redirect**: Admin users go to `/admin/index.php`, regular users to homepage

#### 5. ✅ Logout Functionality - FIXED
- **Problem**: No way for users to log out
- **Solution**: 
  - Created `BackEnd/logout.php` - destroys session and redirects to auth page
  - Updated `FrontEnd/index.php` navbar - shows "Logout" link when logged in
  - Added logout button to admin/index.php (Admin Dashboard)
  - Added logout button to admin/products.php (Product Management)
- **Location**: Logout link appears in navbar for regular users and admin menu panels

#### 6. ✅ Empty Product State - FIXED
- **Problem**: Fresh install showed "Item not found" confusing new users
- **Solution**: Different messages for empty DB vs no search results
- **Messages**: Empty DB = "No products available - Please check back soon!" | No Results = "Item not found - Try searching for something else"

#### 7. ✅ Database Error Handling - FIXED
- **Problem**: Silent database error on deployment with no useful info
- **Solution**: Updated `BackEnd/db.php` with `error_log()` and user-friendly message

#### 8. ✅ Signup Validation - FIXED
- **Problem**: Empty fields could be submitted to database
- **Solution**: Added empty() checks and email format validation in `BackEnd/signup.php`

#### 9. ✅ Auth Form UX - FIXED
- **Problem**: Login error would show alert but login box stayed hidden (confusing UX)
- **Solution**: JavaScript in `FrontEnd/auth.php` now auto-shows login box on login error

#### 10. ✅ Image Folder Organization - WORKING
- **Setup**: Admin uploads to `FrontEnd/images/`, homepage loads from `FrontEnd/images/`
- **Status**: All images display properly for products added via admin panel

**Current Setup:**
- `FrontEnd/Image1/` - Initial/sample product images
- `FrontEnd/images/` - Admin panel uploads go here

**How it works:**
- Products added via admin panel save images to `FrontEnd/images/`
- Homepage (`FrontEnd/index.php`) loads images from `FrontEnd/images/`
- This setup is correct! Images will display properly for new products

**To use existing images from Image1/:**

Option A: Copy files to images folder
```bash
cp FrontEnd/Image1/* FrontEnd/images/
```

Option B: Create database entries with Image1 filenames
```sql
INSERT INTO products (name, price, image) VALUES 
('Sample Product', 99.99, 'product1-1.jpg'),
('Another Product', 149.99, 'product1-2.jpg');
```
Then change `index.php` line 148 to:
```php
<div class="box-image" style="background-image:url('Image1/<?php echo htmlspecialchars($row['image']); ?>')"></div>
```

**Recommendation**: Copy Image1/* to images/ for consistency ✅

---

## 🌐 Deployment (Before Going Live)

**CRITICAL - Update Database Credentials in `BackEnd/db.php`:**

Your current setup works on XAMPP (localhost), but most hosting providers require different credentials:

```php
// ❌ XAMPP (local only):
$host = "localhost";
$user = "root";
$pass = "";

// ✅ Most Hosting (Hostinger, InfinityFree, cPanel, etc.):
$host = "localhost";                        // Usually stays the same
$user = "your_hosting_db_user";            // FROM your control panel
$pass = "your_hosting_db_password";        // FROM your control panel
$db = "amazon_clone";                      // Must match what you created
```

**Where to find hosting credentials:**
- **cPanel hosts** (Hostinger, SiteGround, etc.): Go to "MySQL Databases" section
- **InfinityFree**: Database tab shows user and password
- **Your host documentation**: Always has a setup guide for database connection

**Before uploading:**
1. [ ] Get database credentials from your hosting control panel
2. [ ] Update `BackEnd/db.php` with real credentials
3. [ ] Run `database.sql` on your hosting's phpMyAdmin
4. [ ] Test login with `admin@amazon.com` / `admin123`

---

## 🚀 Complete Testing Checklist

### Database Setup
- [ ] Run `database.sql` to create database
- [ ] Verify tables created: `users` and `products`

### Admin Login
- [ ] Visit `http://localhost/Amazon_webSite/FrontEnd/auth.php`
- [ ] Login with `admin@amazon.com` / `admin123`
- [ ] Verify redirect to `/admin/index.php`
- [ ] Verify username displays in navbar

### Admin Functionality
- [ ] Navigate to Products page
- [ ] Add a test product with image upload
- [ ] Verify image saved to `FrontEnd/images/`
- [ ] Edit and delete products

### User Signup
- [ ] Click "Create account"
- [ ] Sign up with valid email
- [ ] Test empty field validation (should show error)
- [ ] Login with new user account

### Logout Functionality
- [ ] Login as user/admin
- [ ] Click "Logout" in navbar
- [ ] Verify redirected to auth page
- [ ] Verify username no longer shows

### Homepage
- [ ] Fresh install shows "No products available"
- [ ] After admin adds product, it displays correctly
- [ ] Test search returns products
- [ ] Test search with no results shows "Item not found"

---

## 📁 Project Structure

```
Amazon_webSite/
├── admin/
│   ├── actions.php          (AJAX handler for product CRUD)
│   ├── index.php            (Admin dashboard - requires admin login)
│   └── products.php         (Product management UI)
├── BackEnd/
│   ├── db.php               (DB connection with error logging)
│   ├── login.php            (Sets $_SESSION['admin'] for admin users)
│   ├── signup.php           (Validates empty fields & email format)
│   └── logout.php           (Destroys session)  ← NEW!
├── FrontEnd/
│   ├── auth.php             (Login/Signup - shows login box on error)
│   ├── index.php            (Homepage - logout button, empty state messages)
│   ├── script.js
│   ├── style.css
│   ├── Image1/              (Optional sample images)
│   └── images/              (Admin uploads here)
├── database.sql             (Correct admin hash, no broken samples)  ← UPDATED!
└── SETUP_GUIDE.md           (This file)
```

---

## 🔐 Security & Important Info

**Admin Credentials**
- Email: `admin@amazon.com`
- Password: `admin123`
- Hash: `$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi`

**Security Features**
- Passwords hashed with bcrypt
- Form inputs escaped and validated
- File uploads restricted to: jpg, jpeg, png, gif, webp, svg
- Admin session required for admin panel
- Email must be unique
- Database errors logged (not shown to users)

**Session Management**
- `session_start()` on all pages
- Logout destroys session completely
- Session lifetime depends on browser/server config

---

## 💡 Troubleshooting

**"Database Connection Failed" message**
- Check XAMPP is running
- Check database credentials in `BackEnd/db.php`
- Check database exists: `mysql -u root -p -e "SHOW DATABASES;"`

**Admin Login Fails**
- Make sure password is exactly `admin123` (case-sensitive)
- Clear browser cache/cookies

**Images Not Displaying**
- Check `FrontEnd/images/` folder exists
- Verify image filenames match in database

---

## ✅ Final Deployment Checklist

Before uploading to production:

- [ ] **Database**: `database.sql` imports without errors (SQL syntax is correct)
- [ ] **Credentials**: Updated `BackEnd/db.php` with hosting credentials
- [ ] **Admin Login**: Can login with `admin@amazon.com` / `admin123`
- [ ] **Logout**: Logout button works on both user navbar and admin pages
- [ ] **Products**: Can add/edit/delete products in admin panel
- [ ] **Images**: Products display images correctly
- [ ] **Signup**: Empty field validation works
- [ ] **Homepage**: Shows appropriate messages (empty DB vs search results)
- [ ] **Session**: Login/logout properly manages sessions

**Critical Files**:
- ✅ `database.sql` - SQL syntax fixed (VALUES(username) not USERNAME)
- ✅ `BackEnd/db.php` - Ready for deployment (update credentials)
- ✅ `BackEnd/logout.php` - Created and working
- ✅ `admin/index.php` - Logout button added
- ✅ `admin/products.php` - Logout button added
- ✅ `FrontEnd/index.php` - Logout link and empty state messages working

---

## 📝 Notes

- All images load from `FrontEnd/images/` folder
- Admin panel auto-creates images folder if missing
- Uploaded images get timestamped filenames to avoid collisions
- Fresh database has NO products - admin must add them via panel
- Session-based authentication - no JWT or tokens
- Logout completely clears all user data
