# Jansunwai

Jansunwai is basically a PHP-based application, that has been developed to make a two-way communication channel, between the voters and the politicians.

## Installation

Use the below set of commands to set up the LAMP infrastructure.

```bash
sudo apt-get update -y
sudo apt-get upgrade -y

sudo apt-get install apache2
sudo a2enmod rewrite

sudo add-apt-repository ppa:ondrej/php
sudo apt install php7.4-common php7.4-mysql php7.4-xml php7.4-xmlrpc php7.4-curl php7.4-gd php7.4-imagick php7.4-cli php7.4-dev php7.4-imap php7.4-mbstring php7.4-opcache php7.4-soap php7.4-zip php7.4-intl -y

sudo apt-get install mariadb-server-10.4 -y
sudo mysql_secure_installation

```

## Clone the repo
```bash
git clone https://github.com/Fictivebox-Media-Pvt-Ltd/jansunwai.git
```
## Import Database
Inside the folder `jansunwai/db_backup/` execute the below command to import the database.
```bash
sudo unzip jansunwai-2022-02-07-12.09.04.zip
mysql -u'DB_USERNAME' -p'DB_PASSWORD' 'DB_NAME' < jansunwai-2022-02-07-12.09.04.sql
```

## Configure the application
Open `database.php` from `jansunwai/configs/` folder path and update the `DB_HOST, DB_USERNAME, DB_PASSWORD & DB_NAME`.

```PHP
<?php
$dbhost = "DB_HOST";
$dbuser = "DB_USERNAME";
$dbpass = "DB_PASSWORD";
$db     = "DB_NAME";
```

...typing
