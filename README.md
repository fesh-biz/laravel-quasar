1. copy `/api/env.example` to `/api/.env`
   - make sure you have correct values for APP_URL, database section
2. copy `/client/.quasar.env.json.example` to `/client/.quasar.env.json`

```
cd /api
composer install
art key:generate
art migrate --seed

cd ../client
yarn
```

3. in `/client` root run `yarn dev`
default user:
   - `user@app`, `password`
