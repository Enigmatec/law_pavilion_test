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

Clone the repository:
```
git clone https://github.com/Enigmatec/law_pavilion_test.git
```

Install dependencies: 
```
composer install
```
Set up environment variables:  
```
Generate Key: php artisan key:generate
```
Run database migrations: 
```
php artisan migrate

```
Run factories: 
```
php artisan tinker  followed by OrderItem::factory()->count(100)->count()
```
Start the application: 
```
php artisan serve

