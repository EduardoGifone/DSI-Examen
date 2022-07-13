<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>INGRESAR ARCHIVOS</title>
</head>
<body>
    <h1 class="h1">INGRESE ARCHIVOS</h1>
    <div class="container">        
        <form action="formulario.php" class="form" method="POST" enctype="multipart/form-data">
            
            <input id="archivo1" type="file" accept=".csv" class="form__input" name="archivo1">
            <label for="archivo1" class="form__label">Cargar alumnos antiguos (.csv)</label>
            
            <input id="archivo2" type="file" accept=".csv" class="form__input" name="archivo2">
            <label for="archivo2" class="form__label">Cargar alumnos matriculados 2022-1 (.csv)</label>

            <input type="submit" class="form__submit">
        </form>
    </div>
</body>
</html>