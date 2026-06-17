# 📰 News Portal

![News Portal](screenshots/news.avif)

> A modern news management platform built with Laravel that provides powerful content management tools, user interaction features, and a comprehensive administration panel.

---

## ✨ Features

### 🔐 Authentication & Authorization
- 👤 User registration and login system
- 🛡️ Role-based access control
- 👥 Multiple user roles (User, Helper, Admin)
- 🔒 Secure admin dashboard for authorized users

### 📝 News Management
- ✍️ Create, edit, and delete news articles
- 🏷️ Assign categories to news posts
- 🔄 Automatic redirection to the news page after publishing
- 📂 Organized content structure with categories

### 👥 User Features
- 💬 Add, edit, and delete comments
- ⭐ Save favorite news articles
- 👤 Personal profile with saved posts
- 📋 View personal comment history
- 🕐 Track recently viewed news articles

### 🔍 Search
- ⚡ Real-time live search
- 💡 Instant suggestions while typing
- 🚀 Quick access to related news articles

### 📊 Analytics
- 👁️ News view tracking system
- 📈 Article popularity statistics
- 📊 User activity monitoring

### 📬 Contact System
- 📧 Contact form for sending messages
- 📨 Messages are available in the admin panel

---

## 🛠️ Admin Panel

Users with Admin and Helper roles have access to the Admin button in the navigation bar, which opens the administration panel.

### 📊 Dashboard Overview
- 📰 Total Posts
- 👁️ Total Views
- 👥 Total Users
- 💬 Total Comments
- 📈 News Views Statistics (Last 7 Days)
- 📰 Latest News

### 👥 User Management
- 📋 View all registered users
- 👤 Display user names and email addresses
- 🔑 Manage user roles

### 🏷️ Category Management
- 📂 View all categories
- 🔢 Display the number of news articles in each category
- 🗂️ Organize website content

### 📝 News Management
- ✍️ Create news articles
- ✏️ Edit existing articles
- 🗑️ Delete news posts

### 📬 Messages
- 📨 View messages submitted through the website contact form

### ⚙️ Settings
- 🎨 Customize administration panel settings
- 📝 Change the admin panel title

---

## 🛠️ Tech Stack

| Category | Technologies |
|----------|--------------|
| 🖥️ Backend | Laravel, PHP |
| 🗄️ Database | MySQL |
| 🎨 Frontend | JavaScript, Bootstrap / Tailwind CSS |
| 🐳 Container | Docker & Docker Compose |

---

## 🚀 Key Features Summary

- 🔐 Authentication & Authorization
- 🛡️ Role-Based Access Control
- 📝 News Management System
- 🏷️ Categories Management
- 💬 Comments System
- ⭐ Saved Posts
- 👤 User Profiles
- 🕐 View History
- 🔍 Live Search
- 📬 Contact Form
- 📊 Analytics Dashboard
- 🛠️ Admin Panel
- 👥 User Management

---

## 🏃 How to Run Locally
- Clone the repository  
  `git clone https://github.com/your-username/your-repo-name.git`

- Navigate into project folder  
  `cd your-repo-name`

- Launch using Docker  
  `docker-compose up -d --build`
