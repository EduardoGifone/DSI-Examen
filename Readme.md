# Proyecto Desarrollo de Software

## Integrantes

* Cconcho Castellanos Miguel Angel&ensp;&ensp;&ensp;&ensp;***192999***
* Chirinos Vilca Yerson Joab&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;***182731***
* Gifone Villasante Eduardo Juareis&ensp;&ensp;&ensp;&ensp;***193001***
* Maccarcco Quispe Karol Gianella&ensp;&ensp;&ensp;&nbsp;&ensp;***192424***
* Puma Huamani Glina de la Flor&ensp;&ensp;&ensp;&nbsp;&ensp;&ensp;&ensp;***191873***

## Descripcion

Para este proyecto se nos pidio desarrollar la funcionalidad que permita realizar la distribución balanceada de los estudiantes a los tutores para el presente semestre 2022-1.

## Datos de entrada
* Archivo CVS Lista de alumnos matriculados en el presente semestre.
* Archivo CVS Lista de docentes para el presente semestre.
* Archivo CVS Distribución de tutorías del anterior semestre.

## Resultados
* Archivo CSV Lista de alumnos ya no son considerados en la tutoría (Alumnos no matriculados en el presente semestre).
* Archivo CSV Distribución balanceada de tutorías para el presente semestre.

## Restricciones
* Distribución balanceada: Distribución equitativa de estudiantes a tutores y Que el docente tenga alumnos de diferentes códigos.
* Implementación de una interface para el usuario sencilla, intuitiva y práctica.
* Mantener la lista de tutorías del anterior semestre con el docente asignado.


## Funcionamiento

### Cargar datos

![Subida de archivos csv](/screenshot/ss-1.png)

Lo primero que tenemos que hacer, es subir los datos en formato csv.
* Distribucion x Docente 2021-2.csv
* Alumnos 2022-1.csv
* Docentes 2022-I.csv

Una vez subidos los archivos csv seran capturados en el programa y se llevaran a una estructura de objetos.

### Mostrar datos

Una vez enviados los archivos, se mostrara la Distribucion de alumnos x Docente.
De igual manera se podran descargar los archivos:
* AlumnosNoTutorados.csv
* DistribucionTutorados2022-I.csv

![Marcado de opcion](/screenshot/ss-2.png)

