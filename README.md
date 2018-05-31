Sample scraper with Symfony4
----------------------------

Unpack the archive

$ unzip job_scraper.zip

Change dir to job_scraper

$ cd job_scraper

Install dependencies

$ composer install

Once those completed you need to connect as root to your localhost and setup the database

petrica@dev:~/job_scraper$ mysql -u root -p
Enter password: 
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 9
Server version: 5.7.22-0ubuntu0.16.04.1 (Ubuntu)

Copyright (c) 2000, 2018, Oracle and/or its affiliates. All rights reserved.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> create database db_scrape;
Query OK, 1 row affected (0,00 sec)

mysql> grant all privileges on db_scrape.* to db_scrape@localhost identified by 'db_password';
Query OK, 0 rows affected, 1 warning (0,00 sec)

mysql> flush privileges;
Query OK, 0 rows affected (0,00 sec)



# After this step you also need to run the migrations

bin/console doctrine:migrations:migrate


Having the migrations step completed we can check how the app works

We have two situations:

1) From CLI

 bin/console scraper:scrape https://www.spotifyjobs.com/search-jobs/#location=sweden


2) In Browser

For this step you can delete previous data by connecting to db and delete the records from `job` table

Run the server from console

$ bin/console server:run

Open your browser and go to http://localhost:8000/

Input https://www.spotifyjobs.com/search-jobs/#location=sweden

See results. Go back to home page.

I also made a video with usage on https://petrica-nanca.wistia.com/medias/11wz9cpce5
(make sure you set HD for viewing it)

Enjoy!

