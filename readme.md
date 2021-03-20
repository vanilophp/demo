# Vanilo Demo Application

![v2.1.0](https://img.shields.io/badge/version-2.1.0-green.svg?style=flat-square)

This is a minimalistic Laravel 8 application that demonstrates how to build a simple storefront
using the Vanilo framework. It also contains the Vanilo admin panel.

> The app uses the default Bootstrap theme that comes with Laravel.

## Installation

**1. Get the app**:

Either download and decompress [the zipball](https://github.com/vanilophp/demo/archive/2.x.zip)
or use git:

```bash
git clone https://github.com/vanilophp/demo.git vanilo-demo
```

**2. Install Dependencies**:

```bash
cd vanilo-demo/
composer install
```

**3. Configure the environment**:

> The `.env` file is in the app's [root directory](https://laravel.com/docs/8.x/configuration#environment-configuration).

- Create a database for your application.
- Initialize .env (quickly: `cp .env.example .env && php artisan key:generate`.
- add the DB credentials to the `.env` file.

**4. Install Database**:

Run this command:

```bash
php artisan migrate --seed
```

**5. Link Storage**:

Run this command:

```bash
php artisan storage:link
```
**6. Create the first admin user**:

Run this command:

```bash
php artisan make:superuser
```
Enter your email, name, password, **accept _admin_ as role**.

**7. Open the application**:

Run the site with `php artisan serve` and access the site:

http://127.0.0.1:8000

Products are not seeded so open the admin panel first to add some products.

#### Product List

![Product list](docs/ss05_01.png)

#### Product Page

![Product page](docs/ss05_02.png)

#### Cart

![Cart](docs/ss05_03.png)

#### Checkout

![Checkout](docs/ss05_04.png)

#### Order Thank You

![Order Thank You](docs/ss05_05.png)

#### Order Admin

![Order Admin](docs/ss05_06.png)

#### Products Admin

![Products Admin](docs/ss05_07.png)

#### Manage Product

![Manage Product](docs/ss05_08.png)

#### Manage Categories

![Manage Categories](docs/ss05_09.png)

#### Manage Properties

![Manage Properties](docs/ss05_10.png)

#### Assign Product Properties

![Assign Product Properties](docs/ss05_11.png)

For further details refer to the [Vanilo Documentation](https://vanilo.io/docs/).
