<?php
    class Controller{

      function __construct(){
          //echo "<p>Controlador base</p>";
          $this->view = new View();//creo una nueva variable para que sea una nueva vista
      }
      
      function loadModel($model){
        $url = 'models/'.$model.'model.php';

        if(file_exists($url)){
          require $url;

          $modelName = $model.'Model';
          $this->model = new $modelName();
        }
      }
    }
?>