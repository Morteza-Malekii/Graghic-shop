# Graphic-Shop

> **EN**: An online marketplace for digital graphic assets built with Laravel.  
> **FA**: فروشگاه آنلاین فایل‌های گرافیکی بر پایه لاراول.

---

## 🔹 English

### Description  
An online marketplace where users can browse, purchase and download high-quality graphic files. Admins manage products, orders and payments via a secure backend panel.

### Features  
- Shopping Cart & Checkout  
- Zarinpal Payment Integration  
- Role-Based Access Control  
- Secure File Downloads  
- Clean Architecture (Service Layer, Form Requests, DI)

### Installation  
1. `git clone …`  
2. `composer install && npm install`  
3. `cp .env.example .env && php artisan key:generate`  
4. Configure `.env` (DB, Zarinpal)  
5. `php artisan migrate --seed`  
6. `php artisan storage:link`  
7. `npm run dev`

---

## 🔹 فارسی

### توضیحات  
فروشگاه آنلاین فایل‌های گرافیکی که به کاربران امکان مرور، خرید و دانلود فایل‌های باکیفیت را می‌دهد. مدیران از طریق پنل امن محصولات، سفارش‌ها و پرداخت‌ها را مدیریت می‌کنند.

### ویژگی‌ها  
- سبد خرید و تسویه حساب  
- درگاه پرداخت زرین‌پال  
- کنترل دسترسی بر پایه نقش  
- دانلود امن فایل‌ها  
- معماری تمیز (Service Layer، Form Request، DI)

### نصب و راه‌اندازی  
1. `git clone …`  
2. `composer install && npm install`  
3. `cp .env.example .env && php artisan key:generate`  
4. پیکربندی `.env` (پایگاه‌داده و درگاه زرین‌پال)  
5. `php artisan migrate --seed`  
6. `php artisan storage:link`  
7. `npm run dev`
