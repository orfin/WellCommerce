#!/usr/bin/env bash
env=$1

/usr/local/php5/bin/php app/console doctrine:fixtures:load --env=$env --no-interaction
/usr/local/php5/bin/php app/console assets:install --env=$env
/usr/local/php5/bin/php app/console bazinga:js-translation:dump --env=$env
/usr/local/php5/bin/php app/console fos:js-routing:dump --env=$env
/usr/local/php5/bin/php app/console assetic:dump --env=$env
/usr/local/php5/bin/php app/console cache:warmup --env=$env
