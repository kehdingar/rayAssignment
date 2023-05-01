FROM node:latest

WORKDIR /app

COPY package.json /package.json

COPY . /app

RUN yarn install

RUN yarn run build

# EXPOSE 3000

ENV NODE_PATH=/node_modules
ENV PATH=$PATH:/node_modules/.bin

