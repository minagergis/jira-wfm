@story('deploy')
installation
@endstory

@task('installation')
    cd /opt/lampp/htdocs
    composer install --no-interaction
    php artisan cache:clear
    php artisan config:clear
    php artisan view:clear
    php artisan optimize:clear
    php artisan optimize
    php artisan queue:restart
@endtask
