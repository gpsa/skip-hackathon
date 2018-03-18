#!/bin/bash

cd .git/hooks

if [ -L pre-push ] ; then
    rm pre-push
fi

ln -s ../../hooks/pre-push pre-push

cd -

docker-compose up -d --build

if [ ! -d vendor ] ; then
    docker-compose exec zf composer install -vvv
else
    docker-compose exec zf composer update
fi