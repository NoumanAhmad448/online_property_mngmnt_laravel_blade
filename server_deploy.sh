# Turn on maintenance mode
php artisan down || true

#Install/update composer dependecies
# /opt/cpanel/composer/bin/composer update --no-cache

# Install/update composer dependecies
# /opt/cpanel/composer/bin/composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-cache

# Install Specific package
# /opt/cpanel/composer/bin/composer require spatie/laravel-permission


# Clear caches
# php artisan cache:clear
php artisan optimize # will cache config and routes

# will cache events
php artisan event:cache

# Clear and cache routes
php artisan route:cache

# Clear and cache config
php artisan config:cache

#generate artisan key
yes | php artisan key:generate

# change folder permission
yes | chmod -R 777 ~/public_html/website_7171ee6c/storage/ ~/public_html/website_7171ee6c/bootstrap/cache
# read only permission
# yes | chmod 444 file_name
# read & write only permission
# yes | chmod 666 file_name

# Run seeder
# yes | php artisan db:seed

# Run database migrations
php artisan migrate --force

# Install node modules
#npm install

# Build assets using Laravel Mix
#npm run prod

# check project health notification
php artisan health:check --no-notification

# runs cron
php artisan schedule:run >> /dev/null 2>&1

# Turn off maintenance mode
php artisan up
