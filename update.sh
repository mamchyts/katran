#!/bin/bash

git pull
composer update
cd ./app/migration/ && ./_migrate.sh