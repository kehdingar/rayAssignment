FROM httpd:latest

COPY apache.conf /usr/local/apache2/conf/apache.conf

RUN echo "Include /usr/local/apache2/conf/apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf

EXPOSE 9000