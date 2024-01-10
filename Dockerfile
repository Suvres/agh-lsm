FROM alpine:3.18.4
RUN apk add curl php php-xml php-curl bash php-common php-pgsql php-iconv php-mbstring php81-ctype
RUN apk add php-session
RUN apk add php-dom
RUN apk add php-tokenizer
RUN apk add php-pdo
RUN apk add php-pgsql
RUN apk add postgresql
RUN apk add php-pdo_pgsql
RUN apk add php-simplexml
COPY . /app
COPY ./php.ini /etc/php81
WORKDIR /app
RUN bash ./setup.alpine.sh
RUN apk add symfony-cli
CMD symfony server:start --no-tls

