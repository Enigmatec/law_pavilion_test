# E-Commerce Analytics Optimization Test

## Project Overview

This project addresses performance bottlenecks in reporting and analytics for a growing e-commerce database. Due to high normalization, analytics queries require expensive joins across large tables. To optimize performance, we introduce a denormalized table, consolidated_orders, which consolidates customer, order, and product data into a single table.

### Setup & Installation
### Prerequisites
#### PHP 8+
#### Laravel 12
#### MySQL 
#### Composer

Installation Steps

1. Clone the repository: git clone [(https://github.com/Enigmatec/law_pavilion_test.git)]
2. Install dependencies: composer install
3. Set up environment variables:  cp .env.example .env
4. Generate Key: php artisan key:generate
5. Run database migrations: php artisan migrate
6. Run factories: php artisan tinker  followed by OrderItem::factory()->count(100)->count()
7. Start the application: php artisan serve

