FROM php:7.2-fpm
RUN apt-get update
RUN apt-get install -y vim git wget sudo
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer
RUN useradd -m -p"MRA6Y2NFRF8II" -s /bin/bash dev
RUN adduser dev sudo
