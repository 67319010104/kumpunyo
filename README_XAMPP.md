# Online Store Project — XAMPP Installation Guide (v2)

This guide covers how to run the project locally using XAMPP on Windows.

## Requirements
- XAMPP (PHP, MySQL, Apache)
- PHP >= 7.4 recommended
- Browser

## Installation Steps
1. Unzip the project into your XAMPP `htdocs` folder, e.g. `C:\xampp\htdocs\online_store`.
2. Start Apache and MySQL from XAMPP Control Panel.
3. Open phpMyAdmin (`http://localhost/phpmyadmin`) and import `sql/schema.sql`:
   - Create/import to create database `online_store` and tables.
4. Edit `inc/config.php` if your DB credentials differ.
5. Open `http://localhost/online_store/` in your browser.

## Accounts and Workflows
- Admin: manually create an admin user in `users` table, or use existing sample in SQL (replace password hash).
- Seller signup (`register.php`): choose 'seller' role — this creates a seller profile and shop.
- When a seller adds a product it will have `status = 'pending'` and must be approved by an admin in `admin/products.php`.
- Only `approved` products are shown on the main page.

## Cart & Checkout
- Logged-in users have a persistent cart stored in the `cart` table.
- Guests use a session-based cart.
- Checkout for logged-in users will create a record in `orders` and `order_items` and decrease product stock.

## File structure (important folders)
- `inc/` — shared includes (`config.php`, `functions.php`, `header.php`, `footer.php`)
- `seller/` — seller dashboard and management pages
- `admin/` — admin dashboard and management pages
- `assets/` — images and static assets
- `sql/schema.sql` — database schema and sample insert

## Security / Next steps (recommended)
- Use HTTPS in production.
- Improve validation and sanitization.
- Implement CSRF tokens on forms.
- Add image upload for products (with size/type checks).
- Add admin UI for refund/cancel and robust order workflows.

If you want, I can:
- Create seed data (sample sellers/products).
- Add AJAX for approve actions, pagination, and search.
- Implement file upload for product images.

Enjoy — tell me which enhancement you'd like next!
