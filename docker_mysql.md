# Docker PHP + MySQL + phpMyAdmin
&nbsp;
### *Criar uma rede para o container:*
```
docker network create rede-myadmin
```
&nbsp;
### *Instalar o MySql no Docker*  
###  1. Baixar a imagem do MySql (ou pode seguir para o passo 2):
```
docker pull mysql:latest
```
Disponível em: [https://hub.docker.com/_/mysql](https://hub.docker.com/_/mysql)
### 2. Crie um arquivo chamado mysql.Dockerfile para configurar a imagem do MySql:
````
FROM mysql:latest

ENV MYSQL_USER=nome_usuario
ENV MYSQL_PASSWORD=admin
ENV MYSQL_ROOT_PASSWORD=admin

EXPOSE 3306
````
### 3. Criar a imagem do MySql feito no mysql.Dockerfile:
````
docker build -t mysql-img:1.0 -f nome_pasta/mysql.dockerfile .
````
### 4. Criar um container MySql:
````
docker run -d -p 3307:3306 --name mysql-c -v "$PWD"/nome_pasta:/var/lib/mysql -h db --network rede-myadmin mysql-img:1.0
````

