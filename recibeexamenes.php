<?php
$idpaciente = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'];
$dni = $_REQUEST['id'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cargar IMAGENES</title>
    <link rel="stylesheet" type="text/css" href="recursos/css/estilos.css" />
    <script src="https://kit.fontawesome.com/47b4aaa3bf.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="cont_subirRX">
        <h2>
            <?php echo $nombre; ?>
        </h2>
        <form method="POST" action="formularios/recibe_imgs.php" enctype="multipart/form-data">
            <input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $idpaciente; ?>">
            <div class="cont_placas">
                <div class="placa">
                    <label class="dropimage">
                        <input title="Hacer Click aqui" type="file" name="foto1" id="foto1" required="true" accept="image/png,image/jpeg" />
                    </label>
                </div>
                <div class="placa">
                    <label class="dropimage">
                        <input title="Hacer Click aqui" type="file" name="foto2" id="foto2" accept="image/png,image/jpeg" />
                    </label>
                </div>
                <div class="placa">
                    <label class="dropimage">
                        <input title="Hacer Click aqui" type="file" name="foto3" id="foto3" accept="image/png,image/jpeg" />
                    </label>
                </div>
                <div class="placa">
                    <label class="dropimage">
                        <input title="Hacer Click aqui" type="file" name="foto4" id="foto4" accept="image/png,image/jpeg" />
                    </label>
                </div>
                <div class="placa">
                    <label class="dropimage">
                        <input title="Hacer Click aqui" type="file" name="foto5" id="foto5" accept="image/png,image/jpeg" />
                    </label>
                </div>
                <div class="placa">
                    <label class="dropimage">
                        <input title="Hacer Click aqui" type="file" name="foto6" id="foto6" accept="image/png,image/jpeg" />
                    </label>
                </div>
            </div>
            <div class="contenedor-upload">
                <input type="text" name="nombreexamen" id="nombreexamen" placeholder="Nombre o descripción de archivo" required>
                <button type="submit" class="btn-upload"><i class="fas fa-cloud-upload-alt"></i> Subir</button>
            </div>
    </div>
    </form>
    <script src="recursos/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            ;
            [].forEach.call(document.querySelectorAll('.dropimage'), function(
                img,
            ) {
                img.onchange = function(e) {
                    var inputfile = this,
                        reader = new FileReader()
                    reader.onloadend = function() {
                        inputfile.style['background-image'] = 'url(' + reader.result + ')'
                    }
                    reader.readAsDataURL(e.target.files[0])
                }
            })
        })
    </script>
</body>

</html>