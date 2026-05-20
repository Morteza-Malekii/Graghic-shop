<div dir="rtl">

# فروشگاه گرافیک | Graphic Shop

<div dir="ltr">

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.x-38B2AC?style=flat&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

</div>

فروشگاه آنلاین فایل‌های گرافیکی دیجیتال — کاربران می‌توانند فایل‌های گرافیکی باکیفیت را مرور، خرید و دانلود کنند.

An online marketplace for digital graphic assets — users can browse, purchase, and download high-quality graphic files.

---

## فهرست مطالب | Table of Contents

- [معرفی پروژه | Overview](#معرفی-پروژه--overview)
- [ویژگی‌ها | Features](#ویژگیها--features)
- [معماری | Architecture](#معماری--architecture)
- [تکنولوژی‌ها | Tech Stack](#تکنولوژیها--tech-stack)
- [نصب و راه‌اندازی | Installation](#نصب-و-راهاندازی--installation)
- [ساختار پروژه | Project Structure](#ساختار-پروژه--project-structure)
- [مسیرها | Routes](#مسیرها--routes)

---

## معرفی پروژه | Overview

</div>

**FA:** فروشگاه گرافیک یک پلتفرم فروش فایل‌های دیجیتال است که با **Laravel 12** ساخته شده. کاربران بدون نیاز به ثبت‌نام می‌توانند محصولات را مرور کرده، به سبد خرید اضافه کنند و پس از پرداخت از طریق **زرین‌پال**، فایل‌ها را دانلود کنند. پنل ادمین کامل برای مدیریت محصولات، دسته‌بندی‌ها، سفارش‌ها و کاربران وجود دارد.

**EN:** Graphic Shop is a digital file marketplace built with **Laravel 12**. Users can browse products, add them to a session-based cart, and after paying via **Zarinpal**, instantly download their files. A full admin panel handles products, categories, orders, and user management.

---

## ویژگی‌ها | Features

<div dir="rtl">

### پنل کاربر (Frontend)
- مرور محصولات با قابلیت فیلتر پیشرفته
- صفحه جزئیات محصول با تصویر و توضیحات
- سبد خرید مبتنی بر Session (بدون نیاز به لاگین)
- فرآیند تسویه حساب با ورود اطلاعات مشتری
- درگاه پرداخت زرین‌پال
- دانلود امن فایل پس از پرداخت موفق
- صفحات نتیجه سفارش (موفق / ناموفق)

### پنل ادمین (Admin)
- داشبورد مدیریتی
- مدیریت کامل محصولات (ایجاد، ویرایش، حذف + آپلود فایل دمو و سورس)
- مدیریت دسته‌بندی‌ها
- مدیریت کاربران
- مشاهده سفارش‌ها
- مشاهده و بررسی پرداخت‌ها
- دانلود فایل دمو و سورس از پنل ادمین

</div>

**User Panel (Frontend)**
- Browse products with advanced filtering
- Product detail page with image and description
- Session-based shopping cart (no login required)
- Checkout with customer info form
- Zarinpal payment gateway integration
- Secure file download after successful payment
- Order result pages (success / failure)

**Admin Panel**
- Admin dashboard
- Full product CRUD (create, edit, delete + demo & source file upload)
- Category management
- User management
- Order listing
- Payment tracking
- Download demo/source files from admin panel

---

## معماری | Architecture

این پروژه از **لایه سرویس (Service Layer)** استفاده می‌کند تا منطق تجاری از کنترلر جدا بماند.

The project uses a **Service Layer** pattern to keep business logic out of controllers.

```
Controllers  →  Services  →  Models
     ↑
Form Requests (Validation)
```

| Service | مسئولیت | Responsibility |
|---|---|---|
| `CartService` | مدیریت سبد خرید در Session | Manages cart in PHP session |
| `OrderService` | ساخت سفارش و آیتم‌ها | Creates order and order items |
| `CheckoutService` | هماهنگ‌سازی Checkout | Orchestrates checkout flow |
| `PaymentService` | ارتباط با زرین‌پال | Handles Zarinpal payment lifecycle |

---

## تکنولوژی‌ها | Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Blade, TailwindCSS 4, Vite 6 |
| Payment | Zarinpal (shetabit/payment) |
| Database | MySQL |
| Dev Tools | Laravel Sail (Docker), Pint, PHPUnit |

---

## نصب و راه‌اندازی | Installation

### پیش‌نیازها | Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL

### مراحل نصب | Steps

**1. Clone کردن پروژه**
```bash
git clone https://github.com/Morteza-Malekii/Graghic-shop.git
cd Graghic-shop
```

**2. نصب وابستگی‌ها | Install dependencies**
```bash
composer install
npm install
```

**3. تنظیم محیط | Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

**4. تنظیم فایل `.env`**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=graphicshop_db
DB_USERNAME=root
DB_PASSWORD=your_password

# Zarinpal
ZARINPAL_MERCHANT_ID=your-merchant-id
```

**5. اجرای Migration | Run migrations**
```bash
php artisan migrate --seed
```

**6. ساخت Storage Link**
```bash
php artisan storage:link
```

**7. اجرای پروژه | Run the project**
```bash
# Development (همزمان server + queue + logs + vite)
composer run dev

# یا جداگانه:
php artisan serve
npm run dev
```

برنامه روی `http://localhost:8000` در دسترس خواهد بود.

The app will be available at `http://localhost:8000`.

---

### با Docker / Laravel Sail

```bash
./sail up -d
./sail artisan migrate --seed
./sail npm run dev
```

---

## ساختار پروژه | Project Structure

```
app/
├── Filters/
│   ├── QueryFilter.php          # Base filter class
│   └── ProductFilter.php        # Product search/filter scopes
├── Http/
│   ├── Controllers/
│   │   ├── Admin/               # Admin panel controllers
│   │   │   ├── CategoriesController.php
│   │   │   ├── ProductsController.php
│   │   │   ├── UsersController.php
│   │   │   ├── OrdersController.php
│   │   │   └── PaymentController.php
│   │   ├── Home/
│   │   │   └── ProductsController.php   # Frontend product listing
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   ├── OrderController.php
│   │   ├── PaymentController.php
│   │   └── DownloadController.php       # Secure file download
│   └── Requests/                # Form Requests (validation)
│       ├── Admin/
│       └── CheckoutRequest.php
├── Models/
│   ├── User.php
│   ├── Product.php
│   ├── Category.php
│   ├── Order.php
│   ├── Order_item.php
│   └── Payment.php
└── Services/
    ├── CartService.php
    ├── OrderService.php
    ├── CheckoutService.php
    └── PaymentService.php

resources/views/
├── admin/                       # Admin panel views
├── frontend/products/           # Frontend product views
├── cart/                        # Cart page
├── order/                       # Success & failure pages
└── layouts/                     # Master layouts (admin + frontend)
```

---

## مسیرها | Routes

### Frontend

| Method | URL | Name | Description |
|---|---|---|---|
| GET | `/` | `home.products.index` | صفحه اصلی / Product listing |
| GET | `/{product}/show` | `home.products.show` | جزئیات محصول / Product detail |
| GET | `/cart` | `cart.index` | سبد خرید / Cart |
| POST | `/cart/add/{product}` | `cart.add` | افزودن به سبد / Add to cart |
| DELETE | `/cart/remove/{product}` | `cart.remove` | حذف از سبد / Remove from cart |
| GET | `/cart/clear` | `cart.clear` | پاک کردن سبد / Clear cart |
| POST | `/checkout` | `checkout` | تسویه حساب / Checkout |
| GET | `/checkout/verify` | `checkout.verify` | تایید پرداخت / Verify payment |
| GET | `/payment/callback/{payment}` | `payment.callback` | بازگشت از درگاه / Payment callback |
| GET | `/order/{order}/success` | `order.success` | سفارش موفق / Order success |
| GET | `/order/{order}/failure` | `order.failure` | سفارش ناموفق / Order failure |
| GET | `/download/{path}` | `download.file` | دانلود فایل / Secure download |

### Admin

| Method | URL | Description |
|---|---|---|
| GET | `/admin/categories` | لیست دسته‌بندی‌ها |
| GET | `/admin/products` | لیست محصولات |
| GET | `/admin/users` | لیست کاربران |
| GET | `/admin/orders` | لیست سفارش‌ها |
| GET | `/admin/payments` | لیست پرداخت‌ها |

---

<div dir="rtl">

## لایسنس | License

این پروژه تحت لایسنس MIT منتشر شده است.

This project is open-sourced under the [MIT License](LICENSE).

</div>
