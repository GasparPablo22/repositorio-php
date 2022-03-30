<?php

require_once 'controllers/error.php';

class App{


    function __construct(){
        //echo "<p>Nueva app</p>";

        $url = isset($_GET['url']) ? $_GET['url']: null;//obtenemos el controlador de la url
        $url = rtrim($url, '/'); //eliminar signos sobrantes
        $url = explode('/', $url); //dividir parametros por diagonal

        //var_dump($url); divido arreglo

        //si no ingresa un controlador en la url se muestra main
        if (empty($url[0])) {
            $archivoController = 'controllers/main.php';
            require_once $archivoController;
            $controller = new Main();
            $controller->loadModel('main');
            $controller->render();
            //$controller->loadModel($url[0]);
            return false;
        }

        //ingresa un controlador en la url e identifica cual es
        $archivoController = 'controllers/' . $url[0] . '.php'; //se asigna la url de la posiscion 0 a la ruta del controlador

        if(file_exists($archivoController)){
            require_once $archivoController;

            //inicializar el controlador 
            $controller = new $url[0]; //mando a llamar al controlador
            $controller->loadModel($url[0]);

            $nparam = sizeof($url);//obtenemos el numero de elementos de url

            if($nparam > 1){
                if($nparam > 2){
                    $param = [];
                    for($i = 2; $i<$nparam; $i++){
                        array_push($param, $url[$i]);
                    }

                    $controller->{$url[1]}($param);//llamo metodo y parametros
                }else{
                    $controller->{$url[1]}();//llamo al metodo sin parametros
                }
            }else{
                $controller->render();
            }

            //si hay un metodo que se requiere cargar
            /*
            if(isset($url[1])){ //mando a llamar al metodo si existe
                $controller->{$url[1]}();//posicion 1 de la url
            }else{
                $controller->render();
            }
            */
        }else{
            $controller = new Eror();
        }
        
    }
}

?>