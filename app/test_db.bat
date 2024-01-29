php ./bin/console --env=test doctrine:data:drop --force --if-exists
php ./bin/console --env=test doctrine:data:create --if-not-exists
php ./bin/console --env=test doctrine:schema:update --force
php ./bin/console --env=test doctrine:fi:lo -v -n
