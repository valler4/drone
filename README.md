# Drone — Laravel API & Backend Application

This repository contains a robust Laravel application providing a comprehensive RESTful API and a functional web interface. The system manages products, purchases, payments, transactions, real-time chat, support tickets, and user profiles.

> **Developer Note:** I am a specialized Backend Developer. The frontend included in this repository is a minimal UI built entirely with Blade, Livewire, and Tailwind CSS (v4) to test and demonstrate the backend logic. It does not use or require custom JavaScript.

## 🚀 Key Features
- **RESTful API:** Fully functional API structured with Laravel Sanctum, complete with organized Postman collections for easy testing.
- **Multi-Gateway Payments:** Abstracted payment integration supporting Stripe, PayPal, and Paymob.
- **Real-Time Operations:** Event-driven chat system and notifications using Laravel broadcasting.
- **Advanced User Management:** Includes complex features like friend requests, security pin codes, and role-based access control.
- **Clean Architecture:** Actively utilizes Observers for side-effects, Services for external API logic, Policies for authorization, and custom Middleware for security.

## ⚙️ Quick Overview
- **Framework:** Laravel 12
- **PHP:** 8.2+ 
- **Dev Environment:** Laravel Sail (Docker)

## 🛠️ Running Locally (Recommended using Sail)
1. **Environment:** Copy environment example `cp .env.example .env` and configure your database/API keys.
2. **Start Services:** Run `vendor/bin/sail up -d` to start the Docker containers.
3. **Initialize App:**
   ```bash
   vendor/bin/sail composer install
   vendor/bin/sail artisan migrate --seed
   vendor/bin/sail artisan key:generate

Run tests:
```bash
vendor/bin/sail artisan test
```

## 📂 Repository Layout & Important Files

- `routes/` — Route definitions:
    - `api.php` — Core RESTful endpoints.
    - `web.php` — Web interface testing routes.
- `app/Http/Controllers/Api/` — API controllers handling the core logic (Auth, Products, Payments, Chat, etc.).
- `app/Services/` — Payment gateway implementations (Stripe, Paymob, PayPal) following the `PaymentGatewayInterface`.
- `app/Observers/` — Model observers reacting to system events (logging, notifications, ledger updates).
- `app/Models/` — Eloquent models with defined relationships (User, Product, Transaction, Purchase, Message, Ticket).
- `app/Http/Resources/` — JSON API resources ensuring consistent response shapes.
- `postman/` — Ready-to-use Postman collections organized by feature to explore the API.

## 🔒 Security and Authorization
- **Policies** (`app/Policies`) protect sensitive resources like products and transactions.
- **Middleware** (`app/Http/Middleware`) handles request throttling and protects admin-only routes.

---
*Feel free to explore the codebase. Contributions, feedback, and code reviews are always welcome!*
```
