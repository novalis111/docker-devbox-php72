FROM debian:stretch-slim
ENV PV 7.2 

RUN apt-get update
RUN apt-get install -y vim git wget sudo gnupg2 apt-transport-https zip unzip inetutils-ping iproute2

# Add PHP repository
RUN wget -q -O- https://packages.sury.org/php/apt.gpg | apt-key add -
RUN echo "deb https://packages.sury.org/php/ stretch main" | tee /etc/apt/sources.list.d/php.list
RUN apt-get update

# Install php
RUN apt-get install -y php${PV}-cli php${PV}-fpm php${PV}-common php${PV}-intl \
    php${PV}-curl php${PV}-fpm php${PV}-gd php${PV}-json php${PV}-mbstring \
    php${PV}-mysql php${PV}-opcache php${PV}-readline php${PV}-soap php${PV}-xml php${PV}-zip \
    php-apcu php-redis php-xdebug

RUN mkdir -p /run/php && chmod 777 /run/php

# Add user "dev" with password "dev" and passwordless sudo
RUN useradd -m -p"MRA6Y2NFRF8II" -s /bin/bash dev
RUN adduser dev sudo
RUN echo 'dev ALL=(ALL) NOPASSWD: ALL' | tee /etc/sudoers
COPY .bash_aliases /home/dev/

# Prepare workspace
RUN set -eux; \
	[ ! -d /app ]; \
	mkdir -p /app; \
	chown dev:dev /app; \
	chmod 777 /app

# xdebug config
COPY xdebug.ini /etc/php/${PV}/mods-available/

# PHP config
RUN sed -e 's/max_execution_time = 30/max_execution_time = 3000/' -i /etc/php/${PV}/fpm/php.ini
RUN sed -e 's/max_input_time = 60/max_input_time = -1/' -i /etc/php/${PV}/fpm/php.ini
RUN sed -e 's/memory_limit = 128M/memory_limit = 1024M/' -i /etc/php/${PV}/fpm/php.ini
RUN sed -e 's/display_errors = Off/display_errors = On/' -i /etc/php/${PV}/fpm/php.ini
RUN sed -e 's/post_max_size = 8M/post_max_size = 0/' -i /etc/php/${PV}/fpm/php.ini
RUN sed -e 's/upload_max_filesize = 2M/upload_max_filesize = 1024M/' -i /etc/php/${PV}/fpm/php.ini

# Get composer
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer

# entrypoint + php-fpm alias
COPY docker-php-entrypoint /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-php-entrypoint
RUN ln -s /usr/sbin/php-fpm${PV} /usr/sbin/php-fpm

ENTRYPOINT ["docker-php-entrypoint"]
WORKDIR /app

# php-fpm config
RUN set -ex \
	&& cd /etc/php/${PV}/fpm/pool.d/ \
	&& { \
		echo '[global]'; \
		echo 'error_log = /proc/self/fd/2'; \
		echo; \
		echo '[www]'; \
		echo '; if we send this to /proc/self/fd/1, it never appears'; \
		echo 'access.log = /proc/self/fd/2'; \
		echo; \
		echo 'clear_env = no'; \
		echo; \
		echo '; Ensure worker stdout and stderr are sent to the main error log.'; \
		echo 'catch_workers_output = yes'; \
	} | tee docker.conf \
	&& { \
		echo '[global]'; \
		echo 'daemonize = no'; \
		echo; \
		echo '[www]'; \
		echo 'listen = 9000'; \
	} | tee zz-docker.conf

EXPOSE 9000
CMD ["php-fpm"]
