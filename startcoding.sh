#!/bin/bash
if [ ! -L .git/hooks/pre-push ] ; then
    ln -s hooks/pre-push .git/hooks/pre-push
fi

docker-compose up -d --build

if [ ! -d vendor ] ; then
    docker-compose exec zf composer install -vvv
else
    docker-compose exec zf composer update -vvv
fi