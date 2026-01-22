<div align="center">
  <h1>🍿 MyMovieCatalog</h1>
  
  <p>
    A modern, full-stack movie database application built with <strong>Laravel 10</strong>, <strong>Tailwind CSS</strong>, and <strong>Alpine.js</strong>.
    <br />
    Users can browse movies, manage their watchlists, and leave ratings & reviews.
  </p>

   <img src="https://img.shields.io/github/languages/count/ITIvanov18/MyMovieCatalog?style=for-the-badge&color=blue" />
  <img src="https://img.shields.io/github/languages/top/ITIvanov18/MyMovieCatalog?style=for-the-badge&color=indigo" />
  <img src="https://img.shields.io/github/repo-size/ITIvanov18/MyMovieCatalog?style=for-the-badge&color=green" />
  <img src="https://img.shields.io/github/last-commit/ITIvanov18/MyMovieCatalog?style=for-the-badge&color=yellow" />
  <br />
  <img src="https://img.shields.io/badge/Made%20with-Laravel-FF2D20?style=for-the-badge&logo=laravel" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" />
  <img src="https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white" />
  <br />
</div>

---

## 🚀 Features

### 👤 User Features
* **Authentication:** Secure Login and Registration system (Laravel Breeze).
* **Personal Library:** Add movies to **Watchlist**, **Favorites**, or mark as **Watched**.
* **Reviews & Ratings:** Leave star ratings (1-5) and text reviews.
    * Dynamic validation (min 10 characters).
    * Delete your own reviews.
* **Sorting & Filtering:** Sort movies by **Newest**, **Title (A-Z / Z-A)**, or **Rating (High / Low)**.
* **Responsive Design:** Fully optimized for mobile and desktop using Tailwind CSS.

### 🛡️ Admin Features
* **Dashboard:** Special access for users with `role: admin`.
* **Movie Management (CRUD):** * Add new movies with posters (Image Upload).
    * Edit existing movie details.
    * Delete movies.
* **Content Moderation:** Admins can delete **any** user review if deemed inappropriate.

---

## 🛠️ Tech Stack

* **Backend:** PHP 8.2+, Laravel Framework
* **Frontend:** Blade Templates, Tailwind CSS
* **Interactivity:** Alpine.js (Dropdowns, Star Rating system, Flash messages)
* **Build Tools:** Node.js, NPM, Vite (Asset Bundling & HMR)
* **Database:** MySQL
* **Icons:** Heroicons / SVG Custom Branding

---

## 📸 Screenshots

*(Add screenshots of your application here later)*

---

## ⚙️ Installation

To run this project locally, follow these steps:

1. **Clone the repository**
   ```bash
   git clone [https://github.com/ITIvanov18/MyMovieCatalog]
   cd MyMovieCatalog

2. **Install Dependencies**
    ```bash
    # Install PHP dependencies
    composer install
    
    # Install Node dependencies (Tailwind, Vite, Axios)
    npm install

3. **Setup Environment**
    ```bash
    cp .env.example .env
    php artisan key:generate

4. **Configure Database**

* Create a database (e.g., movie_catalog) in MySQL.
* Update the .env file with your DB credentials:
  ```bash
  DB_DATABASE=mymoviecatalog_db
  DB_USERNAME=root
  DB_PASSWORD=

5. **Run Migrations**
    ```bash
    php artisan migrate

6. **Link Storage (Important for Posters)**
    ```bash
    php artisan storage:link

7. **Build Assets & Run**
    ```bash
    npm run build
    php artisan serve
The app will be available at `http://localhost:8000`.

---

## 🔑 Accounts
You can register a new account via the UI. To make a user an Admin:

1. Open your database (phpMyAdmin / TablePlus).
2. Find the `users` table.
3. Change the `role` column from `user` to `admin`.