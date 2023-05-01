# README #

# Thrivr/Instawalkin

Welcome to the official GitHub repository for Thrivr/Instawalkin, a groundbreaking last-minute booking platform designed to integrate with all scheduling software without the need for API usage. This repository contains the source code and documentation for our project, which was initially developed on Bitbucket from 2018-2020.

## Project Background

Thrivr/Instawalkin was created to address the need for a seamless, last-minute booking solution that could easily sync with existing scheduling systems without relying on APIs. Our platform aims to streamline the booking process and improve user experiences for customers and businesses by offering an efficient and versatile tool.



This README contains the steps to get the Thrivr Backend running on your Desktop/Macbook

1. [Requirements](#markdown-header-1-requirements)
2. [Steps to setup the app](#markdown-header-2-steps-to-setup-the-app)
3. [How to run _Composer_ on Docker](#markdown-header-3-how-to-run-composer-on-docker)
4. [How to run _Artisan_ on Docker](#markdown-header-4-how-to-run-artisan-on-docker)
5. [Other _docker_ commands to be aware of](#markdown-header-5-other-docker-commands-to-be-aware-of)
6. [If having issues after changing your .env](#markdown-header-6-if-having-issues-after-changing-your-env)
7. [Test Authentication and App](#markdown-header-7-test-authentication-and-app)
8. [How to populate the database](#markdown-header-8-how-to-populate-the-database)
9. [Passport keys](#markdown-header-9-passport-keys)
10. [Setup local database](#markdown-header-10-setup-local-database)
11. [Run App](#markdown-header-11-run-app)
12. [Resolve Composer Errors](#markdown-header-12-resolve-composer-errors)
13. [Contribution guidelines](#markdown-header-13-contribution-guidelines)



## **1. Requirements** ###

1. To get started, make sure you have [Docker installed](https://www.docker.com/products/docker-desktop) on your system, and then clone this repository.

2. [Download Postman](https://www.postman.com/downloads/)

3. [Download Sequel Pro for Mac](https://www.sequelpro.com/) or [Download MySQl Workbench for Windows](https://www.mysql.com/products/workbench/)




### **2. Steps to setup the app** ###

1. Copy the .env.example file to your .env file. The blow values will confirm that all notifications go to your device. Update the following
    * **TWILIO\_DEBUG\_TO** and change that to your phone number
    * **MAIL\_TO\_ADDRESS** change that to your email

2. cd to folder that you just cLoned - default is instawalkin
    *  cd instawalkin

3. To build your app run. Note. This will take a bit
    * docker-compose build app

4. To get the app up (deploy on your local) run
    * docker-compose up -d

5. Now Run composer to install all dependencies. [If errors read Note here](#markdown-header-12-resolve-composer-errors) 
    * docker-compose exec app composer install



6. Migrate the migrations. 
    * docker-compose exec app bash
    * php artisan migrate
    * php artisan config:cache
    * php artisan config:clear
    * exit



### **3. How to run _Composer_ on Docker** ###
1. To Install
    * docker-compose exec app composer install
1. To Update
    * docker-compose exec app composer update


### **4. How to run _Artisan_ on Docker** ###
1. First run 
      * docker-compose exec app bash
2. This will open a bash in your laravel app container. You can run all laravel commands here with ease 
      * eg php artisan clear:cache, php artisan config:cache





### **5.Other _docker_ commands to be aware of** ###

1. Check if all containers are up and running by running the command 
    * docker ps 
2. Bring down app 
    * docker-compose down      



### **6.If having issues after changing your .env:** ###

  
    >     docker-compose exec app bash
    >     php artisan cache:clear
    >     php artisan config:cache
    >     php artisan config:clear




### **7. How to populate the database** ###
  TODO -> for now ask Aj


### **8.Passport keys** ###
  TODO -> for now ask Aj 

### **9. Setup local database** ###

1. Open Sequel Pro or MySql Workbench
2. Connect to the DB instance that was created 
    * Host: 127.0.0.1
    * Username: root
    * Password: 12345678
    * Database: instawalkin
    * Port: 3307
3. Test Connection
4. If succesfful, connect and make sure tables exists in the database. Eg Users, Admins, Managers

### **10. Run App** ###

1. To test if the app loads fine please visit in your browser
          > http://localhost:8002/admininsta/login

### **11. Test Authentication  App** ###

1. Access localhost admin to ensure working
    * http://localhost:8002/admininsta/login, you can use a@mail.com password test1234
2. Make sure to start you passport server on the laravel app. We use passport for oAuth. Users and Managers use oAuth. Admins use normal authentication (Step 11.1). To test your passport auth do these steps Note. You can start a separate cmd line for this. This has to be running for anything on Postman and Frontend
    * docker-compose exec app bash
    * php artisan serve --port 8003
    * Start Postman. You should have access to the instawalkin collection.
        * Environment - select dev-users
        * Select API for Creole Studios
        * Select the login route from Login Users
        * Change email to m@mail.com 
        * Passowrd to Test1234 
        * Send. If you get the AuthToken everything is setup correct. 





### **12. Resolve Composer Errors** ###
  Note, If running composer results in errors. Try the following

  1. First,  delete the vendor folder and composer.lock file then run the install command again. 

  2. If it requires nova credentials use -  m@mail.com / password

  3. If the prior composer install returned an error about Maatwebsite\Excel:
         docker-compose exec app composer require maatwebsite/excel






### **13. Contribution guidelines** ###
  TODO



