/home/alex/Escritorio/import.io/import.io -crawl /home/alex/Escritorio/EstiloLiburua/crawl.json /home/alex/Escritorio/EstiloLiburua/auth.json | tee /home/alex/Escritorio/EstiloLiburua/resultadoEstiloLiburua.json   #ejecuta el crawler y escribe los datos


sed ':a;N;$!ba;s/\n/,/g' /home/alex/Escritorio/EstiloLiburua/resultadoEstiloLiburua.json > /home/alex/Escritorio/EstiloLiburua/resultadoEstiloLiburua2.json  #cambia los saltos de línea por comas

sed -i '1i [' /home/alex/Escritorio/EstiloLiburua/resultadoEstiloLiburua2.json  #inserta "["en la primera línea, pero deja un salto de línea después del "["
sed -i '$a ]' /home/alex/Escritorio/EstiloLiburua/resultadoEstiloLiburua2.json  #inserta "]" en la última línea, pero deja un salto de linea antes del "]"

sed ':a;N;$!ba;s/\n//g' /home/alex/Escritorio/EstiloLiburua/resultadoEstiloLiburua2.json > /home/alex/Escritorio/EstiloLiburua/resultadoEstiloLiburua.json  #borra los nuevos saltos de línea y deja el resultado en el primer fichero

rm /home/alex/Escritorio/EstiloLiburua/resultadoEstiloLiburua2.json #elimina el archivo 2 que ha servido para las operaciones anteriores


php /home/alex/Escritorio/EstiloLiburua/estilo-liburua.php  #ejecuta el script php que inserta los datos

