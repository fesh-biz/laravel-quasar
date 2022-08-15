1. copy `/api/env.example` to `/api/.env`
   - make sure you have correct values for `.env.APP_URL`, database section
2. copy `/client/.quasar.env.json.example` to `/client/.quasar.env.json`
   - make sure you had set same value for `development.API_URL` as `.env.APP_URL`

```
cd /api

sudo find -type f -exec chmod 664 {} \;
sudo find -type d -exec chmod 755 {} \;
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache

composer install
php artisan key:generate
php artisan migrate --seed

cd ../client
yarn
```

3. in `/client` root run `yarn dev`
default user:
   - `user@app`, `password`
   
4. To run tests
   - from `/api` run `php artisan dusk:install` this command will install `ChromeDriver binaries`
      + remove `/api/tests/Browser/ExampleTest.php`
   - set values for `/api/.env` mail section
   - set `/api/.env.CLIENT_URL` provided by `yarn dev`
   - from `/client` run `yarn dev` now from `/api` you can run `php artisan dusk`
