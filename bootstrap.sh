#!/usr/bin/env bash

#vagrant plugin install vagrant-vbguest
#sudo ln -s /opt/VBoxGuestAdditions-4.3.10/lib/VBoxGuestAdditions /usr/lib/VBoxGuestAdditions
#vagrant reload

sudo apt-get update
sudo apt-get upgrade -y virtualbox

sudo apt-get install -y build-essential
sudo apt-get install -y vim
sudo apt-get install -y apache2
sudo apt-get install -y libapache2-mod-php5
sudo a2enmod php5
sudo a2enmod rewrite

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password sempreio'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password sempreio'
sudo apt-get -y install mysql-server

sudo apt-get install -y php5-mysql
sudo apt-get install -y curl
sudo apt-get install -y php5-curl

sudo apt-get install mysql-server

sudo rm -rf /var/www
sudo ln -fs /vagrant /var/www

sudo cp /vagrant/hosts/beta /etc/apache2/sites-available/
sudo cp /vagrant/hosts/boston /etc/apache2/sites-available/
sudo cp /vagrant/hosts/dc /etc/apache2/sites-available/
sudo cp /vagrant/hosts/dev /etc/apache2/sites-available/
sudo cp /vagrant/hosts/london /etc/apache2/sites-available/
sudo cp /vagrant/hosts/milano /etc/apache2/sites-available/
sudo cp /vagrant/hosts/nyc /etc/apache2/sites-available/
sudo cp /vagrant/hosts/assets /etc/apache2/sites-available/

sudo cp /vagrant/hosts/db /etc/apache2/sites-available/

sudo a2ensite beta
sudo a2ensite boston
sudo a2ensite dc
sudo a2ensite dev
sudo a2ensite london
sudo a2ensite milano
sudo a2ensite nyc
sudo a2ensite assets

sudo a2ensite db

sudo sed -i.bak 's/display_errors = Off/display_errors = On/g' /etc/php5/apache2/php.ini
sudo sed -i.bak 's/html_errors = Off/html_errors = On/g' /etc/php5/apache2/php.ini

sudo service apache2 restart

# ruby for sass-watch
sudo apt-get install -y ruby1.9.1-full
sudo apt-get install -y rubygems
sudo gem install -y sass -v 3.2.0 # current latest, 3.3.0 does not work, see README
