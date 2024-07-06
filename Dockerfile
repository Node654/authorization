FROM php:8.3.8-apache

# Копируем исходный код вашего приложения Laravel в контейнер
COPY . /var/www/html
RUN docker-php-ext-install pdo_mysql

# Устанавливаем зависимости Composer, если они есть
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# RUN composer install --no-dev --optimize-autoloader

# Настраиваем права доступа
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite



# Открываем порт 80
EXPOSE 80

# Используем стандартный скрипт запуска Apache
CMD ["apache2-foreground"]
