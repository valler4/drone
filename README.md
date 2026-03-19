# 🛸 Drone — Laravel API & Backend Application

This repository contains a robust **Laravel 12** application providing a comprehensive **RESTful API** and a functional web interface. The system is designed with a focus on scalable backend architecture, managing products, multi-gateway payments, real-time chat, and advanced user security.

> **💡 Developer Note:** I am a specialized **Backend Developer**. The frontend included in this repository is a minimal testing UI built entirely with **Blade, Livewire, and Tailwind CSS (v4)**. This project **does not use custom JavaScript**, focusing strictly on server-side logic and PHP-driven interactivity.

---

## 🚀 Key Features

* **RESTful API:** Fully structured API endpoints using **Laravel Sanctum** for secure, token-based authentication.
* **Multi-Gateway Payments:** Advanced abstraction layer supporting **Stripe, PayPal, and Paymob** integrations.
* **Real-Time Operations:** Event-driven chat system and instant notifications using **Laravel Broadcasting**.
* **Clean Architecture:**
    * **Services:** Decoupled business logic for payments and third-party integrations.
    * **Observers:** Automated side-effects (logging, ledger updates) triggered by model events.
    * **Policies:** Fine-grained authorization for all core resources.
* **Security:** Request throttling (Rate Limiting), encrypted PIN codes, and role-based access control (RBAC).

---

## ⚙️ Quick Overview

* **Framework:** Laravel 12
* **PHP:** 8.2+
* **Dev Environment:** Laravel Sail (Dockerized)
* **Database:** MySQL

---

## 🛠️ Running Locally (Recommended using Sail)

1.  **Environment:** Copy the example file: `cp .env.example .env` and configure your database/API keys.
2.  **Start Services:** Run Docker containers:
    ```bash
    vendor/bin/sail up -d
    ```
3.  **Initialize App:**
    ```bash
    vendor/bin/sail composer install
    vendor/bin/sail artisan key:generate
    vendor/bin/sail artisan migrate --seed
    ```

---

## 🔐 Default Credentials (Testing)

After running the seeder, use these accounts to explore the system:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@gmail.com` | `password` |
| **User 1** | `user1@gmail.com` | `password` |
| **User 2** | `user2@gmail.com` | `password` |

---

## 📂 Repository Layout & Architecture

* `app/Services/` — Payment implementations following the `PaymentGatewayInterface`.
* `app/Http/Controllers/Api/` — Dedicated controllers for the REST API logic.
* `app/Observers/` — Handles automated side-effects when data changes (e.g., logging transactions).
* `app/Http/Resources/` — Ensures consistent and secure JSON response shapes.
* `app/Policies/` — Fine-grained access control for products, tickets, and transactions.
* `postman/` — **Ready-to-import collections** for testing every API endpoint.

---

## 🔒 Security and Authorization

* **Authentication (Sanctum):** Secure token management for mobile or decoupled frontend requests.
* **Access Control:** All sensitive actions are protected by **Laravel Policies** (`app/Policies`).
* **Rate Limiting:** Custom **Middleware** protects API endpoints from brute-force attacks.
* **Data Integrity:** Specialized **Traits** and **Observers** ensure every critical action is logged for auditing.

---

## 🤝 Contact & Feedback

Feel free to explore the codebase. Contributions, feedback, and code reviews are always welcome!

---
