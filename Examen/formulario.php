<?php
    function obtenerInformacion($file)
    {
        //obtener el archivo pedido en index.php
        $archivo = $_FILES[$file]['tmp_name'];
        $fh = fopen($archivo, 'r');
        //almacenar los codigos y nombres del archivo $file
        $array_code = [];
        $array_name = [];
        $i = 0;
        while(list($code, $names) = fgetcsv($fh, 1024, ',')){
            $array_code[$i] = $code;
            $array_name[$i] = $names;
            $i++;
        }
        return [$array_code,$array_name]; 
    }

    // Obtener los elementos que estan en $Bcodes pero no en $Acodes 
    function diferencia_Listas_de_B_peroNoEn_A($Acodes, $Bcodes, $Bnames){
        $ListaDifCodes = [];
        $ListaDifNames = [];
        //recorrer a cada elemento de $Bcodes
        for($i = 0; $i < count($Bcodes); $i++){
            //determinar si el elemento no esta en $Acodes
            if(!in_array($Bcodes[$i],$Acodes)){
                array_push($ListaDifCodes,$Bcodes[$i]);
                array_push($ListaDifNames,$Bnames[$i]);
            }
        }
        return [$ListaDifCodes,$ListaDifNames]; 
    }

    function mostrar($cod, $name) {
        for ($i = 0; $i < count($cod); $i++)
            {
                echo '<p class="tabla_datos__row__p">'.$cod[$i].'</p>';
                echo '<p class="tabla_datos__row__p">'.$name[$i].'</p>';
            }
    }

    // llamar a la funcion obtenerInformacion para recibir codigos y nombres
    list($ar1_codigos,$ar1_nombres) = obtenerInformacion('archivo1');
    list($ar2_codigos,$ar2_nombres) = obtenerInformacion('archivo2');

    //Obtener listas de alumos necesarias
    list($codigos_noTutorados_2022I,$nombres_noTutorados_2022I) = diferencia_Listas_de_B_peroNoEn_A($ar2_codigos, $ar1_codigos, $ar1_nombres);
    list($codigos_nuevosAlumnos,$nombres_nuevosAlumnos) = diferencia_Listas_de_B_peroNoEn_A($ar1_codigos, $ar2_codigos, $ar2_nombres);    
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
                        mostrar($codigos_noTutorados_2022I,$nombres_noTutorados_2022I);
                    }
                    else 
                    {
                        mostrar($codigos_nuevosAlumnos,$nombres_nuevosAlumnos);
                    }                    
                ?>
                
            </div>
            
        </div>
    </div>    
</body>
</html>