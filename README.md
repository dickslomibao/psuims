# Pangasinan State University - Instructional Materials System

## Overview

This project is an Instructional Materials System developed for Pangasinan State University. It's built on the Laravel framework, providing a robust platform for managing and accessing instructional materials efficiently.

## Accessing the System

1. Open your web browser.

2. Enter the following URL in the address bar: [https://psuims.online/](https://psuims.online/)

3. Press Enter.

This will take you to the login page or the main interface of the Instructional Materials System.

## Installation and Setup

### Prerequisites

- Git
- PHP
- Composer
- MySQL
- Laravel

### Installation Steps

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/dickslomibao/psuims.git
    ```

2. **Navigate to the Project Directory:**

    ```bash
    cd psuims
    ```

3. **Install Dependencies:**

    ```bash
    composer install
    ```

    This command installs the project dependencies using Composer.

4. **Database Setup:**

   - Create a new MySQL database for the project (e.g., `online_filerepo`).

   - Configure the `.env` file with your database credentials.

   - Run migrations to set up the database tables:

    ```bash
    php artisan migrate
    ```

   - **Import SQL File:**

     If you have an SQL dump file (`online_filerepo.sql`), you can import it to set up the initial database structure and data:

     ```bash
     mysql -u your_username -p online_filerepo < path/to/online_filerepo.sql
     ```

5. **Environment Configuration:**

   - Generate the application key:

    ```bash
    php artisan key:generate
    ```

   - Configure any other environment variables as needed.

6. **Start the Laravel Development Server:**

    ```bash
    php artisan serve
    ```

    Access the application by navigating to [http://localhost:8000](http://localhost:8000).


## Usage

- Log in with your credentials to access instructional materials and related features.


## Acknowledgments

We would like to acknowledge Pangasinan State University for their support and collaboration in the development of this system.

For further assistance, please contact the system administrators.

---

**Project Details:**

- **System URL:** [https://psuims.online/](https://psuims.online/)
- **GitHub Repository:** [https://github.com/dickslomibao/psuims.git](https://github.com/dickslomibao/psuims.git)

