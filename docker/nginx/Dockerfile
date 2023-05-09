FROM nginx:1.15.12-alpine

RUN apk update \
    && apk add --no-cache openssl \
    && apk add --no-cache curl

RUN set -xe; \
    addgroup -g 1000 -S www-data; \
    adduser  -u 1000 -D -S -G www-data www-data; \
