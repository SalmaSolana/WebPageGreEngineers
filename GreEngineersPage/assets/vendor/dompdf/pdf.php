<?php           
 	mysql_connect('localhost','root','11');
	mysql_select_db('transporte');
	require_once("dompdf_config.inc.php");

    
    $fracc=$_GET['fracc'];
	$consulta=mysql_query("Select * from ruta where Fraccionamiento='$fracc'");

    $codigo='
    <html>
    	<body>
    		<style type="text/css">
    		#thead{
    			color:white;
    			background-color:#434343;
    			font-size: 18px;
    		}
    		</style>
    		<div align="center" id="cabezera"><img src="imagenes/logo.jpg" width="20%" height="20%" /></div>
    		<h2 align="center"><font color="#434343">Rutas que pasan por </font>'.$fracc.'</h2>
          <table border="3" bordercolor="black" cellspacing="0" id="tabla" width="100%">
      		<thead id="thead">
      			<tr> <td>Ruta</td>  <td>Origen</td>  <td>Destino</td>  <td>Fraccionamiento</td>  <td>Calle</td> <td>Ida/Regreso</td>  <td>Tpo. de Esp.</td> <td>Lugar</td></tr>
      		</thead>';
			
			while($resul=mysql_fetch_assoc($consulta)){  
					$codigo= $codigo. '<tr><td bgcolor="#00BFFF">'.$resul['Ruta'].'</td><td>'.$resul['Origen'].'</td>
					<td>'.$resul['Destino'].'</td><td>'.$resul['Fraccionamiento'].'</td><td bgcolor="#00BFFF">'.$resul['Calle'].'</td>
					<td>'.$resul['Ida_Regreso'].'</td><td>'.$resul['Tiempo_Espera'].'</td><td>'.$resul['Referencia'].'</td></tr>';
			}	 	
    		$codigo= $codigo. '</table></br><h4 align="center">Para mas informacion visita: www.rutags.com</h4> </body> </html>';
    	

	$codigo=utf8_decode($codigo);
	$dompdf=new DOMPDF();
	$dompdf->load_html($codigo);
	ini_set("memory_limit","50M");
	$dompdf->render();
	$dompdf->stream("rutags.pdf");
?>
