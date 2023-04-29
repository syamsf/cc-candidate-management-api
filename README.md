## API Documentation
### Requirement
 - PHP 8.x
 - MariaDB
 - Composer
 
### Run the apps (Front End First)
1. Make sure that you're in root directory of this repo.
2. Inside of the `frontend` directory, install all package by using this command.
    ```
      composer install
    ```
4. Copy file `.env.example` into `.env`
5. Generate app key by using this command
   ```
   php artisan key:generate
   ```
6. Run the local webserver using this command.
   ```
   php artisan serve
   ```
### Run the apps (Back End)
1. Inside of the `backend` directory, install all package by using this command.
    ```
      composer install
    ```
2. Copy file `.env.example` into `.env`
3. Generate app key by using this command
   ```
   php artisan key:generate
   ```
4. Adjust the database configuration located in `.env`
   ```
   DB_HOST=
   DB_PORT=
   DB_DATABASE=
   DB_USERNAME=
   DB_PASSWORD=
   ```
5. Execute migration by using this command.
   ```
   php artisan migrate
   ```
6. Run database seeder
   ```
   php artisan db:seed
   ```
7. Generate passport key using `php artisan passport:keys`
8. Keys are located in `storage/`. You can find it under the name `oauth-private.key` and `oauth-public.key`
9. Copy the value of those 2 file into current `.env`
10. Use this key when paste the value
    ```
    PASSPORT_PRIVATE_KEY=
    PASSPORT_PUBLIC_KEY=
    ```
11. Next step is creating personal access token.
    ```
    php artisan passport:client --personal
    ```
12. We also need create symlink in order to store file.
    ```
    php artisan storage:link
    ```
13. Then run local webserver using `php artisan serve`
14. Try to register user from the API.

### Ports
- Frontend: 8000
- Backend: 8001

### FAQ
- Why the front end need to run first instead of the backend?
  > Because the port configuration is hard coded. The plan for the next release is to dockerize this app in order to make the deployment process is simple.