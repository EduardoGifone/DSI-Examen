<?php
    // CLASE: Alumno
    class alumno {
        public $codigo;
        public $nombre;

        public function __construct($codigo, $nombre){
            $this->codigo = $codigo;
            $this->nombre = $nombre;
        }
    }

    function obtenerInformacion($file)
    {
        //obtener el archivo pedido en index.php
        $archivo = $_FILES[$file]['tmp_name'];
        $fh = fopen($archivo, 'r');
        //almacenar los codigos y nombres del archivo $file
        $array_alumnos = [];
        $i = 0;
        while(list($code, $names) = fgetcsv($fh, 1024, ',')){
            $array_alumnos[$i] = new alumno($code,$names);
            $i++;
        }
        return $array_alumnos; 
    }

    // Obtener los elementos que estan en $Bcodes pero no en $Acodes 
    function diferencia_Listas_de_B_peroNoEn_A($Aalumnos, $Balumnos){
        $ListaDif = [];
        //recorrer a cada elemento de $Bcodes
        for($i = 0; $i < count($Balumnos); $i++){
            //determinar si el elemento no esta en $Acodes
            $flag = false;
            for($j = 0; $j < count($Aalumnos); $j++){
                if ($Balumnos[$i]->codigo == $Aalumnos[$j]->codigo)
                {
                    $flag = true;
                }
            }
            if (!$flag){
                array_push($ListaDif,$Balumnos[$i]);
            }
        }
        return $ListaDif; 
    }

    function mostrar($alumno) {
        for ($i = 0; $i < count($alumno); $i++)
            {
                echo '<p class="tabla_datos__row__p">'.$alumno[$i]->codigo.'</p>';
                echo '<p class="tabla_datos__row__p">'.$alumno[$i]->nombre.'</p>';
            }
    }

    // llamar a la funcion obtenerInformacion para recibir codigos y nombres
    $ar1_alumnos = obtenerInformacion('archivo1');
    $ar2_alumnos = obtenerInformacion('archivo2');

    //Obtener listas de alumos necesarias
    $alumnos_noTutorados_2022I = diferencia_Listas_de_B_peroNoEn_A($ar2_alumnos, $ar1_alumnos);
    $alumnos_nuevos = diferencia_Listas_de_B_peroNoEn_A($ar1_alumnos, $ar2_alumnos);
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
            <h1 class="titulo__h1">
            <?php
                if ($_REQUEST['mostrar'] == 'no_tutorados') 
                {
                    echo 'Alumnos que no seran tutorados en 2022-I';
                }
                else 
                {
                    echo 'Nuevos alumnos para tutoria';
                }                    
            ?>
            </h1>
        </div>

        <div class="tabla_datos">

            <div class="tabla_datos__row tabla_datos__row--head">
                <p class="tabla_datos__row__p">CODIGO</p>
                <p class="tabla_datos__row__p">NOMBRE</p>
            </div>

            <div class="tabla_datos__row tabla_datos__row--body">
                <?php

                    if ($_REQUEST['mostrar'] == 'no_tutorados') 
                    {
                        mostrar($alumnos_noTutorados_2022I);
                    }
                    else 
                    {
                        mostrar($alumnos_nuevos);
                    }                    
                ?>
                
            </div>
            
        </div>
    </div>    
</body>
</html>