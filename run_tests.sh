#!/bin/bash
php bin/phpunit
php vendor/bin/phpstan analyse src
php vendor/bin/phpcs --standard=PSR12 src
