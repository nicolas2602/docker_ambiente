# Docker PHP + MySQL + phpMyAdmin
&nbsp;
### Passo 1: *Criar uma rede para os containers:*
```
docker network create rede-myadmin
```
&nbsp;
### Passo 2: *Instalar o MySQL no Docker*  
### 1. Baixar a imagem do MySQL:
````
docker pull mysql:latest
````
### 2. Criar e rodar o container:
````
docker run -d -p 3307:3306 --name mysql-c -v "$PWD"/docker_ambiente/mysql:/var/lib/mysql -h db --network rede-myadmin -e MYSQL_ROOT_PASSWORD=admin -e MYSQL_USER=nome_usuario -e MYSQL_PASSWORD=admin mysql:latest
````
### 3. Executar o container MySQL:
````
docker exec -it mysql-c bash
````
Para conceder a permissão (opcional):
````
chmod -R 777 .
````
**_ou_**

Para acessar o MySQL no container, coloque:
````
mysql -u root -p
````
e depois digite a senha do root _(definido no container, “MYSQL_ROOT_PASSWORD”)_.

&nbsp;

Após digitar a senha, coloque o comando:
````
show databases;
````
para exibir os bancos de dados disponíveis. 

&nbsp;

Para criar um banco de dados, coloque:
````
create database nome_bd;
````

&nbsp;

Criado o banco de dados, utilize o comando:
````
use nome_bd;
````
para acessar o banco de dados.

&nbsp;

Dentro do banco criado, exiba as tabela disponíveis:
````
show tables;
````

&nbsp;

Caso não tenha, crie uma tabela:
````
CREATE TABLE pessoa(
   IdPessoa int primary key AUTO_INCREMENT,
   nomePessoa varchar(100) NOT NULL,
   idadePessoa int NOT NULL,
   dataNascimento date
);
````

&nbsp;

E para inserir os dados na tabela:
````
INSERT INTO pessoa (nomePessoa, idadePessoa, dataNascimento) VALUES ('Nicolas', 20, '2002-12-26'), ('Eduardo', 32, '1991-12-26');
````

&nbsp;

Com os dados inseridos, digite:
````
select * from pessoa;
````
para exibir os dados da tabela.

&nbsp;

Feito isso basta dar um ````exit```` para sair do MySQL e depois ````exit```` novamente, para sair do container MySQL.

&nbsp;
### Passo 3: *Instalar o phpMyAdmin no Docker*
### 1. Baixar a imagem do phpMyAdmin:
````
docker pull phpmyadmin:latest
````
### 2. Criar e rodar o container:
````
docker run -d --name myadmin-c -p 8080:80 -h myadmin --network rede-myadmin -e PMA_HOST=db phpmyadmin:latest
````
**Obs.: A variável PMA_HOST está ligando com o servidor _db_ do container MySQL. Para verificar o nome do servidor, digite o seguinte comando:**
````
docker inspect mysql-c | grep Hostname
````
&nbsp;
### Passo 4: *Instalar o PHP no Docker*
### 1. Baixar a imagem do PHP:
````
docker pull php:8.1.18-apache
````
### 2. Criar e rodar o container PHP:
````
docker run -p 80:80 -d --name php-c -v "$PWD"/docker_ambiente/php:/var/www/html --network rede-myadmin --link mysql-c:db php:8.1.18-apache
````
### 3. Executar o container PHP para baixar bibliotecas e conceder permissões:
````
docker exec -ti php-c bash
````
1. Dentro do container PHP, baixe a biblioteca MySqli no container PHP (conceder a conexão PHP com MySQL), da seguinte forma:
  - Coloque o 1° comando a seguir:
    ````
    docker-php-ext-install mysqli
    ````
  - Após executar o 1° comando e baixar, coloque o 2° comando a seguir:
    ````
    docker-php-ext-enable mysqli
    ````
  - Após executar o 2° comando, coloque o 3° comando a seguir:
    ````
    apachectl restart
    ````
2. Depois de baixar a biblioteca, habilite a permissão para o container PHP (chmod 777):
  ````
  chmod -R 777 .
  ````
Após executar os comandos, basta digitar ````exit```` para sair do container PHP.



