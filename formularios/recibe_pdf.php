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
    'tipoexamen' => 'PDF',
];

$objExamenes->RegistrarExamen($examen);
$ultimoExamen = $objExamenes->ObtenerUltimoExamen();
$ultimoExamen = $ultimoExamen->fetch(PDO::FETCH_NAMED);

$examenpdf = $_FILES['mi-archivo']['name'];
$sourceexamenpdf = $_FILES['mi-archivo']['tmp_name'];
//Verificando si existe el directorio de lo contarios lo creamos el Directorio
$directorio = 'filesPdfs/' . $idpaciente . '/';
if (!file_exists($directorio)) {
    mkdir($directorio, 0777, true);
}

$examenpdf = time() . '.pdf';
$dir = opendir($directorio);
$target_path = $directorio . '/' . $examenpdf;

if (move_uploaded_file($sourceexamenpdf, $target_path)) {
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
?>
?>