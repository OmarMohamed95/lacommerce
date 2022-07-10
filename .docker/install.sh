#!/bin/sh

run()
{
    echo "Running php artisan $@"
    php artisan $@
}

run db:create
run migrate
run cache:clear