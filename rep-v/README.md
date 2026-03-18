# 🍴 Digital Recipe Book | Interactive Web Application

An interactive web application for culinary enthusiasts to discover, search, and submit recipes. Built as a mini-project for the COM 2303 - Web Design course at Rajarata University of Sri Lanka.

## 🚀 Key Features

- **User Authentication**: Secure Registration, Login, and Logout features with password hashing.
- **Dynamic User Dashboard**: View dynamically pulled personal recipes from the MySQL backend.
- **Dynamic Content Loading**: Centralized data system populating recipe details into interactive modals and pages.
- **Recipe Submission**: A dedicated PHP backend interface for user-contributed recipes directly inserted into the database.
- **Contact Form**: Direct insertion of user inquiries to the database for administrative review.
- **Premium UX**: Glassmorphism header, smooth scroll navigation, and a fully responsive layout.

## 🛠 Technologies Used

- **Back-end**: PHP 8 (PDO), MySQL
- **Front-end**: HTML5, custom premium CSS3, Bootstrap 5, JavaScript (ES6)
- **Local Server Environment**: XAMPP / WAMP

## 📁 Project Structure

```text
rep-v/
├── auth/
│   ├── login.php        # User login logic
│   ├── register.php     # User registration logic
│   └── logout.php       # Logout logic
├── includes/
│   ├── db.php           # PDO database connection
│   └── functions.php    # Helper functions (auth checks, sanitization)
├── index.php            # Home Page with Hero & Featured sections
├── recipes.php          # Recipe Grid with Search & Modals
├── submit-recipe.php    # PHP Recipe Submission Form
├── dashboard.php        # User dashboard pulling dynamic recipes
├── about.php            # About page & Academic Credits
├── contact.php          # Contact form saving to database
├── script.js            # Core application logic & Interactivity
├── style.css            # Custom styling & Design tokens
├── database.sql         # Local MySQL dump for setup
└── README.md            # Setup instructions and documentation
```

## 💻 Setup Instructions (XAMPP / WAMP)

1. **Install Local Server**: Ensure you have [XAMPP](https://www.apachefriends.org/) or WAMP installed and running.
2. **Start Services**: Open your XAMPP/WAMP control panel and start both **Apache** and **MySQL**.
3. **Move Files**: Copy the entire project folder (`rep-v`) into your server's public directory:
   - For XAMPP: `C:\xampp\htdocs\rep-v`
   - For WAMP: `C:\wamp64\www\rep-v`
4. **Database Import**:
   - Open your browser and navigate to `http://localhost/phpmyadmin`
   - Create a new database named `recipe_book`.
   - Select the `recipe_book` database and click the **Import** tab.
   - Choose the `database.sql` file included in the root of this project and click **Go**.
5. **Run the Project**:
   - Open your web browser and navigate to: `http://localhost/rep-v/index.php`

## 🎓 Academic Credits

**Course**: COM 2303 - Web Design  
**University**: Rajarata University of Sri Lanka  

---
*Created with passion for food and code.*
