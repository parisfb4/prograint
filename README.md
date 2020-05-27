# Nombre del proyecto
	Sistema Administrativo del Complejo Deportivo Universitario
# Descripcion del Proyecto
	El objetivo de este proyecto es administrar los recursos del complejo deportivo que se encuentra en el parque tecnologico al lado del CUCEI llevando las altas y bajas de los usuarios y asignando horarios a las disciplinas y cursos.
# Integrantes
	Paris Flores
# Instrucciones de instalación
-En la terminal donde se encuentra el proyecto ingresar los siguientes comandos:

	*  composer install
	*  npm install
	*  php artisan key:generate
	*  rm public/storage
	*  php artisan storage:link
	*  crear una base de datos con el nombre de "cdu-sys" and y ejecutar el archivo cdu-sys.sql para llenar la estructura de la base de datos
	*  En el archivo .env   (cambiar el usuario y contraseña de la base de datos)
	*  php artisan serve
	*  ir a localhost en el puerto que se muestre en su terminal
	
