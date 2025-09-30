# How to clone and use this Project
<p>Notes: Everything inside " ", copy and paste into your terminal</p>

# Requirements
<ol>
    <li>Laravel v12</li>
    <li>Node JS V22^</li>
</ol>

## Installation
<ol>
    <li>"composer install"</li>
    <li>"npm install"</li>
    <li>"cp .env.example .env" or "copy .env.example .env"</li>
    <li>"php artisan key:generate"</li>
    <li>Create a new database called 'db_assignment' or whatever you want</li>
    <li>Change databse name in .env file</li>
    <li>"php artisan migrate --seed"</li>
    <li>"php artisan storage:link"</li>
    <li>Setting integration in .env file for email verification (I'm using mailtrap.io for development testing)</li>
    <li>"php artisan serve"</li>
    <li>"npm run dev"</li>
</ol>
