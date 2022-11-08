FROM php:7.4-fpm
RUN apt update && apt install nginx sendmail libpq-dev libcurl4-openssl-dev git -y
RUN docker-php-ext-install pgsql curl mysqli
COPY transforma.conf /etc/nginx/conf.d/
COPY www.conf /etc/php/7.4/fpm/pool.d/
COPY run.sh /tmp
RUN chmod +x /tmp/run.sh
COPY . /transformagov/
WORKDIR /transformagov/
# Use time zone configurated at .env
#RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
