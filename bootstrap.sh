#!/usr/bin/env bash

apt-get update
apt-get install -y build-essential
apt-get install -y vim
apt-get install -y apache2
apt-get install -y libapache2-mod-php5
a2enmod php5
a2enmod rewrite

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password sempreio'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password sempreio'
sudo apt-get -y install mysql-server

apt-get install -y php5-mysql
apt-get install -y curl
apt-get install -y php5-curl

sudo apt-get install mysql-server

rm -rf /var/www
ln -fs /vagrant /var/www

cp /vagrant/hosts/beta /etc/apache2/sites-available/
cp /vagrant/hosts/boston /etc/apache2/sites-available/
cp /vagrant/hosts/dc /etc/apache2/sites-available/
cp /vagrant/hosts/dev /etc/apache2/sites-available/
cp /vagrant/hosts/london /etc/apache2/sites-available/
cp /vagrant/hosts/milano /etc/apache2/sites-available/
cp /vagrant/hosts/nyc /etc/apache2/sites-available/

cp /vagrant/hosts/db /etc/apache2/sites-available/

a2ensite beta
a2ensite boston
a2ensite dc
a2ensite dev
a2ensite london
a2ensite milano
a2ensite nyc

a2ensite db

sed -i.bak 's/display_errors = Off/display_errors = On/g' /etc/php5/apache2/php.ini
sed -i.bak 's/html_errors = Off/html_errors = On/g' /etc/php5/apache2/php.ini

service apache2 restart

# ruby for sass-watch
apt-get install -y ruby1.9.1-full
apt-get install -y rubygems
gem install -y sass -v 3.2.0 # current latest, 3.3.0 does not work, see README
#/var/www/com.marvel/com.marvel.frontend/sites/marvel.com/www/i/css/sass/bin/sass_watcher &
