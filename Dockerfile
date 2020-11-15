FROM yiisoftware/yii2-php:7.4-apache

COPY composer.json composer.json
RUN composer update --no-dev --apcu-autoloader -o

COPY . .
COPY docker/web/index.php web/index.php

ENV HOST=placeholder \
    SENDGRID_TEMPLATE_ID=placeholder \
    SENDGRID_APIKEY=placeholder \
    SENDGRID_ASM=0

RUN chown -R www-data:www-data runtime \
    && chown -R www-data:www-data web/assets \
    && chmod -R 777 runtime \
    && chmod -R 777 web/assets