Mango is a comprehensive **SaaS (Software as a Service)** platform designed to streamline warehouse management. It enables businesses to efficiently manage inventory, logistics, employees, customers, and suppliers. The system supports role-based access control, inventory tracking, sales and purchase management, and promotional offers.

---

## Features

- **Role-Based Access Control**: Assign roles to employees and control their permissions.
- **Inventory Management**: Track and manage inventory levels, products, and stock movements.
- **Sales & Purchase Tracking**: Manage sales orders, purchase orders, and shipments.
- **Customer & Supplier Management**: Maintain customer and supplier records.
- **Promotional Offers**: Create and manage special offers for inventory products.
- **Reporting & Analytics**: Generate reports for sales, purchases, and inventory.

---

## Technologies

- **Backend**: Laravel, PHP, MVC.
- **Frontend**: Blade, HTML, CSS, JavaScript.
- **Database**: MySQL.
- **APIs**: RESTful APIs for seamless integration.
- **Tools**: Git, GitHub, Postman, Redis, Firebase (FCM).
- **Techniques**: OOP, Design Patterns (Service Layer, Strategy, DTOs, Dependency Injection).

---

## How to Run the Project

### Prerequisites

Before running the project, ensure you have the following installed:
- PHP (>= 8.1)
- Composer
- MySQL
- Git
- Node.js (optional, if using frontend assets)

### Installation Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/mkdad-123/UWareSpace.git
   cd UWareSpace
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Set up the `.env` file**:
    - Copy the `.env.example` file to `.env`:
      ```bash
      cp .env.example .env
      ```
    - Update the `.env` file with your database credentials:
      ```plaintext
      DB_DATABASE=your_database_name
      DB_USERNAME=your_database_user
      DB_PASSWORD=your_database_password
      ```

4. **Generate an application key**:
   ```bash
   php artisan key:generate
   ```

5. **Set up JWT Secret**:
   If you're using JWT for authentication, generate the JWT secret key:
   ```bash
   php artisan jwt:secret
   ```

6. **Create storage link**:
   To make uploaded files accessible, create a symbolic link:
   ```bash
   php artisan storage:link
   ```

7. **Run migrations and seed the database**:
   ```bash
   php artisan migrate --seed
   ```

8. **Start the development server**:
   ```bash
   php artisan serve
   ```

9. **Access the application**:
   Open your browser and navigate to `http://localhost:8000`.

---
## Custom Artisan Commands

This project includes custom Artisan commands to streamline development:

### 1. **Create a Service**
- Command: `php artisan make:service {ServiceName}`
- Description: Generates a new service class in the `app/Services` directory.
- Example:
  ```bash
  php artisan make:service UserService
  ```

### 2. **Create a Trait**
- Command: `php artisan make:trait {TraitName}`
- Description: Generates a new trait in the `app/Traits` directory.
- Example:
  ```bash
  php artisan make:trait Loggable
  ```

### 3. **How to Register Custom Commands**
- To use these commands, ensure they are registered in the `app/Console/Kernel.php` file:
  ```php
  protected $commands = [
      \App\Console\Commands\MakeServiceCommand::class,
      \App\Console\Commands\MakeTraitCommand::class,
  ];
  ```
  
## Additional Package Setup

This project uses several Laravel packages that may require additional setup. Below are the instructions for each package:

### 1. **JWT-Auth (tymon/jwt-auth)**
- After installing dependencies, generate the JWT secret key:
  ```bash
  php artisan jwt:secret
  ```

### 2. **Firebase (kreait/firebase-php)**
- Obtain your Firebase credentials:
    1. Go to the [Firebase Console](https://console.firebase.google.com/).
    2. Create a new project or use an existing one.
    3. Download the service account JSON file.
- Place the JSON file in the `storage/app` directory.
- Update the `.env` file with the path to the JSON file:
  ```plaintext
  FIREBASE_CREDENTIALS=storage/app/your-firebase-credentials.json
  ```

### 3. **Laravel DomPDF (barryvdh/laravel-dompdf)**
- No additional setup is required. Ensure you have the `dompdf/dompdf` dependency installed.

### 4. **TCPDF (elibyy/tcpdf-laravel)**
- No additional setup is required.

### 5. **Laravel Sanctum (laravel/sanctum)**
- No additional setup is required.

### 6. **Laravel Telescope (laravel/telescope)**
- After running migrations, install Telescope:
  ```bash
  php artisan telescope:install
  php artisan migrate
  ```

### 7. **Spatie Laravel Permission (spatie/laravel-permission)**
- No additional setup is required. Ensure you have run the migrations.

### 8. **Spatie Laravel Query Builder (spatie/laravel-query-builder)**
- No additional setup is required.

### 9. **Laravel Cashier (laravel/cashier)**
- No additional setup is required. Ensure you have configured your Stripe keys in the `.env` file:
  ```plaintext
  STRIPE_KEY=your-stripe-key
  STRIPE_SECRET=your-stripe-secret
  ```

### 10. **Laravel Socialite (laravel/socialite)**
- No additional setup is required. Ensure you have configured your social media keys in the `.env` file if using social login.

---

## Documentation

For detailed documentation, including the **Software Requirements Specification (SRS)**, please refer to the [Documentation Folder](/docs).

---

## Contributing

If you'd like to contribute to this project, please follow these steps:
1. Fork the repository.
2. Create a new branch (`git checkout -b feature/YourFeatureName`).
3. Commit your changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/YourFeatureName`).
5. Open a pull request.

---

## Contact

If you have any questions or feedback, feel free to reach out:
- **Email**: makdad.taleb@gmail.com
- **GitHub**: [mkdad-123](https://github.com/mkdad-123)

