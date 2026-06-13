# Ranch Management Database System

## Overview

This project is a browser-based ranch management database application built with **PHP**, **MySQL/MariaDB**, and **XAMPP**.

The system provides a simple interface for viewing and managing ranch-related records, including employees, pastures, equipment, cattle, health records, financial transactions, and relationship tables.

All records included in the SQL files are **fictional demonstration data** created for educational and portfolio purposes.

## Main Features

* View all records in each database table
* Search across all columns of a selected table
* Add new records
* Edit existing records
* Delete records with confirmation
* Session-based login and logout
* Role-based access control
* CSRF protection for POST requests
* PDO-based MySQL database connection
* Database constraints, primary keys, and foreign keys

## User Roles

The application contains three demonstration roles:

| Role      | Permissions                          |
| --------- | ------------------------------------ |
| `viewer`  | View and search records              |
| `manager` | View, search, add, and edit records  |
| `admin`   | Full CRUD access, including deletion |

### Demo Login Credentials

| Username  | Password     |
| --------- | ------------ |
| `viewer`  | `viewerpwd`  |
| `manager` | `managerpwd` |
| `admin`   | `adminpwd`   |

These accounts are hard-coded for demonstration purposes and should not be used in a production system.

## Database Schema

The database is named `cbase` and contains nine tables:

| Table          | Purpose                                                               |
| -------------- | --------------------------------------------------------------------- |
| `Employee`     | Stores employee names, roles, phone numbers, and hire dates           |
| `Pasture`      | Stores pasture names, areas, and soil types                           |
| `Equipment`    | Stores equipment type, purchase date, condition, and assigned pasture |
| `Cattle`       | Stores cattle breed, sex, birth date, weight, status, and pasture     |
| `HealthRecord` | Stores cattle health visits, temperature, diagnosis, and treatment    |
| `Transaction`  | Stores cattle-related sales and purchases                             |
| `Treats`       | Connects employees with cattle they treat                             |
| `Manages`      | Connects employees with pastures they manage                          |
| `Financial`    | Connects cattle with financial transactions                           |

### Main Relationships

* One pasture can contain multiple cattle.
* One pasture can have multiple pieces of equipment.
* One animal can have multiple health records.
* Employees and cattle are connected through `Treats`.
* Employees and pastures are connected through `Manages`.
* Cattle and transactions are connected through `Financial`.

## Project Structure

```text
.
├── auth.php
├── config.php
├── create.sql
├── cbase.sql
├── db.php
├── delete.php
├── edit.php
├── footer.php
├── header.php
├── index.php
├── load.sql
├── login.php
├── logout.php
├── view.php
└── README.md
```

The current `header.php` also references:

```text
assets/style.css
```

The application can still function without this file, but it will appear without custom styling. Add the stylesheet and `assets` directory if they are available.

## File Descriptions

| File         | Description                                                                      |
| ------------ | -------------------------------------------------------------------------------- |
| `index.php`  | Displays links to all ranch database tables                                      |
| `login.php`  | Handles demonstration user login                                                 |
| `logout.php` | Ends the current session                                                         |
| `auth.php`   | Implements role checking and CSRF validation                                     |
| `config.php` | Stores local database settings and starts the session                            |
| `db.php`     | Creates a reusable PDO connection and search helper                              |
| `view.php`   | Displays and searches table records                                              |
| `edit.php`   | Adds new records and updates existing records                                    |
| `delete.php` | Deletes records; restricted to administrators                                    |
| `header.php` | Shared page header and navigation                                                |
| `footer.php` | Shared page footer                                                               |
| `create.sql` | Recreates the `cbase` database and its table structure                           |
| `load.sql`   | Loads the original fictional sample records                                      |
| `cbase.sql`  | Full phpMyAdmin export containing the database structure and current sample data |

## Requirements

* Windows, macOS, or Linux
* XAMPP or another Apache/PHP/MySQL environment
* PHP 8 or later
* MySQL or MariaDB
* PDO MySQL extension
* Web browser

The included full SQL dump was exported from MariaDB 10.4.32 using phpMyAdmin 5.2.1 and PHP 8.2.12.

## Local Installation

### 1. Install XAMPP

Install XAMPP and open the XAMPP Control Panel.

Start:

```text
Apache
MySQL
```

### 2. Copy the Project into `htdocs`

Place the repository folder inside:

```text
C:\xampp\htdocs\
```

For example:

```text
C:\xampp\htdocs\ranch-db
```

### 3. Open phpMyAdmin

Open the following address in a browser:

```text
http://localhost/phpmyadmin/
```

## Database Setup
### Method A: Import the Full Database Dump

This is the simplest method.

1. Open phpMyAdmin.
2. Select the **Import** tab.
3. Choose `cbase.sql`.
4. Click **Import** or **Go**.

This file contains the database structure and the current fictional sample records.

### Method B: Rebuild the Database from Separate Scripts

Use this method to recreate the original schema and starter data.

1. Open the phpMyAdmin **Import** tab.
2. Import `create.sql`.
3. After it completes, import `load.sql`.

Import the files in this order:

```text
create.sql
load.sql
```

Do not import `cbase.sql` after using this method, because doing so may recreate tables or duplicate existing records.

## Database Configuration

The application uses the following local XAMPP settings in `config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'cbase');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
```

The default XAMPP MySQL root account commonly uses an empty password. Update `DB_USER` and `DB_PASS` if the local MySQL configuration is different.

The database password only gives the PHP application access to the configured MySQL account.

## Running the Application

After Apache and MySQL are running and the database has been imported, open:

```text
http://localhost/ranch-db/login.php
```

Replace `ranch-db` with the actual name of the folder inside `htdocs`.

After logging in, the home page lists the following tables:

```text
Employee
Pasture
Equipment
Cattle
HealthRecord
Transaction
Treats
Manages
Financial
```

## Application Workflow

```text
User logs in
      |
      v
Session role is assigned
      |
      v
User selects a database table
      |
      v
PHP sends a query through PDO
      |
      v
MySQL returns the records
      |
      v
The browser displays search and permitted actions
```

## Limitations and Future Improvements

This application is an educational demonstration and is not production-ready.

Potential improvements include:

* Store user accounts in the database
* Replace hard-coded demonstration credentials
* Add stronger validation for form inputs
* Add more descriptive error handling
* Add a complete CSS interface
* Etc.

## Notice

All names, phone numbers, cattle records, health records, and financial records in this repository are fictional demonstration entries. They do not represent a real ranch or real individuals.

## Authors

**Shunzhi Yu**

**Songtao Zhang**

::: 
