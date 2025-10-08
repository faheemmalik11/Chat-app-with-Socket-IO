* [Installation](#insttallation)
* [Introduction](#introduction)
* [Features](#features)


## Installation
Install all the necessary dependencies for the application.
```sh
npm install express
```
```sh
npm install socket.io
```
`also to use this project after clone install these packages`

## Introduction
This project is a real-time chat room application built using Socket.io and Laravel. It allows users to join the chat room, see other online users, send messages, and reply to messages in real-time. The chat messages and user presence are broadcasted to all connected clients using Laravel broadcasting with the help of the Socket.io library.

## Features

User Authentication: Users can register and log in to participate in the chat room.
Real-Time Communication: Messages are sent and received in real-time without the need to refresh the page.
User Presence: The chat room displays a list of all online users.
Message Replies: Users can reply to messages, and replies are broadcasted to all users.