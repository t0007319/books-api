## Quick setup guide

```
mv .env.example .env
composer install
./vendor/bin/sail up
./vendor/bin/sail artisan migrate 
./vendor/bin/sail artisan db:seed 
```
If you need to check MySQL after the migrations
```
./vendor/bin/sail mysql -u sail -D laravel -h mysql -P 3306 -p 
```
You should now be able to query this api, or run the react frontend along side this to test by pulling the react app and running the following inside the projects directory
```
npm install
npm run dev
```
