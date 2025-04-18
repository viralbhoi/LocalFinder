# 🗺️ LocalFinder

**LocalFinder** is a web-based platform that helps users discover and connect with local vendors. Whether it's a grocery shop, pharmacy, or service provider, customers can search, order products, and even request delivery through a user-friendly interface. Vendors can manage inventory, view customer orders, and handle billing via their dashboards.


## 🔍 Features

### 👤 Users:
- Register/Login functionality
- Browse products from vendors
- Add to cart and place orders
- View bills, download receipts
- OTP-based verification for security
- Password reset via email OTP
- Profile view and updates

### 🧑‍💼 Vendors:
- Register/Login functionality
- Upload/manage products
- View customer orders
- Download bills
- Access to vendor dashboard

### 🛠️ Admin:
- Access dashboard
- View user and vendor data
- Manage platform integrity



## 🧪 Tech Stack

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL (configured via PDO)
- **Tools**: XAMPP (Apache + MySQL)



## 🧰 Installation Guide

### 1. Clone the Repository

git clone https://github.com/viralbhoi/LocalFinder.git

### 2. Move to XAMPP htdocs
Place the LocalFinder folder inside:
C:/xampp/htdocs/

### 3. Set Up the Database
Open phpMyAdmin (usually at http://localhost/phpmyadmin)

Create a new database named:
localfinder

Import the SQL file:
projectv3 (6).sql from the root folder

## 💡 No need to configure database credentials — credentials are already set in pdo.php:

$pdo = new PDO("mysql:host=localhost;dbname=localfinder", "root", "");

### 4. Run the Project
Start Apache and MySQL via XAMPP, then open:

http://localhost/LocalFinder/

### 🚨 Security Note
- This is a college-level project and does not implement full production-grade security. If you're planning to take it live:
- Sanitize and validate all inputs
- Use password hashing (password_hash)
- Protect against SQL injection (PDO is used, but prepared statements should be checked)
- Add sessions and token-based CSRF protection
