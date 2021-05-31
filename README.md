1. copy `/api/env.example` to `/api/.env`
   - make sure you have correct values for .env.APP_URL, database section
2. copy `/client/.quasar.env.json.example` to `/client/.quasar.env.json`

```
cd /api
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
   - set `.env.CLIENT_URL` provided by `yarn dev`
   - from `/api` run `php artisan dusk`
