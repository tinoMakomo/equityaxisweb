# **Equity Axis Website**

The official repository of the <https://equityaxis.net> website.
<br>

**Requirements**

Check Laravel 8 Requirements <https://laravel.com/docs/8.x/deployment#server-requirements>
<br>


**Installation**

- Install dependencies: (composer install)
- Create the *.env* from the *.env.example* file: (cp .env.example .env)
- Generate application key: (php artisan key:generate)
- Set Database Credentials & App Settings in dotenv file *.env*
- Migrate Database: (php artisan migrate)
- Database seed: (php artisan db:seed)
- Start Server: (php artisan serve)
<br>

**Login Credentials**
There are 3 types of user accounts. They include:
- Admin
- Editor
- Author

After seeding. Login details as follows:

| Account Type  |  Email | Password |
| ------------- | ------- | -------- |
| Admin | admin@equityaxis.net | tadiwa |
|  Editor | editor@equityaxis.net | tadiwa |
|  Author | writer@equityaxis.net | tadiwa |
<br>

#### **Functions of Accounts**

**1. Admin**

- Manage users
- Manage categories
- Manage ads
- Manage all posts

**2. Editor**

- Manage categories
- Manage ads
- Manage all posts

**3. Author**

- Manage own posts
