# Laravel Product Management

A Laravel application for managing products with Breeze authentication and dynamic DataTables.

## Features

- **Authentication**: Laravel Breeze for user login.
- **Product Management**: Add, edit, and delete products.
- **DataTables**: Dynamic table with Yajra DataTables integration.

## Installation

1. **Clone Repository**

    ```bash
    git clone https://github.com/your-username/product-management-app.git
    cd product-management-app
    ```

2. **Install Dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Configure Environment**

    ```bash
    cp .env.example .env
    ```

    Update `.env` for your database settings.

4. **Generate Key**

    ```bash
    php artisan key:generate
    ```

5. **Run Migrations**

    ```bash
    php artisan migrate
    ```

6. **Run npm**

    ```bash
   
    npm run dev
    ```


8. **Start Server**

    ```bash
    php artisan serve
    ```

    Visit `http://localhost:8000` in your browser.

## Usage

1. **Login**: Use Laravel Breeze authentication.
2. **Manage Products**:Auto redirect `/products` to:
   - **Add/Edit Product**: Use the form and buttons.
   - **Delete Product**: Click "Delete" next to the product.



## Acknowledgements

- [Laravel](https://laravel.com/)
- [Laravel Breeze](https://laravel.com/docs/9.x/starter-kits#laravel-breeze)
- [Yajra DataTables](https://yajrabox.com/docs/laravel-datatables)
