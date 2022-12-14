<?php
session_start();
require_once '../sistema/ado/clsExamenes.php';
$objExamenes = new clsExamenes();

$idpaciente = $_POST['idpaciente'];
$nombre = $_POST['nombreexamen'];
$fecha = date('Y/m/d H:i:s');

$examen = [
    'dni' => $idpaciente,
    'nombre' => $nombre,
    'fecha' => $fecha,
    'tipoexamen' => 'IMG',
];

$objExamenes->RegistrarExamen($examen);
$ultimoExamen = $objExamenes->ObtenerUltimoExamen();
$ultimoExamen = $ultimoExamen->fetch(PDO::FETCH_NAMED);

for ($i = 1; $i <= 6; $i++) {
    $filename = $_FILES['foto' . $i]['name'];
    $source = $_FILES['foto' . $i]['tmp_name'];

    //Verificando si existe el directorio de lo contarios lo creamos el Directorio
    $directorio = 'filesImgs/' . $idpaciente . '/';
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }
    $filename = time() . $i . '.jpg';
    $dir = opendir($directorio);
    $target_path = $directorio . '/' . $filename;

    if (move_uploaded_file($source, $target_path)) {
        $datosDetalle = [
            'idexamen' => $ultimoExamen['idexamen'],
            'archivo' => 'formularios/' . $target_path
        ];
        $objExamenes->RegistrarDetalleExamen($datosDetalle);
?>
        <script type="text/javascript">
            window.close()
        </script>

<?php } else {
        echo 'Ha ocurrido un error, por favor inténtelo de nuevo.<br>';
    }
    closedir($dir);
}

?>