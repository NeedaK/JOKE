# Chuckle Hub - PHP Joke Website

A simple web application built with PHP for storing, browsing, submitting, editing, and deleting jokes. Includes user registration, login, categorization, and an admin area.

## Features

*   **User Authentication:** Register new accounts, log in, log out.
*   **CRUD Operations for Jokes:**
    *   **Create:** Logged-in users can submit new jokes.
    *   **Read:** Anyone can browse and view jokes.
    *   **Update:** Users can edit their own jokes; Admins can edit any joke.
    *   **Delete:** Users can delete their own jokes; Admins can delete any joke.
*   **Categorization:** Jokes can be assigned to categories.
*   **Admin Panel:**
    *   Manage Jokes (Edit/Delete any)
    *   Manage Categories (Add/Edit/Delete)
    *   (Optional: Manage Users)
*   **Basic Search/Filtering:** (Functionality can be added/described here)
*   **Simple Interface:** Basic HTML/CSS structure.

## Technology Stack

*   **Frontend:** HTML, CSS, JavaScript (Basic)
*   **Backend:** PHP (Procedural style in this example, using PDO for database interaction)
*   **Database:** MySQL or PostgreSQL (Designed for relational databases)
*   **Web Server:** Apache or Nginx (or any server capable of running PHP)

## Setup and Installation

To run this project locally or on your own server, follow these steps:

1.  **Prerequisites:**
    *   A web server (Apache, Nginx) with PHP installed (version 7.4+ recommended).
    *   A database server (MySQL or PostgreSQL).
    *   Access to manage databases (like phpMyAdmin or command-line tools).
    *   Git (optional, for cloning).

2.  **Clone the Repository:**
    ```bash
    git clone https://github.com/your-username/chuckle-hub.git # Replace with your repo URL
    cd chuckle-hub
    ```
    Or download the ZIP file and extract it.

3.  **Database Setup:**
    *   Create a new database (e.g., `chuckle_hub_db`).
    *   Import the database schema. You can create an `.sql` file with the table definitions:
        ```sql
        -- Example SQL for creating tables (adapt for your specific schema)
        CREATE TABLE `users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `username` varchar(50) NOT NULL UNIQUE,
          `email` varchar(100) NOT NULL UNIQUE,
          `password_hash` varchar(255) NOT NULL,
          `is_admin` tinyint(1) DEFAULT 0,
          `created_at` timestamp NULL DEFAULT current_timestamp(),
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE `categories` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(100) NOT NULL UNIQUE,
          `description` text DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE `jokes` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `joke_text` text NOT NULL,
          `user_id` int(11) DEFAULT NULL, -- Submitter
          `category_id` int(11) DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT current_timestamp(),
          `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`id`),
          KEY `user_id` (`user_id`),
          KEY `category_id` (`category_id`),
          CONSTRAINT `jokes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE, -- Or restrict/cascade deletion
          CONSTRAINT `jokes_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE -- Or restrict
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        -- You might want to add a default admin user manually or via a script
        -- INSERT INTO users (username, email, password_hash, is_admin) VALUES ('admin', 'admin@example.com', 'HASH_OF_ADMIN_PASSWORD', 1);
        -- Remember to use password_hash() in PHP to generate the hash!
        ```
    *   Run this SQL script against your newly created database.

4.  **Configuration:**
    *   Edit the `config.php` file.
    *   Update the database credentials (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`) to match your setup.
    *   **IMPORTANT:** Do not commit sensitive information like passwords directly into your Git repository if it's public. Use environment variables or other secure configuration methods in a real-world scenario.

5.  **Web Server Configuration:**
    *   Place the project files in your web server's document root (e.g., `htdocs`, `www`).
    *   Ensure your web server is configured to run PHP files.
    *   Make sure the web server has write permissions if you implement file uploads (not included in this basic example).

6.  **Run:**
    *   Open your web browser and navigate to the project directory (e.g., `http://localhost/chuckle-hub/`).

## Usage

*   Navigate to the homepage to see recent jokes.
*   Click "Browse Jokes" to see a list of all jokes.
*   Click "Register" to create a new user account.
*   Click "Login" to sign in.
*   Once logged in, you can "Submit Joke".
*   View a joke's details page to see Edit/Delete options if you are the owner or an admin.
*   Admins have access to the "Admin" link in the navigation to manage categories and jokes.

## Contributing

(Optional: Add guidelines if you want others to contribute).

## License

(Optional: Add a license, e.g., MIT License).

---

*This project was created based on requirements provided.*
