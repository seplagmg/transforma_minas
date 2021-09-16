FROM debian:stable
RUN apt update && apt install php-fpm php-pgsql \
	php-mbstring php-curl php7.4-mysql nginx sendmail git -y
COPY transforma.conf /etc/nginx/conf.d/
COPY  www.conf /etc/php/7.4/fpm/pool.d/
COPY run.sh /tmp
RUN chmod +x /tmp/run.sh
COPY . /transforma-minas/
WORKDIR transforma-minas

# install composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer

# Use time zone configurated at .env
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
