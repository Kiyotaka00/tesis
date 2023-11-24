<?php

    include '../model/DocenteModel.php';

    class DocenteController 
    {
        public function validarLogin($mysqli)
        {
            $user = $_POST['usuario'];
            $password = $_POST['password'];

            $docente = new Docente();

            $resu = $docente->validarDocenteBd($mysqli, $user, $password);

            if(isset($resu)) {
                session_start();
                $_SESSION['docente'] = $resu;
                $_SESSION['nombre'] = $user;

                header("Location: ../view/asistencia.php");
            } else {
                header("Location: ../../index.php");
            }
            exit();
        }

        public function obtenercursos($mysqli) 
        {
            session_start();

            $docente = new Docente();

            $resu = $docente->traerCursos($mysqli, $_SESSION['docente']);

            echo json_encode($resu);

            exit();
        }

        public function obtenerAlumnos($mysqli, $curso) 
        {
            $docente = new Docente();

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

    if(isset($_POST['usuario'])) {
        $controller->validarLogin($mysqli);
    }

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