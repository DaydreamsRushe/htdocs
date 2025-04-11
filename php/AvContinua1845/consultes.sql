/* Yo nombré a esa base de datos como ejercicioprofe */
USE ejercicioprofe; 

/* Ejercicio 2:*/

/* Necesitamos juntar la tabla de plantas (contiene el nombre popular) y la de dosi_adob (contiene los adobos enlazados con los nombres cientificos mas las cantidades) y las unimos por el nombre cientifico de las plantas, presentes en ambas tablas. Para aislar los abonos con las firmas PRISADOB, pongo en la seccion WHERE una consulta de la tabla abonos donde solo muestre los de esta firma y solo tener en cuenta los abonos que aparezcan en esta. */ 
SELECT DISTINCT nom_popular, nom_adob, quantitat_adob+10 
FROM plantes a JOIN dosi_adobs b 
ON a.nom_cientific=b.nom_planta
WHERE b.nom_adob IN (SELECT nom FROM adobs WHERE nom_firma='PRISADOB')
OR b.quantitat_adob <= 30;
/* Obtenemos 9  resultados */

/* Ejercicio 3: */

/* Para encontrar las las plantas que tienen abonos de accion inmediata, realizamos el mismo join de el ejercicio anterior pero esta vez limitaremos los abonos a los que tengan accion inmediata. Ademas necesitamos sacar las flores que florecen en primavera asi que añadimos una condicion con un AND. Como no queremos repeticiones, le ponemos un DISTINCT para que solo encuentre los nombres populares distintos una vez cada uno */
SELECT DISTINCT nom_popular
FROM plantes a JOIN dosi_adobs b 
ON a.nom_cientific=b.nom_planta
WHERE b.nom_adob IN (SELECT nom FROM adobs WHERE accio = "AI")
AND a.floracio = "Primavera"; 
/* Obtenemos 4 resultados */

/* Ejercicio 4 */

/* En este caso, queremos descartar las plantas que utilicen el adobo "Casadob", aunque tambien utilicen otros adobos. Por eso descartaremos todos los nombres de las plantas que esten enlazadas con este adobo en la tabla de dosi_adob*/
SELECT re.nom_planta, re.metode_reproduccio
FROM reproduccions re JOIN dosi_adobs da 
ON re.nom_planta=da.nom_planta 
WHERE re.nom_planta NOT IN (SELECT nom_planta FROM dosi_adobs WHERE nom_adob = "Casadob");
/* Obtenemos 0 resultados, debido a que todas las plantas registradas usan el abono Casadob */


/* Ejercicio 5 */

/* Sacamos las estaciones de floracion de las plantas cuyo nombre cientifico aparezca en el registro de ejemplares */
SELECT DISTINCT p.floracio
FROM plantes p
WHERE p.nom_cientific IN (SELECT DISTINCT e.nom_planta FROM exemplar_planta e);
/* Obtenim 4 resultats, un d'ells es NULL */

/* Ejercicio 6 */

/* La funcion LEFT nos deja escojer un numero de caracteres de la palabra empezando por la izquierda de esta */
SELECT p.nom_popular, re.metode_reproduccio, LEFT(re.grau_exit, 1)
FROM plantes p JOIN reproduccions re
ON p.nom_cientific=re.nom_planta
WHERE re.grau_exit != "Alt";
/* Obtenim 11 resultats */

/* Ejercicio 7 */

/* Si unimos las tablas por nombres Y por la estacion, obtendremos una tabla con las plantas que se han abonado en su estacion de floracion */
SELECT DISTINCT p.nom_cientific
FROM plantes p JOIN dosi_adobs da
ON p.nom_cientific=da.nom_planta AND p.floracio=da.nom_estacio;
/* Obtenim 5 resultats */
 

/* Ejercicio 8 */
/* Este se trata de la union de dos consultas distintas pero con las mismas columnas.  Se mezclan las plantas exteriores abonadas con la firma CRISADOB y las plantas de interior reproducidas por el metodo de Capficats  */
SELECT LCASE(a.nom_planta) 
FROM dosi_adobs a JOIN planta_exterior b
ON (a.nom_planta=b.nom_planta)
WHERE a.nom_adob IN (SELECT nom FROM adobs WHERE nom_firma='CIRSADOB')
UNION
SELECT LCASE(c.nom_planta)
FROM reproduccions c JOIN planta_interior d
ON c.nom_planta=d.nom_planta
WHERE c.metode_reproduccio='Capficats';
/* Obtenim 5 resultats */


/* Ejercicio 9 */
/* en esta consulta necesitamos unir tres tablas, siendo estas plantes (contiene el nombre popular), dosi_adobs (contiene la relacion de abonos con cada planta) y adobs (contiene el tipo de accion de los abonos) */
SELECT DISTINCT UCASE(nom_popular) 
FROM plantes a JOIN dosi_adobs c JOIN adobs d 
ON a.nom_cientific=c.nom_planta AND c.nom_adob=d.nom
WHERE a.nom_cientific in (SELECT DISTINCT nom_planta FROM exemplar_planta)
AND d.accio='AI';
/* Obtenim 8 resultats */

/* Ejercicio 10 */
SELECT LCASE(p.nom_popular) 
FROM dosi_adobs a JOIN planta_exterior b JOIN plantes p
ON a.nom_planta=b.nom_planta AND a.nom_planta=p.nom_cientific
WHERE a.nom_adob IN (SELECT nom FROM adobs WHERE nom_firma='CIRSADOB')
UNION
SELECT LCASE(p.nom_popular)
FROM reproduccions c JOIN planta_interior d JOIN plantes p
ON c.nom_planta=d.nom_planta AND p.nom_cientific=c.nom_planta
WHERE c.metode_reproduccio='Capficats';
/* Obtenim 5 resultats, els mateixos que en excercici 8 pero amb nom popular */