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
cp .env.example .env

```
Generate Key: 
```
php artisan key:generate
```
Run database migrations: 
```
php artisan migrate

```
Open Tinker: 
```
php artisan tinker

```
Run Factories
```
OrderItem::factory()->count(100)->create()

```
Start the application: 
```
php artisan serve

```
## Available Endpoints
Export Endpoint: To export consolidation orders table data to excel file and send the file to the provided mail
```
{baseUrl}/api/export : Get
```

