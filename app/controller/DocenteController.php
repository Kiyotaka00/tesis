<?php

    include '../model/DocenteModel.php';
    require('../conexion.php');

    class DocenteController 
    {
        public function obtenercursos($mysqli) 
        {
            session_start();

            $docente = new DocenteModel();

            $resu = $docente->obtenerCursos($mysqli, $_SESSION['codigo']);

            return $resu;
            exit();
        }

        public function obtenerAlumnos($mysqli, $curso) 
        {
            $docente = new DocenteModel();

            $resu = $docente->obtenerAlumnos($mysqli, $curso);

            if($resu != null) {
                echo json_encode($resu);
            } else {
                echo null;
            }
            exit();
        }

        public function registrarAsistencia($mysqli, $json)
        {
            $docente = new DocenteModel();
            
            $validacion = $docente->registrarAsistencia($mysqli, $json);

            if($validacion) {
                echo "registrado";
            }
            else {
                echo 'incorrecto';
            }
        }
    }

    $controller = new DocenteController();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $datos_json = file_get_contents("php://input");

        $array = json_decode($datos_json, true);
        $controller->registrarAsistencia($mysqli, $array);
    }

    if(isset($_GET['action'])) {
        $action = $_GET['action'];

        switch($action) {

            case 'obtenerCurso':  $controller->obtenercursos($mysqli);
                                break;
            case 'obtenerAlumno': $controller->obtenerAlumnos($mysqli, $_GET['curso']);
                                break;
        }
    }
?>