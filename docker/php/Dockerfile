FROM composer:2.3.7 as composer
FROM php:8.3-fpm

# Set timezone to paris AND locales
RUN echo "Europe/Paris" > /etc/timezone \
    && dpkg-reconfigure -f noninteractive tzdata \
    && apt-get autoremove \
    && apt-get update -qq \
    && apt-get install -y --no-install-recommends locales \
    && rm -rf /var/lib/apt/lists/* \
    && echo "en_US.UTF-8 UTF-8" >> /etc/locale.gen \
    && echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen \
    && locale-gen

ENV LANG=fr_FR.UTF-8 LANGUAGE=fr_FR.UTF-8 LC_ALL=fr_FR.UTF-8

# Install image dependencies
RUN apt-get update -qq \
    && apt-get install -y --no-install-recommends \
        git \
        curl \
        zip \
        unzip \
    && rm -rf /var/lib/apt/lists/*

# Install/configure php extensions
RUN apt-get update -qq \
    && apt-get install -y --no-install-recommends \
        libicu-dev \
        libxml2-dev \
        libzip-dev \
        libldap2-dev \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        intl \
        xml \
        zip \
        ldap \
    && pecl install \
        redis \
        xdebug \
    && docker-php-ext-enable \
        redis \
        xdebug \
        ldap \
    && apt-get -y purge \
        libicu-dev \
        libxml2-dev \
        libzip-dev \
    && rm -rf /var/lib/apt/list/* \
    && rm -rf /tmp/pear

# Install Composer
ENV COMPOSER_HOME=/var/composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# Install blackfire probe & CLI
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && architecture=$(uname -m) \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/$architecture/$version \
    && mkdir -p /tmp/blackfire \
    && curl -A "Docker" -L https://blackfire.io/api/v1/releases/cli/linux/$architecture | tar zxp -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire /usr/bin/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

# XDebug Configuration
ENV PHP_IDE_CONFIG="serverName=MY_SYMFONY"

# PHP Configuration
RUN sed -i -e 's/;daemonize\s*=\s*yes/daemonize = no/g' /usr/local/etc/php-fpm.conf

WORKDIR /var/www

# handle user rights
ARG UNIX_UID
ARG UNIX_GID
RUN usermod -u $UNIX_UID www-data
RUN groupmod -g $UNIX_GID www-data
USER www-data

CMD ["/usr/local/sbin/php-fpm", "--nodaemonize"]
