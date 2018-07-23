# Build command:
# docker build -t moriorgames/feature-toggle-php .
# Run command:
# docker run -td --name feature_toggle -p 8080:8080 moriorgames/feature-toggle-php
FROM        moriorgames/php72-base
MAINTAINER  MoriorGames "moriorgames@gmail.com"

# Install some packages to create http server
RUN         apt-get update --fix-missing && apt-get install -y \
            zip \
            unzip \
            git \
            apache2
RUN         echo "ServerName localhost" >> /etc/apache2/apache2.conf

# config to enable .htaccess
ADD         docker/vhost_default.conf /etc/apache2/sites-available/000-default.conf
RUN         a2enmod rewrite

# Create Application directory
RUN         mkdir -p /app && rm -fr /var/www/html && ln -s /app /var/www/html
COPY        . /app
WORKDIR     /app
RUN         chown www-data:www-data /app -R

# Composer variables
ENV         COMPOSER_HOME /app

# Build project
RUN         php /app/phars/composer.phar install --optimize-autoloader
RUN         chmod 755 -R var
RUN         chmod 755 -R public

# Expose ports
EXPOSE      8080

# Add run scripts
ADD         docker/run.sh /run.sh
RUN         chmod 755 /*.sh

ENTRYPOINT  ["/run.sh"]
