FROM debian:stretch-slim

RUN apt-get update
RUN apt-get install -y vim git wget sudo gnupg2 apt-transport-https

# Add PHP repository
RUN wget -q -O- https://packages.sury.org/php/apt.gpg | apt-key add -
RUN echo "deb https://packages.sury.org/php/ stretch main" | tee /etc/apt/sources.list.d/php.list
RUN apt-get update

# Install php
RUN apt-get install -y php7.2-cli php7.2-fpm
RUN mkdir -p /run/php && chmod 777 /run/php

# Add user "dev" with password "dev"
RUN useradd -m -p"MRA6Y2NFRF8II" -s /bin/bash dev
RUN adduser dev sudo

# Configure php
RUN set -eux; \
	[ ! -d /var/www/app ]; \
	mkdir -p /var/www/app; \
	chown dev:dev /var/www/app; \
	chmod 777 /var/www/app

# Get composer
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer

COPY docker-php-entrypoint /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-php-entrypoint

ENTRYPOINT ["docker-php-entrypoint"]
WORKDIR /var/www/app

RUN set -ex \
	&& cd /etc/php/7.2/fpm/pool.d/ \
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
CMD ["php-fpm7.2"]
