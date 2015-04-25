#!/bin/bash

/bin/sed -i "s@<APP_HOST>@${APP_1_PORT_17017_TCP_ADDR}@" /var/www/web/index.html

#/bin/bash -l -c "$*"
php /var/www/app/server.php
