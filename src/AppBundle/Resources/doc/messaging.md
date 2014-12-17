# Messaging

## General

The application provides messaging by implementing the [RabbitMqBundle](https://github.com/videlalvaro/RabbitMqBundle).
The MessagingBundle provides an example controller for sending messages and a
consumer service for receiving messages.

## Installation

Make sure RabbitMQ server is up and running by executing the following commands.

    sudo apt-get install rabbitmq-server
    
Enable the Management Plugin if you like a browser-based UI for management and
monitoring of RabbitMQ. After installation the Management console should be
available at http://localhost:15672/.
    
    sudo /usr/lib/rabbitmq/lib/rabbitmq_server-3.2.4/sbin/rabbitmq-plugins enable rabbitmq_management
    sudo service rabbitmq-server restart
    
To ensure all the consumers in the application are constantly running, add the
following command to your cron. In case the consumer has died or was not
started yet, it will be started. Otherwise nothing will happen.

     * * * * * cd <project_webroot> && ./rabbitmq
     