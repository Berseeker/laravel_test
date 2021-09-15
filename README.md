# laravel_test


El cogido se encuentra en la rama Master

En el desarrollo del codigo se puede observar la separacion entre el API y el FRONTEND usando como authenticacion los bearer tokens de Sanctum.

La parte del mailing lo configure por falta de tiempo con stmp de Gmail en el archivo .env

Por default los repositorios de laravel 8 ya vienen con ambiente de trabajo en Docker.

Retomando la parte de mail esta todo el back para confirmacion de email cuando se registra alguien en la plataforma pero para cuando se da de alta una empresa que
creo era de los puntos extras

Como las empresas y empleados los consumo directo del API no puedo usar el paginador en la API asi que en el controlador del frontend se hizo un paginate custom para resolver esta disyuntiva.


Se tiene que ejecutar "npm install" para compiralos los estilos y la parte de la paginacion
