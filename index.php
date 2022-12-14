<?php
session_start();
if (empty($_SESSION['active'])) {
  header('location: login.php');
}
require_once 'sistema/ado/clsProcedimiento.php';
require_once 'sistema/ado/clsConsultas.php';
require_once 'sistema/ado/clsMedicamentos.php';
$objProcedimiento = new clsProcedimiento();
$objConsultas = new clsConsultas();
$objMedicamentos = new clsMedicamentos();
$TIposDePago = $objConsultas->ListarTiposPago();
$listadoProc = $objProcedimiento->ListarProcedimientos();
$listadoMedicamentos = $objMedicamentos->ListarMedicamento();
$listadoProductos = $objMedicamentos->ListarProductos();
$array = [];
while ($row = $listadoProc->fetch(PDO::FETCH_NAMED)) {
  $nombre = $row['nombre'];
  array_push($array, $nombre);
}

$medicamentos = [];
while ($row = $listadoMedicamentos->fetch(PDO::FETCH_NAMED)) {
  $medicamento = $row['nombre'];
  array_push($medicamentos, $medicamento);
}
$productos = [];
while ($row = $listadoProductos->fetch(PDO::FETCH_NAMED)) {
  $producto = $row['nombre'];
  array_push($productos, $producto);
}
$cargo = $_SESSION['cargo'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/47b4aaa3bf.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="recursos/js/jquery-ui-1.12.1/jquery-ui.min.css" />
  <script language="javascript" src="recursos/js/jquery-3.4.1.min.js"></script>
  <script language="javascript" src="recursos/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="recursos/css/estilos.css" />
  <link rel="icon" type="image/png" href="recursos/img/favicon.png" />
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Inicio</title>
</head>

<body>
  <div class="bg-dark">
    <div class="modal">
      <a href="javascript:void(0)" class="btn-close" onclick="cerrarmodal()">
        <i class="fas fa-times"></i>
      </a>
      <form id="frmregistrarcita">
        <h2>Registrar Cita</h2>
        <input type="hidden" id="AccionCita" name="accion" value="REGISTRAR_CITA" />
        <input type="hidden" id="CodigoCita" name="CodigoCita" />
        <input type="hidden" id="TipoPaciente" name="TipoPaciente" />
        <div class="grupo-inputs">
          <input type="text" class="txt-search" placeholder="Número de Documento" id="NroDocCita" name="NroDocCita" />
          <button type="button" class="btn-search" onclick="ObtenerDatosPaciente()">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <input type="text" placeholder="Nombre de Paciente" id="NombrePacienteC" name="NombrePacienteC" readonly class="textdisabled" />
        <div class="cont-input-toggle">
          <div class="controls-colum">
            <label for="NombrePacienteCita">Nombres:</label>
            <input type="text" name="NombrePacienteCita" id="NombrePacienteCita" readonly class="textdisabled" />
          </div>
          <div class="controls-colum">
            <label for="ApellidosPacienteCita">Apellidos:</label>
            <input type="text" name="ApellidosPacienteCita" id="ApellidosPacienteCita" readonly class="textdisabled" />
          </div>
          <div class="controls-colum">
            <label for="fecha_nac">Fecha de Nac.:</label>
            <input type="date" name="FechaNacCita" id="FechaNacCita" />
          </div>
        </div>
        <div class="check-toggle">
          <div class="checkbox">
            <input type="checkbox" name="menor" id="menor" onclick="validar_menor()">
            <label for="menor">Menor de Edad</label>
          </div>
        </div>
        <input type="hidden" id="IdMovitoCita" name="IdMovitoCita">
        <input type="text" class="MotivoCita" id="MovitoCita" name="MovitoCita" placeholder="Motivo de Cita">
        <input type="number" id="PrecioMotivoCita" name="PrecioMotivoCita" placeholder="Precio de Proc./Consulta">
        <div class="grupo-inputs">
          <input type="date" name="FechaCita" id="FechaCita" />
          <input type="time" name="HoraCita" id="HoraCita" />
        </div>
        <input type="text" placeholder="N° de celular" id="NroCelularCita" name="NroCelularCita" />
        <button type="button" onclick="RegistrarCita()">
          Registrar
        </button>
      </form>
      <form id="frmregistrarpaciente">
        <h2>Registrar Paciente</h2>
        <input type="hidden" id="AccionPaciente" name="accion" value="REGISTRAR_PACIENTE" />
        <div class="grupo-inputs">
          <input type="text" class="txt-search" placeholder="Número de Documento" id="NroDocPaciente" name="NroDocPaciente" />
          <button type="button" class="btn-search" onclick="BuscarPersonaPaciente()">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <input type="text" placeholder="Nombres de Paciente" class="textdisabled" id="NombrePaciente" name="NombrePaciente" readonly />
        <input type="text" placeholder="Apellidos de Paciente" class="textdisabled" id="ApellidosPaciente" name="ApellidosPaciente" readonly />
        <div id="checkPaciente" class="check-toggle">
          <div class="checkbox">
            <input type="checkbox" name="menorPaciente" id="menorPaciente" onclick="validar_menorPaciente()">
            <label for="menorPaciente">Menor de Edad</label>
          </div>
        </div>
        <label for="">Fecha de Nacimiento</label>
        <input type="date" name="fechanac" id="fechanac" />
        <input type="text" placeholder="N° Celular" id="NroCelular" name="NroCelular" />
        <button type="button" onclick="RegistrarPaciente()">Registrar</button>
      </form>
      <form id="frmregistrarusuario">
        <h2>Registrar Usuario</h2>
        <input type="hidden" id="AccionUsuario" name="accion" value="REGISTRAR_USUARIO" />
        <div class="grupo-inputs">
          <input type="text" class="txt-search" placeholder="Número de Documento" id="NroDocPersonal" name="NroDocPersonal" />
          <button type="button" class="btn-search" onclick="BuscarPersonaPersonal()">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <input type="text" placeholder="Nombres de Personal" id="NombrePersonal" name="NombrePersonal" readonly class="textdisabled" />
        <input type="text" placeholder="Apellidos de Personal" id="ApellidosPersonal" name="ApellidosPersonal" readonly class="textdisabled" />
        <input type="text" placeholder="Usuario o Nickname" id="Nick" name="Nick" />
        <input type="text" placeholder="Contraseña" id="Pass" name="Pass" />
        <select name="idcargo" id="idcargo">
          <!-- AJAX-->
        </select>
        <select name="EstadoUsuario" id="EstadoUsuario">
          <option value="A">ACTIVO</option>
          <option value="I">INACTIVO</option>
        </select>
        <button type="button" onclick="RegistrarPersonal()">
          Registrar
        </button>
      </form>
      <form id="frmregistrarcargo">
        <h2>Registrar Cargo</h2>
        <input type="text" placeholder="Nombre de Nuevo Cargo" id="NombreCargo" name="NombreCargo" />
        <button type="button" onclick="RegistrarCargo()">Registrar</button>
      </form>
      <form id="frmregistrarpago">
        <h2>Registrar Pago</h2>
        <input type="hidden" id="AccionPago" name="accion" value="REGISTRAR_PAGO" />
        <input type="hidden" id="IdCita" name="IdCita" placeholder="ID DE CITA" readonly>
        <input type="text" placeholder="Nombres de Paciente" name="NombrePago" id="NombrePago" readonly />
        <input type="text" id="MotivoPago" name="MotivoPago" placeholder="Motivo de Cita" readonly />
        <label for="PrecioPago">Precio Total:</label>
        <input type="text" placeholder="Precio" id="PrecioPago" name="PrecioPago" readonly />
        <label for="ACuentaPago">A cuenta:</label>
        <input type="text" placeholder="A Cuenta" id="ACuentaPago" name="ACuentaPago" />
        <select name="tipopago" id="tipopago">
          <option value="0">TIPO DE PAGO</option>
          <?php while ($row = $TIposDePago->fetch(PDO::FETCH_NAMED)) { ?>
            <option value="<?php echo $row['idtipopago']; ?>"><?php echo $row['tipopago']; ?></option>
          <?php } ?>
        </select>
        <button type="button" id="btn-regPago" onclick="RegistrarPago()">Registrar</button>
      </form>
      <form id="frmraperturarcaja">
        <h2>Apertura de Caja</h2>
        <input type="number" placeholder="Monto inicial" id="MontoInicial" name="MontoInicial" min="1" />
        <button type="button" onclick="aperturarcaja()">Registrar</button>
      </form>
      <form id="frmRegistrarAtencion">
        <h2 id="NombresAtencion">
          APELLIDOS Y NOMBRES, DE PACIENTE
          <br />
          <span>Dni: - | Edad: - años</span>
        </h2>
        <input type="hidden" id="AccionAtencion" name="accion" value="REGISTRAR_ATENCION" />
        <input type="hidden" name="ate_idatencion" id="ate_idatencion">
        <input type="hidden" name="dni_atencion" id="dni_atencion">
        <input type="hidden" id="typeAction" name="typeAction" value="REGISTRAR" />
        <fieldset class="signos-vitales nvisible">
          <legend>
            Signos vitales
          </legend>
          <div class="grupo-inputs">
            <div class="grupo-controls">
              <label for="ate_fc">FC:</label>
              <input type="text" name="ate_fc" id="ate_fc" readonly />
            </div>
            <div class="grupo-controls">
              <label for="ate_pa">PA:</label>
              <input type="text" name="ate_pa" id="ate_pa" readonly />
            </div>
            <div class="grupo-controls">
              <label for="ate_temp">T°:</label>
              <input type="text" name="ate_temp" id="ate_temp" readonly />
            </div>
            <div class="grupo-controls">
              <label for="ate_so2">So2:</label>
              <input type="text" name="ate_so2" id="ate_so2" readonly />
            </div>
            <div class="grupo-controls">
              <label for="ate_peso">PESO:</label>
              <input type="text" name="ate_peso" id="ate_peso" readonly />
            </div>
          </div>
        </fieldset>
        <fieldset class="nvisible">
          <legend>
            Antecedentes
          </legend>
          <div class="grupo-inputs">
            <div class="grupo-controls w60 cont-gr-radios">
              <div class="group-radios">
                <label>HEPATITIS: </label>
                <div class="radio">
                  <input type="radio" class="radio-si" name="hep" id="hepsi" value="SI" />
                  <label for="hepsi">SI</label>
                  <input type="radio" name="hep" id="hepno" value="NO" checked />
                  <label for="hepno">NO</label>
                </div>
              </div>
              <div class="group-radios">
                <label>DIABETES: </label>
                <div class="radio">
                  <input type="radio" class="radio-si" name="dm" id="dmsi" value="SI" />
                  <label for="dmsi">SI</label>
                  <input type="radio" name="dm" id="dmno" value="NO" checked />
                  <label for="dmno">NO</label>
                </div>
              </div>
              <div class="group-radios">
                <label>HIV: </label>
                <div class="radio">
                  <input type="radio" class="radio-si" name="hiv" id="hivsi" value="SI" />
                  <label for="hivsi">SI</label>
                  <input type="radio" name="hiv" id="hivno" value="NO" checked />
                  <label for="hivno">NO</label>
                </div>
              </div>
              <div class="group-radios">
                <label>HTA: </label>
                <div class="radio">
                  <input type="radio" class="radio-si" name="hta" id="htasi" value="SI" />
                  <label for="htasi">SI</label>
                  <input type="radio" name="hta" id="htano" value="NO" checked />
                  <label for="htano">NO</label>
                </div>
              </div>
              <div class="group-radios w100">
                <label for="alergias">ALERGIAS: </label>
                <input type="text" name="alergias" id="alergias" value="-">
              </div>
            </div>
            <div class="grupo-controls w60 pd-left1">
              <div class="group-radios w100">
                <label>CIRUGÍAS: </label>
                <input type="text" name="cirugias" id="cirugias" value="-">
              </div>
              <div class="group-radios w100">
                <label>ENDOSCPÍA: </label>
                <input type="text" name="endoscopias" id="endoscopias" value="-">
              </div>
              <div class="group-radios w100">
                <label>COVID: </label>
                <div class="radio">
                  <input type="radio" name="covid" id="covidsi" value="SI" />
                  <label for="covidsi">SI</label>
                  <input type="radio" name="covid" id="covidno" value="NO" checked />
                  <label for="covidno">NO</label>
                </div>
              </div>
            </div>
          </div>
        </fieldset>
        <fieldset class="mgt5">
          <div class="grupo-inputs">
            <div class="grupo-controls w60">
              <label for="ate_molestia">Motivo de consulta:</label>
              <textarea name="ate_molestia" id="ate_molestia" cols="30" rows="3" value="-"></textarea>
            </div>
            <div class="grupo-controls w60">
              <label for="ate_antecedentes">Antecedentes:</label>
              <textarea name="ate_antecedentes" id="ate_antecedentes" cols="30" rows="3" value="-"></textarea>
            </div>
          </div>
        </fieldset>
        <fieldset class="mgt5">
          <div class="cont-contenido-atencion">
            <div class="contenido-atencion">
              <h2>OBS. GENERALES</h2>
              <textarea name="txtanamnesis" id="txtanamnesis" cols="30" rows="9" placeholder="Ingresar texto" value="-"></textarea>
            </div>
            <div class="contenido-atencion">
              <h2>HISTORIA FAMILIAR</h2>
              <textarea name="txtexamenfisico" id="txtexamenfisico" cols="30" rows="9" placeholder="Ingresar texto" value="-"></textarea>
            </div>
            <div class="contenido-atencion">
              <h2>HISTORIA PERSONAL</h2>
              <textarea name="txtdiagnostico" id="txtdiagnostico" cols="30" rows="9" placeholder="Ingresar texto" value="-"></textarea>
            </div>
            <div class="contenido-atencion">
              <h2>DIAGNÓSTICO</h2>
              <textarea name="txttratamiento" id="txttratamiento" cols="30" rows="9" placeholder="Ingresar texto" value="-"></textarea>
            </div>
          </div>
        </fieldset>
        <button type="button" id="btnregistraratencion" onclick="RegistrarAtencion()">Registrar</button>
      </form>
      <form id="frmEleccionPago">
        <h2>¿Desea Registrar Pago?</h2>
        <div class="count-grupobotones ta-center">
          <button type="button" class="btneleccion" id="btnsi_mostrarpago" onclick="MostrarPagar()">SI</button>
          <button type="button" class="btneleccion btnsecundario" onclick="cerrarmodal()">NO</button>
        </div>
      </form>
      <form id="frmRegistrarGasto">
        <h2>Registrar Gasto</h2>
        <input type="hidden" id="AccionGasto" name="accion" value="REGISTRAR_GASTO" />
        <input type="text" placeholder="Descripción de Gasto" id="DescripcionGasto" name="DescripcionGasto" min="1" />
        <input type="number" placeholder="Monto de Gasto" id="MontoGasto" name="MontoGasto" min="1" />
        <button type="button" id="btnregistrargasto" onclick="registrargasto()">Registrar</button>
      </form>
      <form id="frmRegistrarSignosV">
        <h2>Registrar Signos Vitales</h2>
        <input type="hidden" id="AccionSignosVitales" name="accion" value="REGISTRAR_SIGNOS_VITALES" />
        <input type="hidden" name="idatencion_signos" id="idatencion_signos">
        <div class="grupo-inputs">
          <div class="grupo-controls w60">
            <label for="fr_signosv">Frec.Card.:</label>
            <input type="text" name="fr_signosv" id="fr_signosv" />
          </div>
          <div class="grupo-controls w60">
            <label for="pa_signosv">Pres.Arterial:</label>
            <input type="text" name="pa_signosv" id="pa_signosv" />
          </div>
          <div class="grupo-controls w60">
            <label for="peso_signosv">Peso:</label>
            <input type="text" name="peso_signosv" id="peso_signosv" />
          </div>
          <div class="grupo-controls w60">
            <label for="so2_signosv">SO2:</label>
            <input type="text" name="so2_signosv" id="so2_signosv" />
          </div>
          <div class="grupo-controls w60">
            <label for="temp_signosv">Temp:</label>
            <input type="text" name="temp_signosv" id="temp_signosv" />
          </div>
        </div>
        <button type="button" id="btnregistrarsignos" onclick="registrarSignosVitales()">Registrar</button>
      </form>
      <form id="frmHistorial">
        <h2 id="h2Paciente">
          APELLIDOS Y NOMBRES, DE PACIENTE
          <br />
          <span>Dni: 48193845 | Edad: 27 años</span>
        </h2>
        <input type="hidden" name="IdPacienteHistoria" id="IdPacienteHistoria">
        <div class="cont-historia">
          <div class="aside_historia">
            <h2 class="h2-historial">Atenciones</h2>
            <ul id="ul-atenciones">
              <!-- AJAX -->
            </ul>
            <h2 class="h2-historial">Otros Exámenes</h2>
            <ul id="ul-otrosexamenes">
              <!-- AJAX -->
            </ul>
          </div>
          <div class="consulta_historia">
            <div class="cont-opciones-examenes"><button type="button" id="btnEditAtencion">Editar Atención</button></div>
            <!-- <div class="hist_signos datosconsulta">
              <h4>SIGNOS VITALES</h4>
              <div class="cont-signos">
                <p id="hist_fc"><span>FC :</span>-</p>
                <p id="hist_pa"><span>PA :</span>-</p>
              </div>
              <div class="cont-signos">
                <p id="hist_t"><span>T° :</span>-</p>
                <p id="hist_so2"><span>So2 :</span>-</p>
              </div>
              <div class="cont-signos">
                <p id="hist_peso"><span>PESO:</span>-</p>
              </div>
            </div> -->
            <div class="w60 datosconsulta">
              <p id="hist_fecha">Fecha : </p>
              <label>Motivo de consulta: </label>
              <p id="hist_molestia">-</p>
            </div>
            <div class="w60 datosconsulta">
              <label>Antecedentes:</label>
              <p id="hist_antecedente">Miau</p>
            </div>
            <fieldset>
              <label>Observaciones Generales: </label>
              <p id="hist_anamnesis">-</p>
            </fieldset>
            <fieldset>
              <label>Historia familiar: </label>
              <p id="hist_exfisico">-</p>
            </fieldset>
            <fieldset>
              <label>Historia personal: </label>
              <p id="hist_diagnostico">-</p>
            </fieldset>
            <fieldset>
              <label>diagnóstico: </label>
              <p id="hist_tratamiento">-</p>
            </fieldset>
            <div class="cont-examen" id="cont-examen">
              <!-- <iframe src="formularios/examenes/1628352820.pdf" width="100%" height="900px">
              </iframe> -->
            </div>
            <div class="cont-imagenes" id="cont-imagenes">
              <!-- <div class="imagen">
                <img src="formularios/filesImgs/16456828/16286076081.jpg" alt="">
              </div>
              <div class="imagen"><img src="formularios/filesImgs/16456828/16286076082.jpg" alt=""></div> -->
            </div>
          </div>
        </div>
      </form>
      <form id="frmRegistrarProcedimiento">
        <h2>Registrar Procedimiento</h2>
        <input type="hidden" id="AccionProcedimiento" name="accion" value="REGISTRAR_PROCEDIMIENTO" />
        <input type="hidden" name="idprocedimiento" id="idprocedimiento">
        <input type="text" placeholder="Nombre de Procedimiento" id="NombreProcedimiento" name="NombreProcedimiento" />
        <input type="number" placeholder="Precio de Procedimiento" id="PrecioProcedimiento" name="PrecioProcedimiento" min="1" />
        <button type="button" id="btnregistrarProcedimiento" onclick="RegistrarProcedimiento()">Registrar</button>
      </form>
      <form id="frmregistrarEstablecimiento">
        <h2>Registrar Establecimiento</h2>
        <input type="text" placeholder="Nombre de Nuevo Establecimiento" id="NombreEstablecimiento" name="NombreEstablecimiento" />
        <button type="button" onclick="RegistrarEstablecimiento()">Registrar</button>
      </form>
      <form id="frmregistrarcita_externa">
        <h2>Registrar Cita Externa</h2>
        <input type="hidden" id="AccionCitaExterna" name="accion" value="REGISTRAR_CITA_EXTERNA" />
        <input type="hidden" id="CodigoCitaExterna" name="CodigoCitaExterna" />
        <select class="establecimiento" name="establecimientoCitaExterna" id="establecimientoCitaExterna">
          <!-- Ajax -->
        </select>
        <div class="grupo-inputs">
          <input type="text" class="txt-search" placeholder="Número de Documento de Paciente" id="NroDocCitaExt" name="NroDocCitaExt" />
          <button type="button" class="btn-search" onclick="ObtenerDatosPacienteCExt()">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <input type="text" placeholder="Nombre de Paciente" id="NombrePacienteCExt" name="NombrePacienteCExt" readonly class="textdisabled" />
        <input type="hidden" id="IdMovitoCitaExterna" name="IdMovitoCitaExterna">
        <input type="text" class="MotivoCita" id="MovitoCitaExterna" name="MovitoCitaExterna" placeholder="Motivo de CitaExterna">
        <input type="number" id="PrecioMotivoCitaExterna" name="PrecioMotivoCitaExterna" placeholder="Precio de Proc./Consulta">
        <div class="grupo-inputs">
          <input type="date" name="FechaCitaExterna" id="FechaCitaExterna" />
          <input type="time" name="HoraCitaExterna" id="HoraCitaExterna" />
        </div>
        <button type="button" onclick="RegistrarCitaExterna()">
          Registrar
        </button>
      </form>
      <form id="frmRegistrarTratamiento">
        <h2>Registrar Tratamiento</h2>
        <input type="hidden" id="AccionTratamiento" name="accion" value="REGISTRAR_TRATAMIENTO" />
        <input type="hidden" name="idatencion_trat" id="idatencion_trat">
        <input type="hidden" name="idmedicamento" id="idmedicamento">
        <input type="text" placeholder="Nombre de Medicamento" id="NombreMedicamento_Trat" name="NombreMedicamento_Trat" />
        <div class="cont-groupbotones cont-tratamiento">
          <input type="text" placeholder="Indicacion de Tratamiento" id="IndicacionTratamiento" name="IndicacionTratamiento" />
          <button type="button" id="btnAgregarCarrito" onclick="AgregarCarrito()">Agregar</button>
        </div>
        <div class="cont-tabla">
          <table>
            <thead>
              <tr>
                <th>Item</th>
                <th>Cod.</th>
                <th>Medicamento</th>
                <th>Indicación</th>
                <th>Quitar</th>
              </tr>
            </thead>
            <tbody id="tbTratamiento">
              <!--Ajax-->
            </tbody>
          </table>
        </div>
        <button type="button" id="btnregistrarTratamiento" onclick="RegistrarTratamiento()">Registrar</button>
      </form>
      <form id="frmRegistrarProducto">
        <h2>Registrar Movimiento Almacén</h2>
        <input type="hidden" name="accion" value="REGISTRAR_MOVIMIENTO_ALM" />
        <div class="group-radios w100">
          <div class="radio w100">
            <input type="radio" name="movimientoalmacen" id="I" value="I" />
            <label for="I">INGRESO</label>
            <input type="radio" name="movimientoalmacen" id="S" value="S" />
            <label for="S">SALIDA</label>
          </div>
        </div>
        <input type="text" placeholder="Nombre de Medic./Insumo" id="NombreProducto" name="NombreProducto" />
        <input type="hidden" name="IdProducto" id="IdProducto">
        <input type="hidden" name="StockProducto" id="StockProducto">
        <input type="number" placeholder="Cantidad" id="CantidadProducto" name="CantidadProducto" min="1" />
        <input type="text" placeholder="Descripción" id="Descripcion" name="Descripcion" />
        <button type="button" id="btnregistrarMovimientoA" onclick="RegistrarMovimientoA()">Registrar</button>
      </form>
      <form id="frmKardex">
        <h2>Kardex</h2>
        <input type="hidden" name="accion" value="KARDEX" />
        <input type="text" placeholder="Nombre de Medic./Insumo" id="NombreProductoKardex" name="NombreProductoKardex" />
        <input type="hidden" name="IdProductoKardex" id="IdProductoKardex">
        <div class="cont-groupbotones Controls-Kardex">
          <label for="KardexDesde">Desde :</label>
          <div class="cont-control">
            <input type="date" name="KardexDesde" id="KardexDesde" />
          </div>
          <label for="KardexHasta">Hasta :</label>
          <div class="cont-control">
            <input type="date" name="KardexHasta" id="KardexHasta" />
          </div>
          <button class="btn-secundario" type="button" onclick="Kardex()">
            Generar
          </button>
        </div>
        <label id="lblstockactual">Stock Actual:</label>
        <div class="cont-tabla">
          <table>
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Registrado Por</th>
                <th>Ingreso</th>
                <th>Salida</th>
                <th>Saldo</th>
              </tr>
            </thead>
            <tbody id="tbKardex">
              <!-- AJAX -->
            </tbody>
            <tfoot></tfoot>
          </table>
        </div>
      </form>
      <form id="frmBuscarCitas">
        <h2>Buscar Citas</h2>
        <div class="grupo-inputs">
          <input type="text" class="txt-search" placeholder="Número de Documento" id="NroDocBuscarCita" name="NroDocBuscarCita" />
          <button type="button" class="btn-search" onclick="ObtenerCitas()">
            <i class="fas fa-search"></i>
          </button>
        </div>
        <label id="lblNombreBuscarCitas">Nombre :</label>
        <div class="cont-tabla">
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Motivo de Consulta</th>
                <th>Estado</th>
                <th>Estado Atención</th>
                <th>Imp.</th>
              </tr>
            </thead>
            <tbody id="tbBusquedaCitas">
              <!-- AJAX -->
            </tbody>
            <tfoot></tfoot>
          </table>
        </div>
      </form>
      <form id="frmCambioPass">
        <h2>Cambiar Contraseña</h2>
        <input type="hidden" name="accion" value="CAMBIAR_PASS" />
        <input type="hidden" name="IdUsuario" id="IdUsuario" />
        <input type="password" placeholder="Ingrese Nueva Contraseña" id="pass1" name="pass1" />
        <input type="password" placeholder="Repetir Contraseña" id="pass2" name="pass2" />
        <button type="button" onclick="CambiarPass()">Registrar</button>
      </form>
    </div>
  </div>
  <header>
    <div class="cont-logo">
      <span>Centro Psicológico</span>
    </div>
    <div class="cont-sesion">
      <p><?php echo $_SESSION['apellidos'] . ', ' . $_SESSION['nombre']; ?></p>
      <i class="fas fa-power-off btn-off" id="btn-off"></i>
    </div>
  </header>
  <div class="wrapper">
    <div class="cont-menu-responsive">
      <i class="fas fa-bars btn-toggle"></i>
    </div>
    <aside id="aside">
      <picture>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 767.91 768.16">
          <defs>
            <style>
              .cls-1 {
                fill: #bf9ac6;
              }

              .cls-2 {
                fill: #855d91;
              }

              .cls-3 {
                fill: #f296a0;
              }

              .cls-4 {
                fill: #8e5499;
              }

              .cls-5 {
                fill: #f297a0;
              }

              .cls-6 {
                fill: #f5b46c;
              }

              .cls-7 {
                fill: #fde98b;
              }

              .cls-8 {
                fill: #fce987;
              }

              .cls-9 {
                fill: #fdf6e4;
              }

              .cls-10 {
                fill: #9bd09a;
              }

              .cls-11 {
                fill: #5ac0a8;
              }

              .cls-12 {
                fill: #5ac1a2;
              }

              .cls-13 {
                fill: #52aabe;
              }

              .cls-14 {
                fill: #a9cfd1;
              }
            </style>
          </defs>
          <g id="Capa_2" data-name="Capa 2">
            <g id="Capa_1-2" data-name="Capa 1">
              <path class="cls-1" d="M175.11,129.16c.47-6.08,3.3-11.46,6.57-16.24,4.83-7.06,8.83-14.67,14.93-21C207,81.25,218,71.74,232.09,66.17a91.14,91.14,0,0,1,46.37-5.54c12.2,1.6,24.3,3.17,35.59,8.61a22.12,22.12,0,0,1,9.77,8.89c9.92,17.22,36.77,27.08,56.23,17.83,9.79-4.66,17.72-11.59,26-18.12,10-7.87,21.44-10,33.68-8.81,14.27,1.4,25.8,7.84,34.33,19.53,10,13.75,13.54,29.14,12.36,46-1.28,18.32-8.06,34.78-17,50.37a143.73,143.73,0,0,1-19.07,26c-6.33,6.86-13,12.92-21.51,17.11-9.66,4.76-19.73,5.45-30.1,4.62a41.48,41.48,0,0,1-22.13-7.94c-11.26-8.52-21.48-18.15-29.4-30-6.71-10-13.69-19.86-20-30.14q-5.3-8.67-10.6-17.34c-7.65-12.55-14.3-25.77-23.08-37.55-12.08-16.2-28.48-24.89-50.47-22.34-21.1,2.46-36.79,14.06-51.71,27.54-4.56,4.12-8.76,8.66-13.16,13C177.51,128.59,176.87,129.81,175.11,129.16Z" />
              <path class="cls-2" d="M432.54,57.62c-3.5,0-7,.1-10.49,0-1.32-.06-3.43,1-3.77-1.09-.26-1.59,1.64-2.5,2.93-3.05a76.54,76.54,0,0,1,16.55-5.36c18.12-3.32,36.19-4.61,54.32.53,17.44,4.94,31.49,14.87,43,28.42,8.06,9.48,15.22,19.69,20.46,31.13A30,30,0,0,1,558,127c-3.44,18.09,3.5,32.27,17,44.06,11.32,9.9,25.2,11.62,39.12,12.49,22.91,1.44,39.78,20.76,42.36,37.54,3,19.72-2,37.71-16,52.52-15.18,16-34.38,24.84-55.37,30.1-18.21,4.56-36.65,6.51-55.26,2.27-18-4.11-29.09-16-35-32.88-5.45-15.62-5-31.7-2.58-47.83,3.36-22.74,10.49-44.57,16.24-66.73,3.76-14.51,6.56-29.12,6.49-44.25-.11-24.49-16-43-37.7-50.19C462.77,59.33,447.75,57.76,432.54,57.62Z" />
              <path class="cls-3" d="M645.38,487c-22.06.09-37.43-5.57-52.47-13a161.87,161.87,0,0,1-34.09-22.29c-16.56-14.2-26.5-31.83-22.4-54.29,2.35-12.88,9.68-24,18.77-33.34,15.85-16.33,35.42-27.67,54.94-38.9,18.42-10.61,36.93-21.09,53.67-34.25,8.25-6.48,13-15.55,16.16-25.72,6.61-21.33-.42-39.67-12.13-56.68-7-10.16-15.91-18.93-24.59-27.77-.88-.9-2.93-1.65-1.28-3.57,1.36-1.59,3-.54,4.11,0a127.34,127.34,0,0,1,41.31,31.25C704,227.68,710.12,250,708.7,274.7c-.82,14.35-5,28.05-10.31,41.31a16.44,16.44,0,0,1-7.34,7.82c-9.71,5.62-16,14.19-19.29,24.88-1.16,3.78-2.85,7.35-3.07,11.49-.64,11.9,4.18,21.87,10.46,31.35,6,9.11,13.13,17.52,17.43,27.73,6.53,15.53,2.38,36.3-9.3,48.65C674.46,481.49,658.67,487.16,645.38,487Z" />
              <path class="cls-1" d="M319.71,43.66C320.37,19.39,338.86-.65,363.39,0c26,.71,43.53,17.19,43.28,45.43-.24,26.13-17.9,43.73-45.62,44.22C339.81,90.05,318.39,68.24,319.71,43.66Z" />
              <path class="cls-4" d="M611.25,86c25-.21,43,18.76,43,45.1-.09,25.76-21.09,41.68-45.4,42.17-27.29.55-42.86-18.38-43.11-43.23S585.66,85.88,611.25,86Z" />
              <path class="cls-5" d="M767.86,363.71c.58,26.6-20.14,42.79-44,43.84-22.25,1-44.42-19.51-44.75-39.88-.48-29.9,20.17-47.27,46.49-47.73C749.08,319.53,769.06,341.08,767.86,363.71Z" />
              <path class="cls-6" d="M711.15,440.15c0-5.3-.11-10.6.09-15.89,0-1.06,0-3,1.86-3.07,1.16,0,1.94,1.17,2.48,2.24A80.35,80.35,0,0,1,724,456.71a106.54,106.54,0,0,1-6.79,42.5,92,92,0,0,1-24,35.39c-8.12,7.41-17.37,13.12-26.52,18.93-9,5.69-19.23,6.14-29.72,4.86-11.59-1.41-22,1.63-31.46,8.91-10.1,7.8-16.34,18-18.24,30.22-1.18,7.65-1.39,15.49-3.2,23.09-3.48,14.6-12.08,25.12-25.29,32.11-12.58,6.65-25.45,5.81-38.66,2.33-19.37-5.12-31.4-18.21-40.67-35.18a145.67,145.67,0,0,1-12.17-28.61c-5.51-18.7-9.09-37.8-5.27-57.3,3.55-18.14,13.26-31.45,31.7-37.36,5.74-1.84,10.88-5,17.35-5.08a200,200,0,0,1,30.68,1.54c9.51,1.29,19,2.94,28.38,4.93,8.34,1.77,16.51,4.32,24.81,6.36,15.86,3.88,31.45,9.27,47.74,11,15.62,1.66,30.57-.07,43.39-11,13.38-11.44,19.89-26,23-42.92C710.4,454.26,710.52,447.25,711.15,440.15Z" />
              <path class="cls-7" d="M525.85,706.33c-3.84-.57-6.92,2.34-10.52,2.34-12.43,0-24.86.82-37.21-2.14-8.08-1.93-16-4.21-23.83-6.93-6.7-2.32-9.82-8.16-12.86-13.34-5.08-8.67-13.41-11.64-21.74-14.17-13.6-4.13-27-1.66-39.73,4.23-6,2.8-10.78,7.61-15.84,11.88-7.1,6-15.77,10.69-24.33,11.75a45.65,45.65,0,0,1-31.65-7.48c-17.29-11.77-25.22-28.22-26.39-48.67-.46-8.13,2.2-15.6,3.77-23.31,1-4.68,2.66-9.2,3.84-13.84,2.07-8.15,7.37-14.81,10.33-22.46,4.14-10.68,12.28-18.46,19-27.07,4.78-6.1,12.12-10.48,19.33-14.35a47.79,47.79,0,0,1,30.68-5.43C379,539,388.2,543.65,396.92,550c15.39,11.18,25.4,26.62,35.18,42.08,8.36,13.21,16.39,26.72,24,40.46,6,10.94,12.4,21.82,21.58,30.68,3.29,3.18,5.4,7.45,9.37,10.13,9,6.09,18.44,9.64,29.81,9.79,13.7.18,26.47-2.68,37.3-10.06,10.53-7.17,21.51-14.27,29.76-24.44a7.73,7.73,0,0,1,2.17-2c1.08-.6,2-2.37,3.42-1.34,1.7,1.18.38,2.82-.08,4-4.26,11.21-12.2,20-19.8,28.88-5.07,5.94-11.21,10.77-17.34,15.6a55.39,55.39,0,0,1-17.76,9.57C531.61,704.33,529.28,707.19,525.85,706.33Z" />
              <path class="cls-6" d="M594.77,612.1c.34-15.4,6.25-26.78,17-36.5,13.28-12,28-10.62,42.84-5.69,20.32,6.74,27,21.05,28.75,39.84,1.14,12.16-4,23-13.11,31.93-8.36,8.19-17.63,13.45-29.39,12.85-9-.46-17.32-2.82-25-8.28-7.84-5.59-14.4-11.92-17.88-20.89C596.23,620.84,594.27,616.19,594.77,612.1Z" />
              <path class="cls-8" d="M447.84,725c1.5,25.56-22,43.74-46.21,43.15-22.71-.55-40.93-22.5-39.69-44.56,1.46-25.94,18.83-41.78,43.32-42.7C425.79,680.12,451,699.85,447.84,725Z" />
              <path class="cls-9" d="M598.6,584.86c-.57,1.3-.83,3-2.48,3.42-1,.25-1.28-.79-1.26-1.68a3.5,3.5,0,0,1,2.51-3.38C598.39,582.89,598.7,583.86,598.6,584.86Z" />
              <path class="cls-10" d="M265.77,590.69c-4.32,9.37-6.61,19.41-8.3,29.44-2.05,12.19-5.36,24.28-4.53,36.88.71,10.83,4.6,20.16,10.71,29.16a45.46,45.46,0,0,0,22.28,17.32A107.54,107.54,0,0,0,310.77,710c12.41,1.51,25,1.12,38.24,3.08a23.09,23.09,0,0,1-11.22,6.26c-12.64,2.44-25.26,5-38.37,4.66-20.82-.57-38.58-8.26-54.8-20.76-14.27-11-23.83-25.55-31.88-41.26-3.59-7-3.53-14.73-2.57-22.35,1.71-13.48-1-25.29-10.45-35.79-9.83-11-21.83-15.95-36.15-17.08-12.23-1-24.25-2.66-34.57-10.66a44.83,44.83,0,0,1-13.64-17.82c-3.33-7.56-5.53-15.7-4.44-24.15,1.61-12.48,5.67-23.82,13.63-34,7-9,15.79-15.57,25.19-21.29,9-5.49,19-9,29.23-11.93a146.49,146.49,0,0,1,49.19-5c9.25.56,17.63,3.77,25.48,9,16.83,11.14,22.95,27.33,23.34,46.6.29,14-1.54,27.69-4.33,41.42-2.17,10.67-6.15,21-6.91,31.91Z" />
              <path class="cls-11" d="M120.88,584.76l7,6.1c-2.36,2.5-4,1.16-5.3.6-28.46-12.42-49.17-32.4-59.31-62.2-5.14-15.12-4.48-30.7-1.94-46.25,1.58-9.71,4.68-18.95,7.9-28.21,1.74-5,5.79-7.24,9.46-9.82,18.56-13.12,28.48-41.74,11.81-65.29-4.22-6-8.34-12-12.63-17.9-10.37-14.28-12.82-29.54-6-46,5.44-11.62,13.26-21.19,25-26.76,14.61-6.93,30.19-8.06,45.78-4.77,28.63,6.06,53.56,19.43,73.79,40.73,18.13,19.08,21.58,46.69,4.83,69.63-10.16,13.92-23.35,24.34-37.51,33.73-7.75,5.14-15.79,9.8-23.82,14.49h0c-10.89,6-21.92,11.88-32.31,18.73-12.43,8.2-24.68,16.7-33.42,29.28-9.84,14.18-11.39,29.34-6.44,45.52,3.82,12.46,11.12,22.87,19.09,33C111.15,574.79,116.41,579.41,120.88,584.76Z" />
              <path class="cls-10" d="M160.73,596.74c26.46-.84,40.85,20.39,41.46,38.7,1,29.58-18.91,46.07-37.81,47.9-30.82,3-51.22-19-50.49-47C114.42,615.71,135.34,596,160.73,596.74Z" />
              <path class="cls-12" d="M44.35,448.88C19.86,448.33-.25,431.61,0,404.44c.23-24.82,19.94-42,46-42.54,24.26-.5,41.72,19.94,41.84,44.63C87.94,431.72,70,449,44.35,448.88Z" />
              <path class="cls-13" d="M63.9,289.82C58.14,303.48,58,318,57.69,332.4c-.12,5.15-.52,10.29-.82,15.43-.06.95.16,2.21-1,2.58-1.73.53-1.74-1.14-2.16-2.08a96,96,0,0,1-8.33-31.13c-1.35-15.32-1.24-30.64,4.07-45.38,7-19.44,19.74-34.45,36.64-46,7.79-5.32,15.44-10.89,24.49-14.22a26.08,26.08,0,0,1,14.62-1c18.38,3.57,37.25-2.5,47.54-19.44,5.49-9,7.87-19.35,9.13-29.82,1.2-10,3.08-19.72,8.57-28.38,9.92-15.64,29.73-23.9,48.41-21.08,14,2.12,26.23,7.52,36,17.67s16.71,22.28,21.91,35.37A72.38,72.38,0,0,1,301,177.74c6.18,19.32,9.21,38.91,5,59.11l0,0c-2.56,12.72-8.92,22.93-20,30l0,0c-14.26,10.59-30.66,11.69-47.53,10.67-27.7-1.67-54.12-9.62-80.73-16.59-12.18-3.19-24.39-6.56-36.93-7.52a57.13,57.13,0,0,0-30.79,6.38v0C77,266.12,69.81,277.44,63.9,289.82Z" />
              <path class="cls-13" d="M128.34,114.7c30.8,2.82,45.19,22.73,44.24,49.63-.65,18.27-21.13,41.39-46.16,39.3-23.77-2-43.57-24.66-41.31-49.33C87.38,129.39,105.07,115.93,128.34,114.7Z" />
              <path class="cls-14" d="M306,236.85c.8-6.55.82-13.14,1-19.73.37-12.37-2.36-24.2-5.5-36a29.12,29.12,0,0,1-.5-3.37c3.33,3.61,3.5,8.52,4.42,12.83,2.15,10.15,3.9,20.48,3.39,30.94C308.52,226.69,308.69,232.07,306,236.85Z" />
            </g>
          </g>
        </svg>
      </picture>
      <h2>Magusa Arcoiris</h2>
      <nav>
        <ul class="menu">
          <li id="li-hoy" onclick="abrirformHoy()" class="activo">
            <a href="javascript:void(0)">Hoy</a>
          </li>
          <?php if ($cargo == 1 || $cargo == 4) { ?>
            <li id="li-citas" onclick="abrirformCitas()" class="activo">
              <a href="javascript:void(0)">Citas</a>
            </li>
          <?php } ?>
          <li id="li-pacientes" onclick="abrirformPacientes()">
            <a href="javascript:void(0)">Pacientes</a>
          </li>
          <?php if ($cargo == 1 || $cargo == 4) { ?>
            <li id="li-atenciones" onclick="abrirformAtenciones()">
              <a href="javascript:void(0)">Atenciones</a>
            </li>
            <li id="li-caja" onclick="abrirformCaja()">
              <a href="javascript:void(0)">Caja</a>
            </li>
            <li id="li-procedimientos" onclick="abrirProcedimientos()">
              <a href="javascript:void(0)">Procedimientos</a>
            </li>
            <li id="li-usuarios" onclick="abrirUsuarios()">
              <a href="javascript:void(0)">Usuarios</a>
            </li>
          <?php } ?>
          <?php if ($cargo == 1) { ?>
            <li id="li-reportes" onclick="abrirReportes()">
              <a href="javascript:void(0)">Reportes</a>
            </li>
          <?php } ?>
          <?php if ($cargo == 1 || $cargo == 4) { ?>
            <!-- <li id="li-externos" onclick="abrirExternos()">
              <a href="javascript:void(0)">Proc. Externos</a>
            </li>
            <li id="li-medicamentos" onclick="abrirMedicamentos()">
              <a href="javascript:void(0)">Medicamentos e Insumos</a>
            </li> -->
            <li id="li-pendientes" onclick="abrirPendientes()">
              <a href="javascript:void(0)">P.Pendientes</a>
            </li>
          <?php } ?>
          <li id="li-cambiarpass" onclick="abrirCambioPass(<?php echo $_SESSION['iduser']; ?>)">
            <a href="javascript:void(0)">Cambiar Contraseña</a>
          </li>
        </ul>
      </nav>
    </aside>
    <div id="contenido" class="contenido">
      <!-- HOY - AJAX -->
    </div>
  </div>
  <script src="recursos/js/functions.js"></script>
  <script src="recursos/js/main.js"></script>
  <script>
    abrirformHoy()
    verificarcajaabierta()
    fechanac.max = new Date().toISOString().split('T')[0]
    FechaCita.min = new Date().toISOString().split('T')[0]
    KardexDesde.max = new Date().toISOString().split('T')[0]
    KardexHasta.max = new Date().toISOString().split('T')[0]
    //HoraCita.min = new TimeRanges()

    var items = <?= json_encode($array) ?>;
    $("#MovitoCita").autocomplete({
      source: items,
      select: function(event, item) {
        filtro = item.item.value;
        $.ajax({
            method: "POST",
            url: 'sistema/controlador/controlador.php',
            data: {
              "accion": "OBTENER_PROC_NOMBRE",
              "filtro": filtro
            }
          })
          .done(function(resultado) {
            json = JSON.parse(resultado);
            tipo_atencion = json.tipo_atencion;
            $("#IdMovitoCita").val(tipo_atencion[0].idtipoatencion);
            $("#PrecioMotivoCita").val(tipo_atencion[0].precio);
          });
      }
    });
    $("#MovitoCitaExterna").autocomplete({
      source: items,
      select: function(event, item) {
        filtro = item.item.value;
        $.ajax({
            method: "POST",
            url: 'sistema/controlador/controlador.php',
            data: {
              "accion": "OBTENER_PROC_NOMBRE",
              "filtro": filtro
            }
          })
          .done(function(resultado) {
            json = JSON.parse(resultado);
            tipo_atencion = json.tipo_atencion;
            $("#IdMovitoCitaExterna").val(tipo_atencion[0].idtipoatencion);
          });
      }
    });
    var medicamentos = <?= json_encode($medicamentos) ?>;
    $("#NombreMedicamento_Trat").autocomplete({
      source: medicamentos,
      select: function(event, item) {
        filtro = item.item.value;
        $.ajax({
            method: "POST",
            url: 'sistema/controlador/controlador.php',
            data: {
              "accion": "OBTENER_MEDICAMENTO_NOMBRE",
              "filtro": filtro
            }
          })
          .done(function(resultado) {
            json = JSON.parse(resultado);
            medicamento = json.medicamento;
            console.log(resultado)
            $("#idmedicamento").val(medicamento[0].idmedicina);
          });
      }
    });
    var productos = <?= json_encode($productos) ?>;
    $("#NombreProducto").autocomplete({
      source: productos,
      select: function(event, item) {
        filtro = item.item.value;
        $.ajax({
            method: "POST",
            url: 'sistema/controlador/controlador.php',
            data: {
              "accion": "OBTENER_MEDICAMENTO_NOMBRE",
              "filtro": filtro
            }
          })
          .done(function(resultado) {
            json = JSON.parse(resultado);
            medicamento = json.medicamento;
            console.log(resultado)
            $("#IdProducto").val(medicamento[0].idmedicina);
            $("#StockProducto").val(medicamento[0].stock);
          });
      }
    });
    $("#NombreProductoKardex").autocomplete({
      source: productos,
      select: function(event, item) {
        filtro = item.item.value;
        $.ajax({
            method: "POST",
            url: 'sistema/controlador/controlador.php',
            data: {
              "accion": "OBTENER_MEDICAMENTO_NOMBRE",
              "filtro": filtro
            }
          })
          .done(function(resultado) {
            json = JSON.parse(resultado);
            medicamento = json.medicamento;
            console.log(resultado)
            $("#IdProductoKardex").val(medicamento[0].idmedicina);
            $("#lblstockactual").html('Stock Actual : ' + medicamento[0].stock)

          });
      }
    });

    function AgregarCarrito() {
      codigo = $("#idmedicamento").val()
      medicamento = $("#NombreMedicamento_Trat").val()
      indicacion = $("#IndicacionTratamiento").val()
      if (codigo === '') {
        alert("SELECCIONE UN MEDICAMENTO")
      } else {
        $.ajax({
            method: "POST",
            url: 'sistema/controlador/controlador.php',
            data: {
              "accion": "AGREGAR_CARRITO",
              "codigo": codigo,
              "medicamento": medicamento,
              "indicacion": indicacion
            }
          })
          .done(function(html) {
            $("#tbTratamiento").html(html)
            $("#idmedicamento").val('')
            $("#NombreMedicamento_Trat").val('')
            $("#IndicacionTratamiento").val('')
          });
      }
    }

    function QuitarCarrito(codigo) {
      $.ajax({
          method: "POST",
          url: 'sistema/controlador/controlador.php',
          data: {
            "accion": "QUITAR_CARRITO",
            "codigo": codigo
          }
        })
        .done(function(html) {
          $("#tbTratamiento").html(html);
        });
    }

    function RegistrarTratamiento() {
      $('#btnregistrarTratamiento').prop('disabled', true)
      datax = $('#frmRegistrarTratamiento').serializeArray()
      $.ajax({
        method: 'POST',
        url: 'sistema/controlador/controlador.php',
        data: datax,
      }).done(function(respuesta) {
        console.log(respuesta)
        if (respuesta === 'SE REGISTRÓ TRATAMIENTO') {
          Swal.fire('SE REGISTRÓ CORRECTAMENTE', 'se ha registrado la atención y tratamiento', 'success')
          idatencion = $('#idatencion_trat').val()
          generarPDF(idatencion)
          cerrarmodal()
          CancelarTratamiento()

        } else {
          Swal.fire('Ocurrió un error', respuesta, 'error')
        }
        $('#btnregistrarTratamiento').prop('disabled', false)
      })
    }

    function imprimirticket($idcita) {
      $.ajax({
          method: "POST",
          url: 'recursos/impresionticket/ticket.php',
          data: {
            "idcita": $idcita
          }
        })
        .done(function(respuesta) {
          if (respuesta === 1) {
            console.log('Imprimiendo....');
          } else {
            console.log('Error');
          }
        });
    }
    var keep_alive = false;
    $(document).bind("click keydown keyup mousemove", function() {
      keep_alive = true;
    });
    setInterval(function() {
      if (keep_alive) {
        pingServer();
        keep_alive = false;
      }
    }, 1200000);

    function pingServer() {
      $.ajax('/keepAlive');
    }
  </script>
</body>

</html>