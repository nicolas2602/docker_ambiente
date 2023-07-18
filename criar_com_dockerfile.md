# Docker PHP + MySQL + phpMyAdmin (Dockerfile)
&nbsp;
### *Criar uma rede para os containers:*
```
docker network create rede-myadmin
```
&nbsp;
### *Instalar o MySql no Docker*  
### 1. Crie um arquivo chamado mysql.Dockerfile para configurar a imagem do MySql:
````
FROM mysql:latest

ENV MYSQL_USER=nome_usuario
ENV MYSQL_PASSWORD=admin
ENV MYSQL_ROOT_PASSWORD=admin

EXPOSE 3306
````
### 2. Criar a imagem do MySql feito no mysql.Dockerfile:
````
docker build -t mysql-img:1.0 -f docker_container/mysql.dockerfile .
````
### 3. Criar um container MySql:
````
docker run -d -p 3307:3306 --name mysql-c -v "$PWD"/docker_container/mysql:/var/lib/mysql -h db --network rede-myadmin mysql-img:1.0
````
&nbsp;
### *Instalar o phpMyAdmin no Docker*
### 1. Crie um arquivo chamado phpmyadmin.Dockerfile:
````
FROM phpmyadmin:latest

ENV PMA_HOST=db 

EXPOSE 80
````
### 2. Criar a imagem do phpMyAdmin feito no phpmyadmin.Dockerfile:
````
docker build -t myadmin-img:1.0 -f docker_container/phpmyadmin.dockerfile .
````
### 3. Criar um container phpMyAdmin:
````
docker run -d --name myadmin-c -p 8080:80 -h myadmin --network rede-myadmin myadmin-img:1.0
````
&nbsp;
### *Instalar o PHP no Docker*
### 1. Crie um arquivo chamado php.Dockerfile
````
FROM php:8.1.18-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apachectl restart 

EXPOSE 80
````
### 2. Crie um arquivo chamado php.Dockerfile
````
docker build -t php-img:1.0 -f docker_container/php.dockerfile .
````
### 3. Criar um container PHP:
````
docker run -p 80:80 -d --name php-c -v "$PWD"/docker_container/php:/var/www/html --network rede-myadmin --link mysql-c:db_mysql php-img:1.0
````
&nbsp;
### Habilitar permissão (chmod 777) para container PHP e MySql
Abra o container PHP:
````
docker exec -it php-c bash
````
**_ou_**

Abra o container MySql:
````
docker exec -it mysql-c bash
````
E execute o comando para od dois containers da seguinte maneira:
````
chmod -R 777 .
````
