FROM yiisoftware/yii2-php:8.3-apache

LABEL org.opencontainers.image.authors="ajdavis@audina.net"

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ='America/New_York'

# Remove g++, install composer
RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer clear-cache \
    && echo $TZ > /etc/timezone \
    && apt-get update && apt-get install -y tzdata default-mysql-client \
    && rm /etc/localtime && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && dpkg-reconfigure -f noninteractive tzdata \
    && apt-get clean

WORKDIR /app

# Copy composer files and install dependencies first
# This layer will be cached if composer.json/composer.lock haven't changed
COPY composer.json composer.lock* ./
#RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction \
#    && composer clear-cache
RUN composer install --prefer-dist --optimize-autoloader --no-interaction \
    && composer clear-cache

# Copy application files
COPY . /app

# Create / set permissions for runtime and assets directories
RUN mkdir -p /app/runtime/session /app/runtime/cache \
    && chmod -R 777 /app/runtime /app/web/assets \
    && chmod +x /app/docker-entrypoint.sh

ENTRYPOINT ["/app/docker-entrypoint.sh"]
CMD ["apache2-foreground"]