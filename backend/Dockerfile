FROM php:7.4-fpm
RUN apt-get update -y && apt-get install -y openssl \
    git \
    g++ \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    zlib1g-dev 
RUN docker-php-ext-install pdo pdo_mysql mysqli zip \
    intl \
    opcache 
    #  opcache  json xml intl ldap pdo_mysql mysqli
# RUN pecl install -o -f redis \
#     &&  rm -rf /tmp/pear \
#     &&  docker-php-ext-enable redis
# RUN docker-php-ext-install pdo mcrypt mbstring
WORKDIR /app
COPY . /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN cd /app && composer install
# RUN composer install

COPY ./start-container.sh /start-container.sh
RUN chmod +x /start-container.sh

EXPOSE 80

ENTRYPOINT ["/start-container.sh"]