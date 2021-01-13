#!/bin/bash -ex

bin/console --env=test doctrine:data:drop --force
bin/console --env=test doctrine:data:create --if-not-exists
bin/console --env=test doctrine:schema:update --force
bin/console --env=test doctrine:fi:lo -v -n
