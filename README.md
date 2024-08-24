### System Specifications

| Requirements | Versions |
| :----------: | :------: |
|   LARAVEL    |   10.x    |
|     PHP      | ^8.1.10  |
|    MYSQL     |   ^10.4.25   |

## Configuration

1.  Clone this repository.

    ```bash
        $   git clone https://github.com/ericnicdao069/backend-dev-exam.git
    ```

2.  Recreate environment variable file.

    ```bash
        $   cp .env.example .env
    ```

3.  Install composer and npm.

    ```bash
        $   composer install && npm install
    ```

4.  Generate Application Key.

    ```bash
        $   php artisan key:generate
    ```

5.  Create your DB and update your DB configs in .env.

    ```bash
        $   DB_CONNECTION=mysql
        $   DB_HOST=127.0.0.1
        $   DB_PORT=3306
        $   DB_DATABASE=laravel
        $   DB_USERNAME=root
        $   DB_PASSWORD=
    ```

6.  Execute Database Migration and Seeders.

    ```bash
        $   php artisan migrate --seed
    ```

7.  Create a symlink for Storage in Public Directory.

    ```bash
        $   php artisan storage:link
    ```

8.  Generate Ziggy routes.

    ```bash
        $   php artisan ziggy:generate
    ```

9.  Run local server.

    ```bash
        $   php artisan serve
    ```

10.  Front Build.

    ```bash
        $   npm run dev
        $   npm run build
    ```
