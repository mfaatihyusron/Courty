FROM php:8.1-apache

# Install PHP extensions required for CodeIgniter 3 and MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite for clean routing
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . /var/www/html/

# Fix Linux case-sensitivity for CodeIgniter Models (Model.php & SportModel.php)
RUN if [ -f /var/www/html/application/models/model.php ]; then cp /var/www/html/application/models/model.php /var/www/html/application/models/Model.php; fi \
    && if [ -f /var/www/html/application/models/sportModel.php ]; then cp /var/www/html/application/models/sportModel.php /var/www/html/application/models/SportModel.php; fi

# Fix asset and upload paths for both uppercase and lowercase URLs
RUN if [ -d /var/www/html/Upload ]; then \
        mkdir -p /var/www/html/upload && \
        cp -r /var/www/html/Upload/* /var/www/html/upload/ 2>/dev/null || true; \
    fi \
    && if [ -f /var/www/html/upload/Tennis_court.jpg ]; then cp /var/www/html/upload/Tennis_court.jpg /var/www/html/upload/tennis_court.jpg; fi \
    && if [ -f /var/www/html/upload/Padel.jpeg ]; then cp /var/www/html/upload/Padel.jpeg /var/www/html/upload/padel.jpeg; fi \
    && if [ -f /var/www/html/assets/uploads/venue_profiles/venue-4-1763888300.jpeg ] && [ ! -f /var/www/html/assets/uploads/venue_profiles/venue-3-1763887402.jpeg ]; then \
        cp /var/www/html/assets/uploads/venue_profiles/venue-4-1763888300.jpeg /var/www/html/assets/uploads/venue_profiles/venue-3-1763887402.jpeg; \
    fi

# Set permissions for Apache and upload directories
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && mkdir -p /var/www/html/assets/uploads/court_profiles \
    && mkdir -p /var/www/html/assets/uploads/payments \
    && mkdir -p /var/www/html/assets/uploads/qrcodes \
    && mkdir -p /var/www/html/assets/uploads/venue_profiles \
    && chmod -R 777 /var/www/html/assets/uploads \
    && chmod -R 777 /var/www/html/application/cache \
    && chmod -R 777 /var/www/html/application/logs

EXPOSE 80

CMD ["apache2-foreground"]
