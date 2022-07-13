FROM yiisoftware/yii2-php:7.4-apache

COPY . /srv/app
COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

RUN chown -R www-data:www-data /srv/app