# 📰 News Portal

![News Portal](screenshots/news.avif)

> A modern news management platform built with Laravel that provides powerful content management tools, user interaction features, and a comprehensive administration panel.

---

## ✨ Features

### 🔐 Authentication & Authorization
-  User registration and login system with JWT (Access + Refresh tokens)
-  Role-based access control (User, Helper, Admin)
-  Secure admin dashboard for authorized users
-  Profile management with avatar upload

### 📝 News Management
-  Create, edit, and delete news articles
-  Assign categories to news posts
-  SEO-friendly URLs with Slug instead of ID
-  Organized content structure with categories

### 👥 User Features
-  Add, edit, and delete comments
-  Save favorite news articles
-  Personal profile with saved posts
-  View personal comment history
-  Track recently viewed news articles
-  Like/unlike articles with real-time updates

### 🔍 Search & Navigation
-  Real-time live search with instant suggestions
-  Category filtering
-  Responsive navigation with fixed username overflow

### 📊 Analytics
-  Unique news view tracking (one view per user)
-  Article popularity statistics
-  Likes tracking with admin dashboard integration
-  User activity monitoring

### 📬 Contact System
-  Contact form for sending messages
-  Messages are available in the admin panel

---

## 🛠️ Admin Panel

Users with Admin and Helper roles have access to the Admin button in the navigation bar, which opens the administration panel.

### 📊 Dashboard Overview
-  Total Posts
-  Total Views
-  Total Users
-  Total Comments
-  News Views Statistics (Last 7 Days)
-  Latest News with likes and comments tracking

### 👥 User Management
-  View all registered users
-  Display user names and email addresses
-  Manage user roles

### 🏷️ Category Management
-  View all categories
-  Display the number of news articles in each category
-  Organize website content

### 📝 News Management
-  Create news articles
-  Edit existing articles
-  Delete news posts

### 📬 Messages
-  View messages submitted through the website contact form

### ⚙️ Settings
-  Customize administration panel settings
-  Change the admin panel title

---

## 🛠️ Tech Stack

| Category | Technologies |
|----------|--------------|
|  Backend | Laravel, PHP, JWT |
|  Database | MySQL |
|  Frontend | JavaScript, Bootstrap / Tailwind CSS |
|  API Documentation | Swagger / OpenAPI |
|  Container | Docker & Docker Compose |

---

## 🚀 Key Features Summary

-  Authentication & Authorization (JWT Access + Refresh tokens)
-  Role-Based Access Control
-  News Management System with Slug URLs
-  Categories Management
-  Comments System with Admin Moderation
-  Saved Posts & Favorites
-  User Profiles with Avatar Upload
-  View History with Fast Clearing
-  Live Search
-  Contact Form
-  Analytics Dashboard
-  Admin Panel
-  User Management
-  Likes System
-  API with Swagger Documentation
-  Unique View Tracking

---

## 📦 Recent Updates

### 🆕 New Features
- **API Implementation** - RESTful API with Swagger/OpenAPI documentation
- **JWT Authentication** - Access + Refresh tokens for secure API access
- **Like System** - Real-time likes with counter updates
- **Slug URLs** - SEO-friendly URLs instead of numeric IDs
- **Avatar Upload** - Profile picture management
- **Unique View Tracking** - Each user views an article only once

### 🎨 UI/UX Improvements
- **Admin Comment Moderation** - Administrators can edit and delete any user's comments
- **Username Overflow Fix** - Long usernames no longer overlap the search button
- **Consistent Buttons** - Delete history button now matches comment and save button styles
- **Faster History Clearing** - Optimized history deletion performance
- **Text Overflow Fix** - Long text content no longer breaks layout boundaries

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