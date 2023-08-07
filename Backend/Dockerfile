FROM wordpress:5.5.1

# run this snippet to install cron, vim, wp-cli and save the cronjob
RUN apt-get update -y \
    && apt-get install -y \
    cron \
    vim \
    openssh-server \
    && curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp \
    && mkdir /var/log/apo-reporting \
    && rm -r /var/lib/apt/lists/*

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# setup ssh
ENV SSH_PASSWD "root:Docker!"
RUN mkdir /var/run/sshd \
    && echo "$SSH_PASSWD" | chpasswd  \
    && sed -i 's/PermitRootLogin .*/PermitRootLogin yes/' /etc/ssh/sshd_config
COPY ./docker/ssh/sshd_config /etc/ssh/

# SSH login fix. Otherwise user is kicked off after login
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

ENV NOTVISIBLE "in users profile"
RUN echo "export VISIBLE=now" >> /etc/profile

# set servername
#RUN echo "ServerName Apovoice" >> /etc/apache2/apache2.conf

# set HSTS Header
RUN sed -i -E "/DocumentRoot/a Header always set Strict-Transport-Security \"max-age=31536000; includeSubDomains\"" /etc/apache2/sites-enabled/000-default.conf

# set crontabs
COPY ./docker/crontabs /var/spool/cron/crontabs
RUN chmod 600 /var/spool/cron/crontabs/root \
    && chown root:crontab /var/spool/cron/crontabs/root

# set cronjob tasks
COPY ./docker/cronjobs /usr/local/src/cronjobs
RUN find /usr/local/src/cronjobs -type f -iname "*.sh" -exec chmod +x {} \;

EXPOSE 80 22 2222

COPY ./docker/wordpress/uploads.ini /usr/local/etc/php/conf.d/
COPY . /var/www/html
CMD bash -c "composer install --no-dev --optimize-autoloader && chown -R www-data:www-data /var/www/html && /etc/init.d/cron start && printenv >> '/var/www/html/.env' && /usr/sbin/sshd && a2enmod headers && apache2-foreground"