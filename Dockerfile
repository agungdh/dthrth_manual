FROM debian:12

WORKDIR /var/www/html

# Remove apt cache
RUN rm -rf /var/lib/apt/lists/*

# Update system
RUN apt-get update
RUN apt-get dist-upgrade -y
RUN apt-get -y install \
    build-essential \
    locales \
    zip \
    unzip \
    git \
    cron \
    supervisor \
    nano \
    screen \
    wget \
    htop \
    neofetch \
    curl

# Install install php
RUN apt-get install software-properties-common ca-certificates lsb-release apt-transport-https python3-launchpadlib -y
RUN add-apt-repository ppa:ondrej/php -y
RUN apt-get update
RUN apt-get install -y \
    php8.2-fpm \
    php8.2-redis \
    php8.2-mysql \
    php8.2-sqlite3 \
    php8.2-zip \
    php8.2-curl \
    php8.2-gd \
    php8.2-mbstring \
    php8.2-xml

# Install nginx
RUN apt-get install nginx -y 

COPY docker/nginx.conf /etc/nginx/sites-available/default

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www

USER www-data

COPY --chown=www-data:www-data . .

# Install dependency
RUN composer install --no-dev

RUN cp .env.example .env

RUN php artisan key:generate

RUN php artisan optimize

USER root

# forward request and error logs to docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log \
    && ln -sf /dev/stderr /var/log/php8.2-fpm.log

RUN apt-get update && apt-get install -y --no-install-recommends --no-install-suggests supervisor

COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord"]