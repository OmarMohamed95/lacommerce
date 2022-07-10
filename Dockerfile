FROM php:7.3-apache

RUN apt-get update -y && apt-get install -y \
    curl\
    git\
    vim

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.3.7

RUN docker-php-ext-install bcmath pdo pdo_mysql

COPY /.docker/apache/000-default.conf /etc/apache2/sites-available

WORKDIR /var/www/html/lacommerce

COPY composer.json .
COPY composer.lock .

SHELL ["/bin/bash", "--login", "-c"]

RUN ["composer", "install", "--no-autoloader", "--no-scripts", "--no-progress"]

COPY . .

RUN chown -R $USER:www-data storage
RUN chmod -R 775 storage

RUN composer dump-autoload

RUN chmod +x .docker/install.sh
RUN [".docker/install.sh"]

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.3/install.sh | bash
RUN nvm install v12.21.0
RUN apt-get update -y && apt-get install -y npm python
RUN npm install -g npm@8.9.0
RUN npm install
RUN npm run dev

EXPOSE 8080