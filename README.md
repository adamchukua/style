<p align="center"><img src="https://i.imgur.com/iVMMY78.png"></p>

## How to run locally
The developed application is a service, the purpose of which is to provide people with the opportunity to receive an assessment of their creative work from
professionals in this field of activity. Whether it's music, painting, or something else.
The service is used by 3 types of users: authors, experts, and administrators.
Authors can post their creations on the platform, get experts' feedback, and view other clients' work.
Experts are professionals in a particular field of activity. Their responsibilities include reviewing author work, writing reviews, and grading.
The administrator manages the operation of the service, adding experts, etc.

## How to run locally

### Windows

1. Download and install <a href="https://www.apachefriends.org/index.html" target="_blank">XAMPP</a>.
2. Download and install <a href="https://getcomposer.org/download/" target="_blank">Composer</a> by **selecting the checkbox "Add this PHP to your path"!**
3. Go to phpMyAdmin (most likely via the link http://localhost/phpmyadmin/) and create a database with the name "style" (or another).
4. Go to the folder where the project will be located and execute the `git clone https://github.com/thegradle/style` command (if you do not have git installed - download and install <a href="https://git- scm.com/downloads" target="_blank">it</a>).
5. Go to the root of the project with the `cd style' command.
6. Rename the file `.env.example` with the command to `.env`.
7. Configure the environment to your liking, or by default: in the `.env` file, replace the following lines:
   `APP_NAME=Style`
   `DB_DATABASE=style`
   For mail, register in <a href="https://mailtrap.io/" target="_blank">Mailtrap</a> service and get settings for MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_ENCRYPTION.
8. Run `composer install`.
9. Execute `php artisan key:generate`.
10. Run `php artisan migrate`.
11. Run `php artisan db:seed`.
12. Execute `php artisan storage:link`.
13. Start the local server with the `php artisan serve` command.
