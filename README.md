ESQUIROLES 0.1

(c) SoydelBierzo

http://www.soydelbierzo.com/codigo-fuente/

Este software se libera bajo la licencia GNU/GPL
http://www.gnu.org/licenses/gpl.html

ESQUIROLES permite dar de alta puntos en un mapa y visualizarlos. Se desarrolló para crear un listado de empresas y comercios que hicieron huelga el 14 de Noviembre de 2012 en España.

Puedes verlo en funcionamiento en http://esquiroles.soydelbierzo.com/

Esta aplicación está en pañales, falta montar un panel de administración y otras muchas opciones que iré haciendo con el tiempo.

Sólo está disponible la parte de visualización, alta y contacto.

Para montar tu propia web con este código debes seguir estos pasos tras descargarte el código:

1.- En la carpeta sql está el volcado sql que debes cargar en la base de datos MySQL de tu servidor.

2.- En la carpeta includes está config.inc.php donde puedes configurar los datos de acceso a la base de datos

3.- Accede a tu base de datos, en la tabla repositories ya ha un registro, puedes modificarlo según tus necesidades, es importante que rellenes bien los campos repository, domain, domainshort y mapkey.

Mapkey es la clave API de Google para poder usar Google Maps, puedes conseguir la tuya en https://code.google.com/apis/console

4.- En la carpeta smarty hay otra que se llama plantillas, renómbrala para que se llame igual que el valor que has puesto en el campo repository de la tabla repositories, así es como el código va a encontrar el código fuente html para mostrar las páginas, es importante que la carpeta templates_c tenga permisos de escritura para que Smarty pueda cachear ahí el código de las páginas.

5.- Dentro de la carpeta includes, edita el archivo common.php y en los includes iniciales indícale la ruta al archivo Smarty.class.php, si no lo tiene instalado tu servidor, te lo puedes descargar de http://www.smarty.net/ y ponerlo donde te parezca, pero recuerda enlazarlo correctamente.

6.- En la carpeta imagenes están el logo de la cabecera, fondo, y la carpeta con los iconos que se muestran en el mapa y que te pueden servir de inspiración para hacer los tuyos propios.

Para mostrarlos en el mapa edita el archivo common.js en la carpeta js, encontrarás un par de líneas de este tipo:

gicons[1] = new GIcon(baseIcon, "http://esquiroles.soydelbierzo.com/imagenes/iconos/esquirol.png", null, "http://esquiroles.soydelbierzo.com/imagenes/iconos/sombra.png");

Pon ahí tu URL y añade todos los iconos que quieras en este array.

Para que puedan aparecer en el mapa, debes añadir también como opción que se seleccionen en el formulario de alta, archivo services_login.tpl en la carpeta smarty/plantillas/templates (en el desplegable que en el ejemplo solo aparecen Esquirol o Solidario).

7.- Edita el resto de plantillas, especialmente index.tpl para llamar a tus scripts y css correctamente, puedes cambiar el diseño de la web completamente con esta plantilla.

8.- Edita el archivo .htaccess para adaptarlo a tu dominio. 

Y listo, la gente puede empezar a dar de alta puntos en tu mapa, por defecto los puntos no aparecerán, debes aprobarlos previamente (será más cómodo cuando esté el panel de control del administrador).

Por ahora puedes hacerlo yendo directamente a la base de datos y en la tabla items, poner a 1 el campo active de los registros que quieras que se vean en tu mapa.

---------------------------------------------------------------

Disclaimer: Soy sysadmin, no desarrollador, no seáis demasiado críticos con este código que lo monté en un par de días para la web del ejemplo ;-)
