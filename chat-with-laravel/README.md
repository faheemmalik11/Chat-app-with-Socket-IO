# Chat With Laravel
* [Introduction](#introduction)
* [Features](#features)
* [Prerequisites](#prerequisites)
* [Usage](#usage)
* [Technologies Used](#technologies-used)
* [Clone This Project](#clone-this-project)


## Introduction
Welcome to the Laravel Redis and Socket.io Chat Room project! This application provides a real-time chat room experience where users can join different channels, send messages, see online users, and receive messages instantly using Laravel, Redis, and Socket.io.

![Chat Room Screenshot](/chat-with-laravel/public/Screenshot%20from%202023-08-09%2013-11-19.png)

## Features

Features
* Join different chat channels.
* Send and receive real-time messages within a chat channel.
* See a list of online users in the chat channel.
* Display the sender's name with each message.
* Seamless integration of Laravel, Redis, and Socket.io for real-time communication.

## Prerequisites
Before you begin, ensure you have met the following requirements:

* Laravel: Make sure you have Laravel installed. You can install it using Composer.
* Redis: Ensure that you have a Redis server up and running. You can download and set up Redis from the official Redis website.
* Node.js: You'll need Node.js installed to work with Socket.io. You can download it from the official Node.js website.

## Usage
* Open your browser and navigate to http://localhost:8000.
* Create an account or log in if you already have one.
* Browse different chat channels and join the ones you're interested in.
* Start sending and receiving real-time messages within the chat room.
* See the list of online users in each chat channel.
* Enjoy the seamless real-time communication experience!

## Technologies Used
* Laravel: A powerful PHP framework for web application development.
* Redis: An open-source, in-memory data structure store used as a database, cache, and message broker.
* Socket.io: A JavaScript library for real-time web applications, providing bi-directional communication between web clients and servers.



## Clone This Project
1. Update the composer
```sh
composer update
```
2. Set up .env
Make .env file and copy .env.example to .env
```sh

```
Updating env File
You need to set env file with BROADCAST_DRIVER as redis and database configuration and also database redis configuration.

BROADCAST_DRIVER=redis
  
DB_DATABASE=redis-laravel
DB_USERNAME=root
DB_PASSWORD=password
  
REDIS_HOST=localhost
REDIS_PASSWORD=null
REDIS_PORT=6379
   
LARAVEL_ECHO_PORT=6001

3. Generate Keys
```sh
php artisan key:generate
```
```sh
php artisan jwt:secret
```
4. Migration and Seeding
```sh
php artisan migrate
```
```sh
php artisan db:seed
```
5. Install npm packages
```sh
npm install
```
then:
```sh
npx mix
```

6. Final steps
You must have to install redis server in your system or server. it not then you can install using following command:
```sh
sudo apt install redis-server
```
After that you can start laravel echo server as like bellow command:
```sh
npx laravel-echo-server start
```
Now you can run project using following command:
```sh
php artisan serve
```
