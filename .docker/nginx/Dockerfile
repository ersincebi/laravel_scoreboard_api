FROM nginx:stable-alpine

RUN apk update && apk add bash nano

RUN rm /etc/nginx/conf.d/default.conf
COPY ./nginx.conf /etc/nginx/conf.d