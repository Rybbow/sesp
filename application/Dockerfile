FROM ubuntu:14.04

ENV DEBIAN_FRONTEND noninteractive
ENV LANG C.UTF-8

RUN apt-get update && apt-get install -y \
    software-properties-common \
    python-software-properties
RUN apt-get update && apt-get upgrade -y
RUN add-apt-repository -y ppa:ondrej/php5-5.6
RUN apt-get update && apt-get install -y \
    git \
    curl \
    php5-cli \
    php5-json \
#    libevent \
#    libevent-dev \
#    php5-libevent \
    php5-intl

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

ADD entrypoint.sh /entrypoint.sh
ADD ./code /var/www
ADD php_environment.sh /etc/profile.d/php_environment.sh

WORKDIR /var/www

EXPOSE 17017

ENTRYPOINT ["/entrypoint.sh"]