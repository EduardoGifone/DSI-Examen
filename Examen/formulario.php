<?php
    // // Obtener los elementos que estan en $Bcodes pero no en $Acodes 
    // function diferencia_Listas_de_B_peroNoEn_A($Aalumnos, $Balumnos){
    //     $ListaDif = [];
    //     //recorrer a cada elemento de $Bcodes
    //     for($i = 0; $i < count($Balumnos); $i++){
    //         //determinar si el elemento no esta en $Acodes
    //         $flag = false;
    //         for($j = 0; $j < count($Aalumnos); $j++){
    //             if ($Balumnos[$i]->codigo == $Aalumnos[$j]->codigo)
    //             {
    //                 $flag = true;
    //             }
    //         }
    //         if (!$flag){
    //             array_push($ListaDif,$Balumnos[$i]);
    //         }
    //     }
    //     return $ListaDif; 
    // }

    // // llamar a la funcion obtenerInformacion para recibir codigos y nombres
    // $ar1_alumnos = obtenerInformacion('archivo1');
    // $ar2_alumnos = obtenerInformacion('archivo2');

    // //Obtener listas de alumos necesarias
    // $alumnos_noTutorados_2022I = diferencia_Listas_de_B_peroNoEn_A($ar2_alumnos, $ar1_alumnos);
    // $alumnos_nuevos = diferencia_Listas_de_B_peroNoEn_A($ar1_alumnos, $ar2_alumnos);

    // ====================================== VARIABLES GLOBALES ======================================
    $alumnos_no_tutoria = array();
    $alumnos_antiguos = array();
    $alumnos_disponibles = array();

    // ====================================== CLASES ======================================
    // CLASE: Alumno
    class alumno {
        public $codigo;
        public $nombre;

        public function __construct($codigo, $nombre){
            $this->codigo = $codigo;
            $this->nombre = $nombre;
        }
    }

    class tutoria {
        public $docente;
        public $alumnos;

        public function __construct($docente, $alumnos) {
            $this->docente = $docente;
            $this->alumnos = $alumnos;
        }

        public function nro_alumnos(){
            return count($this->alumnos);
        }
    }

    // ====================================== FUNCIONES ======================================
    
    // Obtener arreglo de alumnos 2022_1
    function alumnos_2022_1($file){
        //obtener el archivo pedido en index.php
        $archivo = $_FILES[$file]['tmp_name'];
        $fh = fopen($archivo, 'r');
        //almacenar los codigos y nombres del archivo $file
        $array_alumnos = [];
        $i = 1;
        while(list($number, $code, $names) = fgetcsv($fh, 1024, ',')){
            if ($i > 1) {
                $alumno = new alumno($code,$names);
                array_push($array_alumnos,$alumno);
            }            
            $i++;
        }
        return $array_alumnos; 
    }

    // Obtener arreglo de alumnos 2022_1
    function docentes($file){
        //obtener el archivo pedido en index.php
        $archivo = $_FILES[$file]['tmp_name'];
        $fh = fopen($archivo, 'r');
        //almacenar los codigos y nombres del archivo $file
        $array_docentes = [];
        $i = 1;
        while(list($number, $names, $category) = fgetcsv($fh, 1024, ',')){
            if ($i > 1) {
                array_push($array_docentes,$names);
            }            
            $i++;
        }
        return $array_docentes; 
    }

    // Obtener arreglo de alumnos
    function alumnos_nuevos($alumnos_2022_1){
        global $alumnos_antiguos;
        $alumnos_nuevos = [];
        for ($i = 0; $i < count($alumnos_2022_1);$i++){
            $flag = false;
            for ($j = 0; $j < count($alumnos_antiguos);$j++){
                if ($alumnos_2022_1[$i]->codigo == $alumnos_antiguos[$j]->codigo){
                    $flag = true;
                }
            }
            if (!$flag){
                array_push($alumnos_nuevos,$alumnos_2022_1[$i]);
            }            
        }
        return $alumnos_nuevos;
    }

    // buscar substring en string
    function substring($cadena, $word) {
        if (strpos($cadena, $word) === false){
            return false;
        }
        else {
            return true;
        }
    }

    // Buscar alumno en alumnos 2022-1
    function buscar($code, $alumnos_2022_1) {
        for ($i = 0; $i < count($alumnos_2022_1); $i++) {
            if ($code == $alumnos_2022_1[$i]->codigo) {
                return true;
            }
        }
        return false;
    }

    // Obtener arreglo de tutorias
    function tutorias($file,$alumnos_2022_1){
        //obtener el archivo pedido en index.php
        $archivo = $_FILES[$file]['tmp_name'];
        $fh = fopen($archivo, 'r');
        //almacenar los codigos y nombres del archivo $file
        global $alumnos_no_tutoria;
        global $alumnos_antiguos;
        $array_tutorias = [];
        $alumnos = [];
        $docente = "";
        $k = 1;
        while(list($code, $names) = fgetcsv($fh, 1024, ',')){
            if ($k > 6 && $k != 8) {
                if (substring($code,'Docente'))
                {
                    $alumnos_antiguos = array_merge($alumnos_antiguos, $alumnos);
                    $tutoria = new tutoria($docente, $alumnos);
                    array_push($array_tutorias,$tutoria);
                    $alumnos = [];
                    $docente = $names;
                }
                else {
                    if ($code != '') {
                        if (buscar($code,$alumnos_2022_1)) {
                            $alumno = new alumno($code,$names);
                            array_push($alumnos,$alumno);
                        }
                        else {
                            $alumno = new alumno($code,$names);
                            array_push($alumnos_no_tutoria,$alumno);                            
                        }                        
                    }                
                }
            }
            $k++;
        }

        $alumnos_antiguos = array_merge($alumnos_antiguos, $alumnos);
        $tutoria = new tutoria($docente, $alumnos);
        array_push($array_tutorias,$tutoria);

        return array_slice($array_tutorias, 1); 
    }

    // Elimiar tutores que ya no esten en servicio
    function delete_docente($tutorias, $docentes){
        global $alumnos_disponibles;
        $nuevas_tutorias = array();
        for ($i = 0; $i < count($tutorias); $i++) {
            if (in_array($tutorias[$i]->docente, $docentes)){
                array_push($nuevas_tutorias,$tutorias[$i]);
            }
            else {
                array_merge($alumnos_disponibles,$tutorias[$i]->alumnos);
            }
        }
        return $nuevas_tutorias;
    }

    //Mostrar datos de alumnos
    function mostrar($alumno) {
        for ($i = 0; $i < count($alumno); $i++)
            {
                echo $alumno[$i]->codigo.' - '.$alumno[$i]->nombre.'<br>';
            }
    }

    // mostrar distribucion
    function mostrar_dis($tutorias) {
        for ($i = 0; $i < count($tutorias); $i++){
            echo '<div class="tabla">';
            echo '<div class="tabla__head">';
            echo '<p class="tabla__head__p">'.$tutorias[$i]->docente.'</p>';
            echo '</div>';
            echo '<div class="tabla__body">';
            for ($j = 0; $j < count($tutorias[$i]->alumnos);$j++){
                echo '<p class="tabla__body__p">'.$tutorias[$i]->alumnos[$j]->codigo.'</p>';
                echo '<p class="tabla__body__p">'.$tutorias[$i]->alumnos[$j]->nombre.'</p>';
            }
            echo '</div>';
            echo '</div>';
        }
    }           

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    $alumnos_2022_1 = alumnos_2022_1('archivo2');
    $docentes = docentes('archivo3');
    $tutorias = tutorias('archivo1',$alumnos_2022_1);
    //$tutorias = delete_docente($tutorias, $docentes);  
    $alumnos_nuevos = alumnos_nuevos($alumnos_2022_1);
    $alumnos_disponibles = array_merge($alumnos_disponibles,$alumnos_nuevos);

    // echo('<pre>');
    // var_dump($docentes);
    // echo '<br><br>';
    // mostrar($alumnos_nuevos);
    // echo '<br><br>';
    // mostrar($alumnos_antiguos);
    // echo '<br><br>';
    // mostrar($alumnos_no_tutoria);
    // echo '<br><br>';
    // mostrar($alumnos_disponibles);
    // echo '<br><br>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="formulario.css">
    <title>FORMULARIO</title>
</head>
<body>
    <nav class="nav">
            <div class="nav__img nav__img--unsaac"></div>
            <div class="nav__text">
                <h2 class="nav__text__h1">UNIVERSIDAD NACIONAL DE SAN ANTONIO ABAD DEL CUSCO</h2><br>
                <h2 class="nav__text__h1">ESCUELA PROFESIONAL DE INGENIERIA INFORMATICA Y DE SISTEMAS</h2>
            </div>
            <div class="nav__img nav__img--info"></div>
    </nav>
    <div class="container">

        <div class="titulo">
            <h1 class="titulo__h1">Distribucion de tutorias semestre 2022-1</h1>
        </div>

        <div class="tabla_datos"> 
            <?php
                mostrar_dis($tutorias);   
            ?>
            
        </div>
    </div>    
</body>
</html>