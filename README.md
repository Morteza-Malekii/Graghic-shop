# Graphic Shop

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.x-38B2AC?style=flat&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

An online marketplace for digital graphic assets built with Laravel 12. Users can browse products, add them to a session-based cart, pay via Zarinpal, and instantly download their files. A full admin panel handles products, categories, orders, and payments.

---

## Table of Contents

- [Features](#features)
- [Architecture](#architecture)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Project Structure](#project-structure)
- [Routes](#routes)

---

## Features

**User Panel**
- Browse products with advanced filtering
- Product detail page with image and description
- Session-based shopping cart (no login required)
- Checkout with customer info form
- Zarinpal payment gateway integration
- Secure file download after successful payment
- Order result pages (success / failure)

**Admin Panel**
- Admin dashboard
- Full product CRUD with demo & source file upload
- Category management
- User management
- Order listing
- Payment tracking
- Download demo/source files directly from admin

---

## Architecture

The project uses a **Service Layer** pattern to keep business logic out of controllers.

```
Controllers  →  Services  →  Models
     ↑
Form Requests (Validation)
```

| Service | Responsibility |
|---|---|
| `CartService` | Manages cart state in PHP session |
| `OrderService` | Creates orders and order items |
| `CheckoutService` | Orchestrates the full checkout flow |
| `PaymentService` | Handles Zarinpal payment lifecycle |

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Blade, TailwindCSS 4, Vite 6 |
| Payment | Zarinpal (shetabit/payment) |
| Database | MySQL |
| Dev Tools | Laravel Sail (Docker), Pint, PHPUnit |

---

## Installation

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL

### Steps

**1. Clone the repository**
```bash
git clone https://github.com/Morteza-Malekii/Graghic-shop.git
cd Graghic-shop
```

**2. Install dependencies**
```bash
composer install
npm install
```

**3. Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=graphicshop_db
DB_USERNAME=root
DB_PASSWORD=your_password

ZARINPAL_MERCHANT_ID=your-merchant-id
```

**5. Run migrations**
```bash
php artisan migrate --seed
```

**6. Create storage link**
```bash
php artisan storage:link
```

**7. Start the development server**
```bash
# Runs server, queue, logs, and vite concurrently
composer run dev

# Or separately:
php artisan serve
npm run dev
```

The app will be available at `http://localhost:8000`.

### With Docker / Laravel Sail

```bash
./sail up -d
./sail artisan migrate --seed
./sail npm run dev
```

---

## Project Structure

```
app/
├── Filters/
│   ├── QueryFilter.php              # Base filter class
│   └── ProductFilter.php            # Product search/filter scopes
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                   # Admin panel controllers
│   │   │   ├── CategoriesController.php
│   │   │   ├── ProductsController.php
│   │   │   ├── UsersController.php
│   │   │   ├── OrdersController.php
│   │   │   └── PaymentController.php
│   │   ├── Home/
│   │   │   └── ProductsController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   ├── OrderController.php
│   │   ├── PaymentController.php
│   │   └── DownloadController.php   # Secure file download
│   └── Requests/                    # Form Requests (validation)
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
├── admin/                           # Admin panel views
├── frontend/products/               # Frontend product views
├── cart/                            # Cart page
├── order/                           # Success & failure pages
└── layouts/                         # Master layouts (admin + frontend)
```

---

## Routes

### Frontend

| Method | URL | Name | Description |
|---|---|---|---|
| GET | `/` | `home.products.index` | Product listing |
| GET | `/{product}/show` | `home.products.show` | Product detail |
| GET | `/cart` | `cart.index` | Shopping cart |
| POST | `/cart/add/{product}` | `cart.add` | Add to cart |
| DELETE | `/cart/remove/{product}` | `cart.remove` | Remove from cart |
| GET | `/cart/clear` | `cart.clear` | Clear cart |
| POST | `/checkout` | `checkout` | Checkout |
| GET | `/checkout/verify` | `checkout.verify` | Verify payment |
| GET | `/payment/callback/{payment}` | `payment.callback` | Payment gateway callback |
| GET | `/order/{order}/success` | `order.success` | Order success page |
| GET | `/order/{order}/failure` | `order.failure` | Order failure page |
| GET | `/download/{path}` | `download.file` | Secure file download |

### Admin

| Method | URL | Description |
|---|---|---|
| GET | `/admin/categories` | Category list & management |
| GET | `/admin/products` | Product list & management |
| GET | `/admin/users` | User list & management |
| GET | `/admin/orders` | Order listing |
| GET | `/admin/payments` | Payment listing |

---

## License

This project is open-sourced under the [MIT License](LICENSE).
