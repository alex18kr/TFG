/home/alex/Escritorio/import.io/import.io -crawl /home/alex/Escritorio/EhulkuZerbitzua/crawl.json /home/alex/Escritorio/EhulkuZerbitzua/auth.json | tee /home/alex/Escritorio/EhulkuZerbitzua/resultadoEhulku.json   #ejecuta el crawler y escribe los datos


sed ':a;N;$!ba;s/\n/,/g' /home/alex/Escritorio/EhulkuZerbitzua/resultadoEhulku.json > /home/alex/Escritorio/EhulkuZerbitzua/resultadoEhulku2.json  #cambia los saltos de linea por comas

sed -i '1i [' /home/alex/Escritorio/EhulkuZerbitzua/resultadoEhulku2.json  #inserta "["en la primera linea, pero deja un salto de linea despues del [
sed -i '$a ]' /home/alex/Escritorio/EhulkuZerbitzua/resultadoEhulku2.json  #inserta "]" en la ultima linea, pero deja un salto de linea antes del ]

sed ':a;N;$!ba;s/\n//g' /home/alex/Escritorio/EhulkuZerbitzua/resultadoEhulku2.json > /home/alex/Escritorio/EhulkuZerbitzua/resultadoEhulku.json  #borra los nuevos saltos de linea y deja el resultado en el primer fichero

rm /home/alex/Escritorio/EhulkuZerbitzua/resultadoEhulku2.json #elimina el archivo 2 que ha servido para las operaciones anteriores


php /home/alex/Escritorio/EhulkuZerbitzua/ehulku.php  #ejecuta el script php que inserta los datos

