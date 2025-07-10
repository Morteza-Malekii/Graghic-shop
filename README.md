راهنمای پروژه «Graphic-Shop»

فروشگاه آنلاین فایل‌های گرافیکی بر پایه لاراول.

توضیحات

Graphic-Shop به کاربران امکان می‌دهد فایل‌های گرافیکی باکیفیت را مرور، خرید و دانلود کنند. مدیران می‌توانند از طریق پنل مدیریت امن، محصولات، سفارش‌ها و پرداخت‌ها را کنترل و پیگیری کنند.

ویژگی‌ها
	•	سبد خرید و پرداخت: افزودن محصول به سبد، ویرایش تعداد، حذف آیتم و تسویه حساب.
	•	درگاه پرداخت زرین‌پال: ایجاد فاکتور، ریدایرکت به درگاه، دریافت callback و تایید تراکنش.
	•	کنترل دسترسی بر پایه نقش: تفکیک کاربران Admin و User با میانی‌افزار (middleware) برای امنیت بیشتر.
	•	دانلود امن: ذخیرهٔ خصوصی فایل‌ها و استریم دانلود از طریق کنترلر؛ امکان فشرده‌سازی ZIP برای دانلود دسته‌جمعی.
	•	معماری تمیز: استفاده از روابط Eloquent، ساختار Service Layer، Form Request برای اعتبارسنجی و تزریق وابستگی (DI) برای کد قابل نگهداری.

پیش‌نیازها
	•	PHP نسخهٔ 8.0 یا بالاتر
	•	لاراول 10
	•	پایگاه‌داده MySQL یا هر دیتابیس سازگار با PDO
	•	Composer و Node.js / npm

نصب و راه‌اندازی
	1.	کلون کردن مخزن

git clone https://github.com/username/graphic-shop.git
cd graphic-shop


	2.	نصب وابستگی‌ها

composer install
npm install


	3.	تنظیم محیط

cp .env.example .env
php artisan key:generate


	4.	پیکربندی دیتابیس و درگاه پرداخت
در فایل .env مقادیر زیر را تنظیم کنید:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=graphic_shop
DB_USERNAME=root
DB_PASSWORD=

PAYMENT_DRIVER=zarinpal
ZARINPAL_MODE=sandbox
ZARINPAL_TERMINAL_ID=your_merchant_id
ZARINPAL_CALLBACK_URL=http://your-domain.com/payment/callback/{payment}


	5.	اجرای مهاجرت‌ها و seederها

php artisan migrate --seed


	6.	لینک سمبولیک storage

php artisan storage:link


	7.	کامپایل فایل‌های فرانت‌اند

npm run dev



نحوهٔ استفاده
	•	به آدرس / مراجعه و محصولات را مرور کنید.
	•	محصولات دلخواه را به سبد اضافه و سپس اقدام به پرداخت نمایید.
	•	پس از پرداخت موفق، لینک‌های دانلود در صفحهٔ موفقیت نمایش داده می‌شوند.
	•	پنل مدیریت امن در /admin برای مدیریت محصولات، سفارش‌ها و کاربران فعال است.

ایجاد کاربر ادمین

برای ساخت کاربر با نقش Admin در Tinker:

php artisan tinker
>>> \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin'
]);

سپس از طریق /admin/login وارد پنل شوید.

مشارکت در پروژه
	1.	مخزن را fork کنید
	2.	شاخهٔ جدید بسازید: git checkout -b feature/YourFeature
	3.	تغییرات را commit و push کنید
	4.	Pull Request ارسال کنید

مجوز

این پروژه تحت مجوز MIT منتشر شده است.
