### CODE SAMPLE
- run ```docker-compose up```
- run shell file ```gen.sh```
- you can check mailhog on port ```8025```
- you can check rabbitmq on port ```15672```

notice: **admin microservice is just a dummy part to check transaction of RabbitMQ to consume queues**

to consume queues of ```client_api``` run below command:

```docker exec -it admin_consume sh -c "php artisan rabbitmq:consume"```
