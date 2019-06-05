#!/bin/sh

make clean

./configure --prefix=/root/www/php-7-1-7-install  --enable-cli --enable-debug \
--with-mysqli \
--with-pdo-mysql=mysqlnd \
--enable-mysqlnd \
--enable-sockets \
--enable-calendar \
--enable-bcmath \
--enable-fpm \
--enable-mbstring \
--with-curl \
--with-mcrypt  \
--enable-pcntl \
--disable-ipv6 \
--disable-debug \
--with-openssl \
--disable-maintainer-zts \

