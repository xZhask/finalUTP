<?php
$idatencion = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cargar Archivo</title>
    <script src="https://kit.fontawesome.com/47b4aaa3bf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="recursos/css/estilos.css" />
</head>

<body>
    <div class="cont_subirArchivo">
        <h2>
            <?php echo $nombre; ?>
        </h2>
        <form id="frmUploadFile" method="POST" action="formularios/recibe_archivo.php" enctype="multipart/form-data">
            <input type="hidden" name="idatencion" id="idatencion" value="<?php echo $idatencion; ?>">
            <span class="mi-archivo">
                <input type="file" name="mi-archivo" id="mi-archivo" accept="application/pdf" required>
            </span>
            <label for="mi-archivo">
                <span>Arrastra o Click para seleccionar Archivo</span>
                <i class="far fa-folder-open"></i>
            </label>
            <button class="submit" type="submit">SUBIR ARCHIVO</button>
    </div>
    </form>
    <script src="recursos/js/jquery-3.4.1.min.js"></script>
    <script>
        jQuery('#mi-archivo').change(function() {
            var filename = jQuery(this).val().split('\\').pop();
            var idname = jQuery(this).attr('id');
            console.log(jQuery(this));
            console.log(filename);
            console.log(idname);
            jQuery('span.' + idname).next().find('span').html(filename);
        });
    </script>
</body>

</html>