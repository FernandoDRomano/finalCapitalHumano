# Instalación del Sistema

## Requesitos para Instalar el Sistema

- Descargar laragon https://laragon.org/download/ , este programa tiene todo lo necesario para ejecutar proyectos con Laravel.
Posee una base de datos MYSQL, una terminal, Servidor Web, etc. 

**Nota 1:** pueden descargar la versión lite **Laragon Lite** o la full **Laragon Full**, no descarguen la versión portable porque viene con 
una versión de Php vieja.

- Si no quieren descargar *laragon* o es muy pesado para sus maquinas, pueden instalar:
    - XAMPP https://www.apachefriends.org/index.html (trae apache, mysql, php, etc)
    - WampServer http://www.wampserver.com/ (es similar a XAMPP)
    - O simplemente mysql y usar el servidor propio de laravel

**Nota 2:** Fijense si es que no lo tienen instalado ya a alguno de estos programas, talvez ya los tienen y no hace falta que los esten instalando
de nuevo

## Pasos para Instalar

1. Clonen o descarguen el proyecto 

2. Una vez descargado el proyecto, ubiquense dentro de la carpeta del mismo y abran una terminal adentro. (o abran una terminal
y muévanse hasta dentro de la carpeta del proyecto)

3. En la terminal ejecuten el siguiente comando
```
composer install
```
Nota: Esto puede tardar unos minutos, dependiendo de la velocidad de su internet. Descargara todas las dependecias que necesita
el proyecto

4. Luego de que termine el comando anterior, ejecutar el siguiente comando en la terminal
```
cp .env.example .env
```

5. Luego ejecutar
```
php artisan key:generate
```

6. Una vez ejecutado todos los comandos anteriores, dentro de la carpeta del proyecto busquen el archivo **.env** que se encuentra localizado en la raiz
del mismo. Abran el archivo con un editor de texto (notepad++ o cualquiera) y deben modificar las siguientes lineas. 

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=capitalhumano
DB_USERNAME=root
DB_PASSWORD=
```
Nota: 
- DB_DATABASE es el nombre de la base de datos que van a crear en Mysql
- DB_USERNAME es el nombre del usuario del motor de bases de datos, por lo general si no crearon alguno es root
- DB_PASSWORD tienen que poner la contraseña del usuario del motor de base de datos, si no crearon usuario no tienen contraseña y deben dejarlo asi como esta.

7. Creen una base de datos en mysql con el nombre de **capitalhumano**, o con el nombre que configuraron en **DB_DATABASE=** en el archivo .env

8. Vuelvan a la terminal que tenian abierta dentro del proyecto y ejecuten el siguiente comando
```
php artisan migrate:fresh
```
Nota: con este comando se crearan todas las tablas en la base de datos mysql

9. LLegado esta instancia y si no tuvierón problemas ya estan listos para usar el sistema

9a. Pueden ejecutar con la terminal que tenian abierta en la carpeta del proyecto el siguiente comando
```
php artisan serve
```
Nota: esto creara un servidor web propio de laravel, y podran usar el sistema entrando en el navegador a **http://127.0.0.1:8000**, pero no 
deben cerrar la terminal porque sino no les va a andar

9b. Si descargaron XAMPP o WAMPSERVER deben colocar el proyecto dentro de la carpeta de su servidor web, revisen la documentación del programa
y luego entrar con el navegador


10. Si tienen dudas pueden entrar a https://styde.net/como-instalar-proyectos-existentes-de-laravel/ explica casi lo mismo que les explique yo.


