<?php
    function arreglo($file)
    {
        $archivo = $_FILES[$file]['tmp_name'];
        $fh = fopen($archivo, 'r');
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

    list($ar1_codigos,$ar1_nombres) = arreglo('archivo1');
    list($ar2_codigos,$ar2_nombres) = arreglo('archivo2');

    function diferencia_Listas_de_B_peroNoEn_A($Acodes, $Bcodes, $Bnames){
        $ListaDifCodes = [];
        $ListaDifNames = [];
        for($i = 0; $i < count($Bcodes); $i++){
            if(!in_array($Bcodes[$i],$Acodes)){
                array_push($ListaDifCodes,$Bcodes[$i]);
                array_push($ListaDifNames,$Bnames[$i]);
            }
        }
        return [$ListaDifCodes,$ListaDifNames]; 
    }

    //Obtener listas de alumos necesarias
    list($codigos_Tutorados_2022I,$nombres_Tutorados_2022I) = diferencia_Listas_de_B_peroNoEn_A($ar1_codigos, $ar2_codigos, $ar2_nombres);
    list($codigos_nuevos,$nombres_nuevos) = diferencia_Listas_de_B_peroNoEn_A($ar2_codigos, $ar1_codigos, $ar1_nombres);
    
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

        <div class="tabla_datos">

            <div class="tabla_datos__row tabla_datos__row--head">
                <p class="tabla_datos__row__p">Codigo</p>
                <p class="tabla_datos__row__p">Nombre</p>
            </div>

            <div class="tabla_datos__row tabla_datos__row--body">
                <?php
                    
                ?>
                <p class="tabla_datos__row__p">193001</p>
                <p class="tabla_datos__row__p">Eduardo Juareis Gifone Villasante</p>
            </div>
            
        </div>
    </div>    
</body>
</html>