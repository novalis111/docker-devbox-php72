FROM httpd:2-alpine
RUN sed -e 's/#LoadModule proxy_module/LoadModule proxy_module/' -i /usr/local/apache2/conf/httpd.conf
RUN sed -e 's/#LoadModule proxy_fcgi_module/LoadModule proxy_fcgi_module/' -i /usr/local/apache2/conf/httpd.conf
RUN sed -e 's/#LoadModule rewrite_module/LoadModule rewrite_module/' -i /usr/local/apache2/conf/httpd.conf
RUN sed -e 's/\/usr\/local\/apache2\/htdocs/\/app/' -i /usr/local/apache2/conf/httpd.conf
RUN sed -e 's/AllowOverride None/AllowOverride All/' -i /usr/local/apache2/conf/httpd.conf
# RUN echo "ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://php:9000/app/\$1" | tee -a /usr/local/apache2/conf/httpd.conf
# See https://serverfault.com/questions/450628/apache-2-4-php-fpm-proxypassmatch
RUN echo $'\
    <FilesMatch ".+\.ph(p[3457]?|t|tml)$">\n\
        SetHandler "proxy:fcgi://php:9000/"\n\
    </FilesMatch>' | tee -a /usr/local/apache2/conf/httpd.conf
RUN echo "DirectoryIndex index.html index.php" | tee -a /usr/local/apache2/conf/httpd.conf
RUN echo "ServerName devbox.localhost" | tee -a /usr/local/apache2/conf/httpd.conf
