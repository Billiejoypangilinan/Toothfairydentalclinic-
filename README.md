#Run

create folder "attachment" inside storage/app/public/ 
- composer install
- php artisan migrate:fresh --seed
- php artisan cache:clear
- php artisan route:clear
