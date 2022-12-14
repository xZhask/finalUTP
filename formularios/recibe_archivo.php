<?php
session_start();
require_once '../sistema/ado/clsAtencion.php';
$objAtencion = new clsAtencion();

$idatencion = $_POST['idatencion'];
$idusuario = $_SESSION['idatencion'];
$fecha = date('Y/m/d H:i:s');

$examenpdf = $_FILES['mi-archivo']['name'];
$sourceexamenpdf = $_FILES['mi-archivo']['tmp_name'];
$directorioexamenes = 'examenes/';
$examenpdf = time() . '.pdf';
$dir = opendir($directorioexamenes);
$target_path = $directorioexamenes . '/' . $examenpdf;

if (move_uploaded_file($sourceexamenpdf, $target_path)) {
    $atencion_Proc = [
        'idatencion' => $idatencion,
        'idusuario' => $idusuario,
        'fechaatencion' => $fecha,
        'examen' => $target_path,
        'estado' => 'EN PROGR',
    ];
    $objAtencion->ActualizarAtencion_Proc($atencion_Proc);
?>
    <script type="text/javascript">
        window.close()
    </script>
<?php
} else {
    echo 'Ha ocurrido un error, por favor inténtelo de nuevo.';
}
closedir($dir);
