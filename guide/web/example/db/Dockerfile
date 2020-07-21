FROM mysql:5.7

ENV MYSQL_DATABASE=sqli_db \
    MYSQL_ROOT_PASSWORD=hmif \
    MYSQL_USER=hmif \
	MYSQL_PASSWORD=hmif

ADD sqli_db.sql /docker-entrypoint-initdb.d

EXPOSE 3306