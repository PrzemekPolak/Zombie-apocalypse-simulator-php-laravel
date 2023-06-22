#!/bin/sh

if [ -f composer.json ]; then
    echo "Laravel project exists";
    if [ -d vendor ]; then
        echo "Vendor folder exists not installing composer packages.";
    else
        echo "Install composer packages";
        composer install -vv;
    fi
else
    echo "Composer.json not found..";
fi

if [ -f .env ]; then
  echo ".env file already exists";
else
  echo "creating .env file";
  cp /var/www/html/.env.example /var/www/html/.env;
  echo "generating laravel key";
  php artisan key:generate;
fi

echo "migrating db and seeding";
php artisan migrate:fresh;
php artisan db:seed --class SimulationSettingSeeder;

if [ -f /var/www/html/package.json ]; then
    if [ -d /var/www/html/node_modules ]; then
        echo "Node modules already installed";
    else
        echo "Install node modules";
        npm --prefix /var/www/html/ install /var/www/html/;
    fi
else
    echo "No package.json file";
fi
