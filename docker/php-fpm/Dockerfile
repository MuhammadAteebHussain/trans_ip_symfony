FROM php:7.3.33-fpm

#xdebug profiler directory
RUN echo xdebug.profiler_enable_trigger = 1 > /usr/local/etc/php/php.ini \
    && echo xdebug.profiler_aggregate = 1 > /usr/local/etc/php/php.ini \
    && echo xdebug.profiler_append = 1 > /usr/local/etc/php/php.ini

RUN apt-get update && apt-get install -y \
        curl \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        git \
        zip \
        unzip \
        librabbitmq-dev \
        libssh-dev \
        libpq-dev \
        wget \
    && rm -rf /var/lib/apt/lists/* \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install opcache \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install sockets \
    && docker-php-ext-enable sockets \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable pdo_mysql \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-enable pdo_pgsql \
    && docker-php-ext-install -j$(nproc) iconv

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

#install apc cache
RUN pecl install apcu \
    && echo extension=apcu.so > /usr/local/etc/php/conf.d/apcu.ini

ENV NEW_RELIC_KEY=${NEW_RELIC_KEY}
ENV NEW_RELIC_NAME=${NEW_RELIC_NAME}

#install new relic
RUN \
  curl -L https://download.newrelic.com/php_agent/archive/9.16.0.295/newrelic-php5-9.16.0.295-linux.tar.gz | tar -C /tmp -zx && \
  export NR_INSTALL_USE_CP_NOT_LN=1 && \
  export NR_INSTALL_SILENT=1 && \
  /tmp/newrelic-php5-*/newrelic-install install && \
  rm -rf /tmp/newrelic-php5- /tmp/nrinstall && \
  sed -i \
      -e 's/"REPLACE_WITH_REAL_KEY"/"${NEW_RELIC_KEY}"/' \
      -e 's/newrelic.appname = "PHP Application"/newrelic.appname = "${NEW_RELIC_NAME}"/' \
      -e 's/;newrelic.daemon.app_connect_timeout =.*/newrelic.daemon.app_connect_timeout=15s/' \
      -e 's/;newrelic.daemon.start_timeout =.*/newrelic.daemon.start_timeout=5s/' \
      /usr/local/etc/php/conf.d/newrelic.ini

WORKDIR /server/http
