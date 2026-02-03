# Laravel 11 Task Manager

A simple and modern **Task Manager** built with **Laravel 11**, **PHP 8.3**, and **MySQL**. The application supports **AJAX-powered CRUD operations**, **drag & drop task reordering**, and **project-based filtering** with a fully responsive UI.

---

## 🚀 Features

- **CRUD Operations**  
  Create, edit, and delete tasks easily.

- **Drag & Drop Reordering**  
  Reorder tasks visually with automatic priority updates stored in the database.

- **Project Management**  
  Assign tasks to projects and filter tasks by project.

- **AJAX Powered**  
  All interactions happen without page reloads for a smooth UX.


---

## 🔹 Requirements

- **PHP**: 8.3+
- **Framework**: Laravel 12
- **Database**: MySQL  
  > ⚠️ SQLite is **not supported** for this implementation
- **Dependency Manager**: Composer
- **Node.js & npm**: Optional (only if you want to compile assets)

---

## 🔹 Installation (Step-by-Step)

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/Fayaz-Codify/taskmanager-.git
cd taskmanager-
```

---

### 2️⃣ Install Composer Dependencies

```bash
composer install
```

---

### 3️⃣ Environment Setup

Create the environment file:

```bash
cp .env.example .env
```

---

### 4️⃣ Configure Database

Edit the `.env` file and update your MySQL credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```

---

### 5️⃣ Generate Application Key

```bash
php artisan key:generate
```

---

### 6️⃣ Run Migrations & Seeders

Run database migrations:

```bash
php artisan migrate
```

Seed the projects table:

```bash
php artisan db:seed --class=ProjectSeeder
```

---

### 7️⃣ Start the Development Server

```bash
php artisan serve
```

Application will be available at:

```
http://127.0.0.1:8000
```

---

## 🔹 Usage

- **Filtering**  
  Select a project from the dropdown to view related tasks.

- **Add Task**  
  Use the main input field to quickly add a new task.

- **Edit Task**  
  Click **Edit** to open a modal popup and update the task.

- **Delete Task**  
  Click **Delete** to permanently remove a task.

- **Reorder Tasks**  
  Drag and drop tasks to change their order. Priorities update automatically via AJAX.

---

## 🔹 Notes

- **Database Consistency**  
  Task ordering logic is optimized for **MySQL**. SQLite is not supported.

- **User Experience**  
  All actions (add, edit, delete, reorder) are handled via AJAX to avoid page reloads.

---

## 🔹 Deployment

### Manual Deployment (Shared Hosting / VPS)

1. Upload the project files to your server.
2. Update `.env` for production and set:

```env
APP_ENV=production
APP_DEBUG=false
```

3. Install dependencies:

```bash
composer install --optimize-autoloader --no-dev
```

4. Run migrations:

```bash
php artisan migrate --force
```

5. Optimize the application:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Example Deployment Configuration

```yaml
deployment:
  server: production
  root_path: /var/www/html/taskmanager
  public_path: /var/www/html/taskmanager/public
  php_version: 8.3
  commands:
    - composer install --optimize-autoloader --no-dev
    - php artisan migrate --force
    - php artisan config:cache
    - php artisan route:cache
    - php artisan view:cache
```

---

## 👤 Author

**Fayaz Ahmad**  
Laravel & Web Developer

