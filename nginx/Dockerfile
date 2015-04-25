FROM ubuntu:14.04

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y \
    software-properties-common \
    python-software-properties
RUN apt-get update && apt-get upgrade -y
RUN add-apt-repository -y ppa:nginx/stable
RUN apt-get update && apt-get install -y \
    nginx

RUN echo "\ndaemon off;" >> /etc/nginx/nginx.conf
ADD vhost.conf /etc/nginx/sites-enabled/default
ADD start.sh /start.sh

EXPOSE 80

ENTRYPOINT ["/start.sh"]
