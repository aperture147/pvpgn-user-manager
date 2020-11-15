FROM yiisoftware/yii2-php:7.4-apache

RUN composer update --no-dev --apcu-autoloader -o

WORKDIR /app

COPY . .
COPY docker/web/index.php web/index

RUN chown -R www-data:www-data runtime \
    && chown -R www-data:www-data web/assets \
    && chmod -R 777 runtime \
    && chmod -R 777 web/assets