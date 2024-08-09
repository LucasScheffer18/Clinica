FROM mysql:5.7

COPY ./usuarios.sql /docker-entrypoint-initdb.d/

ENV MYSQL_ROOT_PASSWORD=usuariosdb
ENV MYSQL_DATABASE=usuarios
