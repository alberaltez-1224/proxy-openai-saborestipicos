# Imagen base de PHP 8.2 con servidor embebido
FROM php:8.2-cli

# Copia todos los archivos del repositorio al contenedor
COPY . /app
WORKDIR /app

# Exponer el puerto
EXPOSE 10000

# Comando de inicio (igual que usaríamos en local)
CMD ["php", "-S", "0.0.0.0:10000", "proxy_openai.php"]
