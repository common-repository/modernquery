#!/bin/sh

composer install --no-dev

PLUGIN_DIRECTORY_NAME='modernquery'

cd ../
zip -r modernquery.zip modernquery/ -x /${PLUGIN_DIRECTORY_NAME}/node_modules/* \
-x /${PLUGIN_DIRECTORY_NAME}/.git/* \
-x /${PLUGIN_DIRECTORY_NAME}/.gitignore \
-x /${PLUGIN_DIRECTORY_NAME}/plugin_package.sh \
-x /${PLUGIN_DIRECTORY_NAME}/.phpunit.result.cache \
-x /${PLUGIN_DIRECTORY_NAME}/.eslintrc.js \
-x /${PLUGIN_DIRECTORY_NAME}/.env \
-x /${PLUGIN_DIRECTORY_NAME}/.env.example \
-x /${PLUGIN_DIRECTORY_NAME}/*.zip \
-x /${PLUGIN_DIRECTORY_NAME}/src/tests/* \
-x /${PLUGIN_DIRECTORY_NAME}/*.phar \
-x /${PLUGIN_DIRECTORY_NAME}/vendor/bin \
-x /${PLUGIN_DIRECTORY_NAME}/vendor/bin/* \
-x /${PLUGIN_DIRECTORY_NAME}/vendor/bin/phpunit \
-x /${PLUGIN_DIRECTORY_NAME}/vendor/bin/php-parse \
-x /${PLUGIN_DIRECTORY_NAME}/vendor/doctrine/* \
-x /${PLUGIN_DIRECTORY_NAME}/vendor/myclabs/* \
-x /${PLUGIN_DIRECTORY_NAME}/vendor/phar-io/* \
-x /${PLUGIN_DIRECTORY_NAME}/vendor/phpunit/* \
-x /${PLUGIN_DIRECTORY_NAME}/vendor/sebastian/* \
-x /${PLUGIN_DIRECTORY_NAME}/vendor/theseer/* \
-x /${PLUGIN_DIRECTORY_NAME}/vendor/nikic/*

cd ${PLUGIN_DIRECTORY_NAME}
composer install
