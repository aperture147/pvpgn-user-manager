FROM yiisoftware/yii2-php:7.3-apache

COPY . /app

RUN chown -R www-data:www-data runtime \
    && chown -R www-data:www-data web/assets \
    && chmod -R 777 runtime \
    && chmod -R 777 web/assets