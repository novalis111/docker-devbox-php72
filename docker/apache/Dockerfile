FROM httpd:2-alpine
RUN sed -e 's/#LoadModule proxy_module/LoadModule proxy_module/' -i /usr/local/apache2/conf/httpd.conf
RUN sed -e 's/#LoadModule proxy_fcgi_module/LoadModule proxy_fcgi_module/' -i /usr/local/apache2/conf/httpd.conf
RUN sed -e 's/#LoadModule rewrite_module/LoadModule rewrite_module/' -i /usr/local/apache2/conf/httpd.conf
RUN sed -e 's/AllowOverride None/AllowOverride All/' -i /usr/local/apache2/conf/httpd.conf
# RUN echo "ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://php:9000/app/\$1" | tee -a /usr/local/apache2/conf/httpd.conf
# See https://serverfault.com/questions/450628/apache-2-4-php-fpm-proxypassmatch
RUN echo $'\
<Proxy "fcgi://php:9000">\n\
  ProxySet timeout=600\n\
</Proxy>\n\
<FilesMatch ".+\.ph(p[3457]?|t|tml)$">\n\
  SetHandler application/x-httpd-php\n\
  SetHandler "proxy:fcgi://php:9000/"\n\
</FilesMatch>' | tee -a /usr/local/apache2/conf/httpd.conf
RUN echo $'\
# vHost /app\n\
<VirtualHost *:80>\n\
  DocumentRoot "/app"\n\
  ServerName devbox.localhost\n\
  DirectoryIndex index.html index.php\n\
  <Directory "/app">\n\
    Options Indexes FollowSymLinks ExecCGI\n\
    AllowOverride All\n\
    Require all granted\n\
  </Directory>\n\
</VirtualHost>\n' | tee -a /usr/local/apache2/conf/httpd.conf
RUN echo $'\
# vHost /app2\n\
<VirtualHost *:80>\n\
  DocumentRoot "/app2/public"\n\
  ServerName devbox2.localhost\n\
  DirectoryIndex index.html index.php\n\
  <Directory "/app2">\n\
    Options Indexes FollowSymLinks ExecCGI\n\
    AllowOverride All\n\
    Require all granted\n\
  </Directory>\n\
</VirtualHost>\n' | tee -a /usr/local/apache2/conf/httpd.conf
