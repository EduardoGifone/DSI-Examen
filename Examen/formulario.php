<?php
    function upload_file($file)
    {
        if ($_FILES[$file]['error'] > 0)
        {
            echo 'Error: '.$_FILES[$file]['error'].'<br>';
        }
        else
        {
            move_uploaded_file($_FILES[$file]['tmp_name'], 'uploaded/'.$_FILES[$file]['name']);
        }            
    }

    function arreglo($file)
    {
        $archivo = 'uploaded/'.$_FILES[$file]['name'];
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

    function mostrar($array)
    {  
        foreach($array as $cod){
            print($cod."<br>");
        }
    }

    upload_file('archivo1');
    upload_file('archivo2');

    list($ar1_codigos,$ar1_nombres) = arreglo('archivo1');
    list($ar2_codigos,$ar2_nombres) = arreglo('archivo2');

    mostrar($ar1_codigos);
    
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
    <div class="container">
        <form action="" class="form">
            
            <label for="mostrar_no_tutorados" class="form__label">
                <input id="mostrar_no_tutorados" type="radio" name="mostrar" value="no_tutorados" class="form__radio">
                Mostrar alumnos que no seran tutorados en 2022-1</label>
            
            <label for="mostrar_nuevos_alumnos" class="form__label">
                <input id="mostrar_nuevos_alumnos" type="radio" name="mostrar" value="nuevos_alumnos" class="form__radio">
                Mostra nuevos alumnos para tutoria</label>

            <input type="submit" class="form__submit" value="Buscar">
        </form>

        <div class="tabla_datos">

            <div class="tabla_datos__row tabla_datos__row--head">
                <p class="tabla_datos__row__p">Codigo</p>
                <p class="tabla_datos__row__p">Nombre</p>
            </div>

            <div class="tabla_datos__row tabla_datos__row--body">
                <p class="tabla_datos__row__p">193001</p>
                <p class="tabla_datos__row__p">Eduardo Juareis Gifone Villasante</p>
            </div>
            
        </div>
    </div>    
</body>
</html>