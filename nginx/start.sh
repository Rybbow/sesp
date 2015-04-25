#!/bin/bash

/bin/sed -i "s@<APP_SERVER_NAME>@${APP_SERVER_NAME}@" /etc/nginx/sites-enabled/default

/usr/sbin/nginx