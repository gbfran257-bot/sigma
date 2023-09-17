FROM gilbitron/php5.6-mysql:latest

# Instala OpenSSL
RUN apt-get update && \
    apt-get install -y openssl

# Copia el contenido del directorio actual al directorio /var/www/html en el contenedor
COPY . /var/www/html

# Expone el puerto 80 para Apache
EXPOSE 80

# Comando para iniciar Apache al iniciar el contenedor
CMD ["apache2ctl", "-D", "FOREGROUND"]
