# 📊 Lead Tracker Frontend (Laravel)

## 🧾 Project Overview
The frontend of the Lead Tracker Application is built with Laravel as part of a full-stack developer technical assessment for The Bali Houses.

This project showcases a clean and structured frontend implementation integrated with a well-designed backend architecture using Service Layer, Repository Pattern, and standardized API responses to ensure scalability, maintainability, and separation of concerns.

---

## ⚙️ System Requirements

- PHP >= 8.2
- Composer >= 2.x
- Laravel 12
- MySQL / MariaDB

---

## 🚀 Tech Stack

- Laravel Blade (Frontend Views)
- jQuery AJAX
- DataTables Server-side Processing
- SweetAlert2 (UI Alerts)
- Bootstrap 5
- RESTful API Integration

---

## 🔗 Backend API

This frontend consumes API from:

👉 https://github.com/ilhamdjavu2/lead-tracker-backend

Make sure the backend is running before starting the frontend.

---

## ⚙️ Installation

```bash
git clone https://github.com/ilhamdjavu2/lead-tracker-frontend.git
```
```bash
cd lead-tracker-frontend
```
```bash
composer install
```
```bash
cp .env.example .env
```
```bash
php artisan key:generate
```

### ⚙️ Environment Variables

Copy `.env.example` to `.env` and configure:

```env
API_BASE_URL=http://127.0.0.1:8001/api
API_KEY=your_api_key_here
```

### Run Project
```bash
php artisan serve
```

---

## 🧠 Application Flow

- Blade renders initial UI
- DataTables fetches data via AJAX
- Laravel routes act as proxy to backend API
- jQuery handles user interactions (CRUD)
- SweetAlert2 handles confirmations and alerts

## 📦 Features

- Lead listing with server-side DataTables
- Search & filter by multiple columns
- Inline status update (dropdown + confirmation)
- Create lead via modal form (AJAX)
- Delete lead with confirmation dialog

---

## 📬 Postman Collection

👉 Import Postman Collection:
```bash
https://documenter.getpostman.com/view/1813672/2sBXirk8dd
```

---

## 👨‍💻 Author
Muhammad Ilham

---

## 📜 License
MIT License
