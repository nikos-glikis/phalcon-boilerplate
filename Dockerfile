FROM mileschou/phalcon:7.1-apache
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update -q
RUN apt-get install -q -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" git zip vim wget
RUN apt-get install -q -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" lsb-release
#RUN wget http://dev.mysql.com/get/mysql-apt-config_0.7.3-1_all.deb
#RUN dpkg -i mysql-apt-config_0.7.3-1_all.deb
RUN echo "deb http://repo.mysql.com/apt/debian/ jessie mysql-5.6" >> /etc/apt/sources.list.d/mysql.list
RUN apt-get update -q
RUN apt-get install -q -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" --force-yes mysql-community-server
RUN apt-get install -q -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confold" --force-yes sudo
WORKDIR /var/www/html/
RUN a2enmod rewrite
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /bin/composer
RUN docker-php-ext-install pdo_mysql
VOLUME /root/.composer/
VOLUME /root/.cache/composer/
EXPOSE 80
RUN a2enmod rewrite
COPY conf/docker/000-default.conf /etc/apache2/sites-available/000-default.conf
ENTRYPOINT service mysql start && service apache2 start && chown -R www-data:www-data /var/www/html/ && ./build.sh && /bin/bash
