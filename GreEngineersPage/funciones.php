<?php
class funciones{

	  function validaSesion(){
      if(!isset($_SESSION['sesion']) || !isset($_SESSION['user'])){
          return false;
          exit;
      }
      if($_SESSION['sesion'] != hash('sha256', 'sesvalida')){
          return false;
          exit;
      }
      else{
          return true;
          exit;
      }
  }


?>
