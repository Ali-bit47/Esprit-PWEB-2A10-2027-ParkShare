FROM php:8.3-cli
RUN docker-php-ext-install pdo_mysql
WORKDIR /app
COPY . .
RUN sed -i -E \
  -e "s/define\('DB_HOST',[^)]*\)/define('DB_HOST', getenv('MYSQLHOST'))/" \
  -e "s/define\('DB_NAME',[^)]*\)/define('DB_NAME', getenv('MYSQLDATABASE'))/" \
  -e "s/define\('DB_USER',[^)]*\)/define('DB_USER', getenv('MYSQLUSER'))/" \
  -e "s/define\('DB_PASS',[^)]*\)/define('DB_PASS', getenv('MYSQLPASSWORD'))/" \
  config/config.php
CMD php -S 0.0.0.0:${PORT:-8080} -t .
