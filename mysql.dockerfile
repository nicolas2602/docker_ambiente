## Fontes:
## O que é Dockerfile: https://www.youtube.com/watch?v=5QGexrfqu60
## Docker Multi-Stage Image Build: https://www.youtube.com/watch?v=YFZvdtxf7-Y

FROM mysql:latest

ENV MYSQL_USER=nicolas
ENV MYSQL_PASSWORD=admin
ENV MYSQL_ROOT_PASSWORD=admin

EXPOSE 3306