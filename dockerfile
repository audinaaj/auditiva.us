FROM yiisoftware/yii2-php:8.5-apache

LABEL org.opencontainers.image.authors="ajdavis@audina.net"
LABEL org.opencontainers.image.version="0.9.8"
LABEL org.opencontainers.image.title="Auditiva.us"
LABEL org.opencontainers.image.url="https://auditiva.us"
LABEL org.opencontainers.image.source="https://github.com/audinaaj/auditiva.us"
LABEL org.opencontainers.image.description="Auditiva.us is a web application for promoting and supporting Auditiva products."

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

# Copy composer files and install dependencies
RUN git config --global url."https://github.com/audinaaj/yii2-s3manager.git".insteadOf git@github.com:audinaaj/yii2-s3manager.git
COPY composer.json ./
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction \
    && composer clear-cache

# Copy application files
COPY . /app

# Create / set permissions for runtime, assets, and thumbs directories
RUN mkdir -p /app/runtime/session /app/runtime/cache /app/web/thumbs /app/web/assets \
    && chown -R www-data:www-data /app/runtime /app/web/assets /app/web/thumbs \
    && chmod -R 755 /app/runtime /app/web/assets /app/web/thumbs \
    && chmod +x /app/docker-entrypoint.sh

ENTRYPOINT ["/app/docker-entrypoint.sh"]
CMD ["apache2-foreground"]

HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/health || exit 1
