# Project Deployment Guide

This document provides step-by-step instructions on how to deploy and run the project on a different computer using the contents of a zip folder.

## Prerequisites

Ensure that the following software is installed on the target machine:

-   **PHP** (>= 7.4)
-   **Composer** (for PHP dependencies)
-   **Node.js** (for frontend dependencies)
-   **npm** or **Yarn** (for JavaScript package management)
-   **MySQL** or a compatible database
-   **Web server** (Apache or Nginx)
-   **Git** (optional, if version control is needed)

## Steps to Deploy

### 1. **Extract the Zip Folder**

-   Download the zip folder containing the project files.
-   Extract the contents to a directory on your computer.

### 2. **Install Dependencies**

#### Backend (PHP, Laravel):

1. **Navigate to the backend directory**:

    - Open the terminal or command prompt.
    - Go to the directory where the backend files are extracted.
        ```bash
        cd /path/to/extracted/folder/backend
        ```

2. **Install PHP Dependencies**:

    - Run the following command to install Laravel dependencies using Composer:
        ```bash
        composer install
        ```

3. **Set up Environment Variables**:

    - Rename the `.env.example` file to `.env`:
        ```bash
        mv .env.example .env
        ```
    - Open the `.env` file in a text editor and set up the following environment variables:
        - **APP_KEY**: You need to generate a new APP_KEY:
            ```bash
            php artisan key:generate
            ```
        - **Database Connection**: Set up the database settings for MySQL or the database of your choice:
            ```env
            DB_CONNECTION=mysql
            DB_HOST=127.0.0.1
            DB_PORT=3306
            DB_DATABASE=your_database_name
            DB_USERNAME=your_database_user
            DB_PASSWORD=your_database_password
            ```

4. **Migrate the Database**:

    - Run migrations to create the database tables:
        ```bash
        php artisan migrate
        ```

5. **Install NPM Dependencies (for frontend)**:
    - Navigate to the `frontend` directory (if applicable) and install JavaScript dependencies:
        ```bash
        cd /path/to/extracted/folder/frontend
        npm install
        ```

#### Frontend (Optional):

1. **Build the Frontend**:
    - After installing dependencies, build the assets using npm:
        ```bash
        npm run dev
        ```
    - For production builds:
        ```bash
        npm run prod
        ```

### 3. **Start the Laravel Development Server**

If you're running the application on a local server (e.g., Laravel’s built-in development server), use the following command:

```bash
php artisan serve
```

By default, the application will be available at `http://localhost:8000`. You can change the port by specifying a different one:

```bash
php artisan serve --port=8080
```

Alternatively, you can set up a local web server like **Apache** or **Nginx** to serve your Laravel application.

### 4. **Verify Database Configuration**

If you are using a database, ensure the database is properly set up. If you haven’t done so already, run the following command to populate the database with seed data (if available):

```bash
php artisan db:seed
```

### 5. **Access the Application**

After completing the steps above, open a browser and go to:

```
http://localhost:8000
```

Or the custom URL if you're using Apache or Nginx.

### 6. **Optional: Set Up a Production Environment**

If you want to deploy this application on a production server, follow these additional steps:

1. **Set the APP_ENV to production**:

    - In `.env`, change the environment:
        ```env
        APP_ENV=production
        ```

2. **Optimize Laravel for Production**:
   Run the following commands to optimize performance:

    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

3. **Set Up a Web Server**:
   Set up **Apache** or **Nginx** to point to the `public` directory of your Laravel application.

4. **Set Proper File Permissions**:
   Ensure that the `storage` and `bootstrap/cache` directories have the correct permissions:

    ```bash
    sudo chmod -R 775 storage bootstrap/cache
    ```

5. **Start the Web Server**:
   If you're using Apache, restart the service:
    ```bash
    sudo service apache2 restart
    ```

### 7. **Troubleshooting**

-   If you encounter any issues during installation, refer to the Laravel logs (`storage/logs/`) for more detailed error information.
-   Check for any missing dependencies by running:
    ```bash
    composer install
    npm install
    ```

### 8. **Cleaning Up**

After deployment, remove any development or sensitive files:

-   Delete `.env` or keep it secured.
-   Optionally, remove the `node_modules` directory after production builds to save space.

---

### **Conclusion**

This document should help you deploy the project on a new machine using a zip folder. If you face any issues, feel free to check the logs or revisit the installation steps to ensure all dependencies are correctly set up.
