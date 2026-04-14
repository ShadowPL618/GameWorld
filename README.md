# 🎮 GameWorld

A PHP/MySQL e-commerce web store for buying and downloading games across PC, PlayStation, and Xbox platforms. Built with vanilla PHP, PDO, and a custom CSS theming system.

---

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Folder Structure](#folder-structure)
- [Setup & Installation](#setup--installation)
- [File Reference](#file-reference)
- [Database](#database)
- [Themes](#themes)
- [Notes & TODOs](#notes--todos)

---

## ✨ Features

- Browse games by platform (PlayStation, Xbox, PC)
- User registration, login, and session management
- Shopping cart (session-based for guests, database-backed for logged-in users)
- Wishlist with add-all-to-cart support
- Blog with category filtering and comment system
- Contact form with email delivery via PHPMailer + Mailtrap SMTP
- Downloadable game client (Astroidinator .exe)
- Switchable CSS themes (Default, Fallout: New Vegas, Star Wars)
- Easter egg system tied to active theme

---

## 🛠 Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP (procedural) |
| Database | MySQL via PDO |
| Frontend | HTML5, CSS3, vanilla JS |
| Email | PHPMailer + Mailtrap SMTP |
| Styling | Custom CSS with theme switching |

---

## 📁 Folder Structure

```
GameWorld/
│
├── index.php                  # Homepage
├── index.html                 # Static HTML reference/prototype
├── database.php               # Root-level DB connection (legacy)
│
├── config/
│   ├── config.php             # Site constants (SITE_NAME, ADMIN_EMAIL, etc.)
│   └── database.php           # PDO connection used throughout the site
│
├── functions/
│   ├── functions.php          # All core business logic functions
│   └── product-display.php    # Product rendering helpers
│
├── includes/
│   ├── header.php             # Sitewide header (nav, session start, DB include)
│   ├── footer.php             # Sitewide footer
│   └── PHPMailer-master/      # PHPMailer library for email sending
│
├── templates/
│   └── product-card.php       # Reusable product card component
│
├── site_functions/            # All routable page files
│   ├── about.php
│   ├── add-blog-post.php
│   ├── blog.php
│   ├── blog-detail.php
│   ├── checkout.php
│   ├── contact.php
│   ├── download.php
│   ├── login.php
│   ├── logout.php
│   ├── product-detail.php
│   ├── products.php
│   ├── register.php
│   └── wishlist.php
│
├── css/
│   └── NewVegas.css           # Main stylesheet (includes all theme variants)
│
├── js/
│   └── main.js                # Frontend JS (cart counters, image gallery, etc.)
│
├── images/
│   ├── products/              # Product cover images
│   ├── background_img/        # Hero/banner images
│   └── characters/            # Easter egg character images
│
├── Astroidinator.exe/         # Source for the downloadable game client
│   └── obj/Debug/
│       └── Astroidinator_SDE2025_Jkra.exe
│
└── contact_messages.txt       # Flat-file backup log of contact form submissions
```

---

## ⚙️ Setup & Installation

### Prerequisites

- PHP 7.4+
- MySQL 5.7+ or MariaDB
- A local server stack: [XAMPP](https://www.apachefriends.org/) or [Laragon](https://laragon.org/)

### Steps

1. **Clone the repository** into your web server's root directory:
   ```
   git clone https://github.com/your-username/gameworld.git
   ```

2. **Create the database** in phpMyAdmin or via MySQL CLI:
   ```sql
   CREATE DATABASE gameworld CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Import the schema** (ask your instructor or team for the `.sql` dump file).

4. **Configure the database connection** in `config/database.php`:
   ```php
   $host = 'localhost';
   $dbname = 'gameworld';
   $username = 'root';
   $password = '';
   ```

5. **Configure site constants** in `config/config.php`:
   ```php
   define('ADMIN_EMAIL', 'your-email@example.com');
   define('SITE_NAME', 'GameWorld');
   ```

6. **Set up email** (optional): The contact form uses Mailtrap for development. Update the SMTP credentials in `site_functions/contact.php` with your own Mailtrap inbox credentials, or swap in a live SMTP provider for production.

7. **Start your server** and navigate to `http://localhost/gameworld/`.

---

## 📄 File Reference

### Core Pages (`site_functions/`)

| File | Purpose |
|---|---|
| `index.php` | Homepage — hero banner, popular games, platform categories |
| `products.php` | Product listing page, filterable by platform/category |
| `product-detail.php` | Single product view with image gallery, add to cart/wishlist |
| `checkout.php` | Shopping cart with quantity editing and order summary |
| `wishlist.php` | User wishlist with add-all-to-cart action |
| `login.php` | User login form and authentication |
| `register.php` | New user registration |
| `logout.php` | Destroys session and redirects to login |
| `about.php` | About Us page, content pulled from database |
| `contact.php` | Contact form — validates, logs to file, and sends email via PHPMailer |
| `blog.php` | Blog listing with category sidebar filter |
| `blog-detail.php` | Full blog post with comments section |
| `add-blog-post.php` | Form to create new blog posts (currently open access — see TODOs) |
| `download.php` | Download page for the Astroidinator game client (.exe) |

### Templates & Components

| File | Purpose |
|---|---|
| `templates/product-card.php` | Reusable product card — supports clickable image/title, wishlist or remove button |
| `includes/header.php` | Global header: starts session, loads DB + functions, renders nav |
| `includes/footer.php` | Global footer with links |

### Config & Logic

| File | Purpose |
|---|---|
| `config/database.php` | PDO connection setup |
| `config/config.php` | Site-wide constants |
| `functions/functions.php` | All helper functions: auth, cart, wishlist, DB queries, sanitization |
| `functions/product-display.php` | Product formatting helpers (e.g. `formatPrice()`) |

---

## 🗄 Database

The `gameworld` MySQL database includes the following tables (approximate):

| Table | Description |
|---|---|
| `products` | Game listings with name, price, images, descriptions, stock |
| `categories` | Platform categories (PlayStation, Xbox, PC) |
| `product_images` | Additional images per product |
| `users` | Registered user accounts (hashed passwords) |
| `cart` | Persistent cart items per user |
| `wishlist` | Wishlist items per user |
| `blog_posts` | Blog post content |
| `blog_comments` | Comments linked to blog posts |
| `about_sections` | Content blocks for the About Us page |
| `easter_eggs` | Theme-specific easter egg quotes and images per product |

---

## 🎨 Themes

The site supports three visual themes, switchable via query string:

| Theme key | Style |
|---|---|
| `default` | Standard dark gaming aesthetic |
| `newvegas` | Fallout: New Vegas — retro-futuristic amber, unlocks in-page easter eggs |
| `starwars` | Star Wars — space-inspired colour palette |

Switch via the header buttons or manually: `?theme=newvegas`

The active theme is stored in `$_SESSION['theme']` and applied as a CSS class on the `<body>` tag.

---

## 🗒 Notes & TODOs

- `add-blog-post.php` is currently accessible to all users. An authentication check should be added to restrict it to admins/moderators.
- `product-detail.php` and `products.php` both have a TODO to add publisher, release date, franchise, and developer fields.
- `checkout.php` has a placeholder checkout button with a humorous `alert()` — real payment processing is not implemented.
- `contact_messages.txt` is written to the `site_functions/` directory as a backup log. This file should be excluded from version control (add to `.gitignore`).
- The Mailtrap SMTP credentials in `contact.php` are for development/sandbox use only. Replace before deploying to production.

---

## .gitignore Recommendations

```
contact_messages.txt
config/database.php
Astroidinator.exe/
```

---

*GameWorld — SDE2025 Project*
