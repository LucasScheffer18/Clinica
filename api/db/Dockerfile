FROM mysql:5.7

ENV MYSQL_ROOT_PASSWORD=clinicadb
ENV MYSQL_DATABASE=clinica

COPY ./clinica.sql /docker-entrypoint-initdb.d/
