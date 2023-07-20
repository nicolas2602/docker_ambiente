# Docker PHP + MySQL + phpMyAdmin (Dockerfile)
&nbsp;
### *Criar uma rede para os containers:*
```
docker network create rede-myadmin
```
&nbsp;
### *Instalar o MySql no Docker*  
### 1. Crie um arquivo chamado mysql.Dockerfile para configurar a imagem do MySQL:
````
FROM mysql:latest

ENV MYSQL_USER=nome_usuario
ENV MYSQL_PASSWORD=admin
ENV MYSQL_ROOT_PASSWORD=admin

EXPOSE 3306
````
### 2. Criar a imagem do MySQL feito no mysql.dockerfile:
````
docker build -t mysql-img:1.0 -f docker_container/mysql.dockerfile .
````
### 3. Criar um container MySQL:
````
docker run -d -p 3307:3306 --name mysql-c -v "$PWD"/docker_container/mysql:/var/lib/mysql -h db --network rede-myadmin mysql-img:1.0
````
### 4. Abra o container MySQL:
````
docker exec -it mysql-c bash
````
- Para conceder a permissão de arquivos e pastas (opcional):
  ````
  chmod -R 777 .
  ````

**_ou_**

- Para acessar o MySQL no container, coloque:
  ````
  mysql -u root -p
  ````

  e depois digite a senha do root _(definido no container, “MYSQL_ROOT_PASSWORD”)_.

&nbsp;

- Após digitar a senha, coloque o comando:
  ````
  show databases;
  ````

  para exibir os bancos de dados disponíveis. 

&nbsp;

- Para criar um banco de dados, coloque:
  ````
  create database nome_bd;
  ````

&nbsp;

- Criado o banco de dados, utilize o comando:
  ````
  use nome_bd;
  ````

  para acessar o banco de dados.

&nbsp;

- Dentro do banco criado, exiba as tabela disponíveis:
  ````
  show tables;
  ````

&nbsp;

- Caso não tenha, crie uma tabela:
  ````
   CREATE TABLE pessoa(
      IdPessoa int primary key AUTO_INCREMENT,
      nomePessoa varchar(100) NOT NULL,
      idadePessoa int NOT NULL,
      dataNascimento date
   );
  ````

&nbsp;

- E para inserir os dados na tabela:
  ````
  INSERT INTO pessoa (nomePessoa, idadePessoa, dataNascimento) VALUES ('Nicolas', 20, '2002-12-26'), ('Eduardo', 32, '1991-12-26');
  ````

&nbsp;

- Com os dados inseridos, digite:
  ````
  select * from pessoa;
  ````
  para exibir os dados da tabela.

&nbsp;

Feito isso basta dar um ````exit```` para sair do MySQL e depois ````exit```` novamente, para sair do container MySQL.

&nbsp;

### *Instalar o phpMyAdmin no Docker*
### 1. Crie um arquivo chamado phpmyadmin.dockerfile:
````
FROM phpmyadmin:latest

ENV PMA_HOST=db 

EXPOSE 80
````
### 2. Criar a imagem do phpMyAdmin feito no phpmyadmin.dockerfile:
````
docker build -t myadmin-img:1.0 -f docker_container/phpmyadmin.dockerfile .
````
### 3. Criar um container phpMyAdmin:
````
docker run -d --name myadmin-c -p 8080:80 -h myadmin --network rede-myadmin myadmin-img:1.0
````
&nbsp;
### *Instalar o PHP no Docker*
### 1. Crie um arquivo chamado php.dockerfile
````
FROM php:8.1.18-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apachectl restart 

EXPOSE 80
````
### 2. Crie um arquivo chamado php.dockerfile
````
docker build -t php-img:1.0 -f docker_container/php.dockerfile .
````
### 3. Criar um container PHP:
````
docker run -p 80:80 -d --name php-c -v "$PWD"/docker_container/php:/var/www/html --network rede-myadmin --link mysql-c:db_mysql php-img:1.0
````
### 4. Abra o container PHP:
````
docker exec -it php-c bash
````
Para conceder a permissão de arquivos e pastas:
````
chmod -R 777 .
````
Feito isso, basta dar um ````exit```` para sair do container PHP.
