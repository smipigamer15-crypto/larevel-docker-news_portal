# 📰 News Portal

## 📸 Screenshots

Here is a quick look at the application:

| Home Page | News Article |
| :---: | :---: |
| ![Home Page](https://github.com/user-attachments/assets/83ae9018-2159-4002-81a6-6cec399201c4) | ![News Article](https://github.com/user-attachments/assets/ae838f4e-c310-4576-8d4e-1b8672003527) |

| Admin Dashboard | Mobile Version |
| :---: | :---: |
| ![Admin Dashboard](https://github.com/user-attachments/assets/52a6845f-2afc-465e-9dd8-c22dbcd7d9b7) | ![Mobile Version](https://github.com/user-attachments/assets/711ab21c-927c-4090-8419-66456d5933ce) |

---

## ✨ Features

### 🔐 Authentication & Authorization
- User registration and login system with **Laravel Sanctum** (API Tokens)
- Role-based access control (User, Helper, Admin) powered by Spatie
- Secure admin dashboard for authorized users
- Profile management with avatar upload

### 📝 News Management
- Create, edit, and delete news articles
- Assign categories to news posts
- SEO-friendly URLs using **Slugs** instead of IDs
- Organized content structure with categories

### 👥 User Features
- Add, edit, and delete comments
- Save favorite news articles
- Personal profile with saved posts
- View personal comment history
- Track recently viewed news articles
- Like/unlike articles with real-time updates

### 🔍 Search & Navigation
- Real-time live search with instant suggestions
- Category filtering
- Responsive navigation with fixed username overflow (mobile-friendly)

### 📊 Analytics
- Unique news view tracking (one view per user/session)
- Article popularity statistics
- Likes tracking with admin dashboard integration
- User activity monitoring

### 📬 Contact System
- Contact form for sending messages
- Messages are available in the admin panel

---

## 🛠️ Admin Panel Overview

Users with **Admin** and **Helper** roles have access to the Admin button in the navigation bar, which opens the administration panel.

- **📊 Dashboard:** Total Posts, Total Views, Total Users, Total Comments, News Views Statistics (Last 7 Days), Latest News tracking.
- **👥 User Management:** View all registered users, display names and emails, manage user roles.
- **🏷️ Category Management:** View all categories, display the number of news articles in each category.
- **📝 News Management:** Create, edit, and delete news posts.
- **📬 Messages:** View messages submitted through the website contact form.
- **⚙️ Settings:** Customize administration panel settings and change the admin panel title.

---

## 🛠 Tech Stack

| Category | Technologies |
| :--- | :--- |
| **Backend** | PHP 8.2+, Laravel 12, Laravel Sanctum (API Auth) |
| **Database** | MySQL 8.0, Redis (Caching/Sessions) |
| **Frontend** | JavaScript, Blade Templates, Tailwind CSS, Vite |
| **Security & Roles** | Spatie Laravel Permission |
| **API Documentation** | Swagger / OpenAPI (L5-Swagger) |
| **Containerization** | Docker & Docker Compose |
| **Dev Tools** | phpMyAdmin, Composer, NPM, Pest (Testing) |

---

## 🚀 Key Features Summary

- **Authentication & Authorization:** Secure API and Web auth via Laravel Sanctum
- **Role-Based Access Control:** User, Helper, and Admin roles (Spatie)
- **News & Categories:** News management with SEO-friendly Slug URLs and category filtering
- **Comments & Moderation:** Full comment system with admin moderation capabilities
- **User Profiles:** Avatar upload, saved posts, and fast-clearing view history
- **Live Search:** Real-time search with instant suggestions
- **Analytics Dashboard:** Unique view tracking, likes system, and popularity stats
- **Admin Panel:** Full control over users, news, categories, messages, and settings
- **Contact Form:** Direct messaging system for users
- **API Documentation:** RESTful API documented via Swagger/OpenAPI

---

## 🏃 How to Run Locally

### Prerequisites
- Docker & Docker Compose
- Git

### Installation

Clone the repository and navigate to the project folder:
```bash
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name
```

Configure Environment Variables
```bash
cp .env.docker .env
```

Start Docker Containers
```bash
docker compose up -d --build
```

Install PHP Dependencies
```bash
docker compose exec app composer install
```

Generate Application Key
```bash
docker compose exec app php artisan key:generate
```

Run Database Migrations
```bash
docker compose exec app php artisan migrate --seed
```

Install Frontend Dependencies
```bash
npm install
npm run build
------------
npm run dev
```

Open the Website
```bash
http://localhost:8080
```

### 🐳 Useful Docker Commands

| Command |	Description |
| ------- | ----------- |
| ``` docker compose up -d ``` | Start containers | 
| ``` docker compose down ``` | Stop containers | 
| ``` docker compose ps ```	| Check container status |
| ``` docker compose logs -f ``` | View application logs |
| ``` docker compose restart ``` | Restart containers |
| ``` docker compose up -d --build ``` | Rebuild containers |
