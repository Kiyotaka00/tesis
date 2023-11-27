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
    }

    $controller = new DocenteController();

    $action = $_GET['action'];

    if(isset($action)) {


        switch($action) {

            case 'obtenerCurso':  $controller->obtenercursos($mysqli);
                                break;
            case 'obtenerAlumno': $controller->obtenerAlumnos($mysqli, $_GET['curso']);
                                break;
        }
    }
?>