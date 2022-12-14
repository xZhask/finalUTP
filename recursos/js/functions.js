function remove_addClass(contenedor, link) {
  $(contenedor + " .activo").removeClass("activo");
  $(link).addClass("activo");
}
function abrir_form(div, contenido) {
  $.ajax({
    method: "POST",
    url: "formularios/" + contenido,
  }).done(function (html) {
    $(div).html(html);
  });
}
const abrirformHoy = () => {
  ValidarSesion("#contenido", "hoy.php", ".menu", "#li-hoy");
};
const abrirformCitas = () => {
  ValidarSesion("#contenido", "citas.php", ".menu", "#li-citas");
};
const abrirformPacientes = () => {
  ValidarSesion("#contenido", "pacientes.php", ".menu", "#li-pacientes");
};
const abrirformAtenciones = () => {
  ValidarSesion("#contenido", "atenciones.php", ".menu", "#li-atenciones");
};
const abrirformCaja = () => {
  ValidarSesion("#contenido", "caja.html", ".menu", "#li-caja");
};
const abrirUsuarios = () => {
  ValidarSesion("#contenido", "usuarios.php", ".menu", "#li-usuarios");
};
const abrirProcedimientos = () => {
  ValidarSesion(
    "#contenido",
    "procedimientos.html",
    ".menu",
    "#li-procedimientos"
  );
};
const abrirReportes = () => {
  ValidarSesion("#contenido", "reportes.html", ".menu", "#li-reportes");
};
const abrirExternos = () => {
  ValidarSesion("#contenido", "externos.php", ".menu", "#li-externos");
};
const abrirMedicamentos = () => {
  ValidarSesion("#contenido", "medicamentos.php", ".menu", "#li-medicamentos");
};
const abrirPendientes = () => {
  ValidarSesion("#contenido", "pagospendientes.php", ".menu", "#li-pendientes");
};
/* MODAL */
const abrirRegistrarCita = () => {
  AbrirModal("#frmregistrarcita");
  $("#AccionCita").val("REGISTRAR_CITA");
  ValidarSesion2();
};
const abrirRegistrarPaciente = () => {
  AbrirModal("#frmregistrarpaciente");
  $("#AccionPaciente").val("REGISTRAR_PACIENTE");
};
const abrirRegistrarPago = () => {
  AbrirModal("#frmregistrarpago");
};
const abrirAperturarCaja = () => {
  AbrirModal("#frmraperturarcaja");
};
const abrirRegistroCargo = () => {
  AbrirModal("#frmregistrarcargo");
};
const abrirRegistroEstablecimiento = () => {
  AbrirModal("#frmregistrarEstablecimiento");
};
const abrirRegistroGasto = () => {
  AbrirModal("#frmRegistrarGasto");
};
const abrirRegistroSignosVitales = () => {
  AbrirModal("#frmRegistrarSignosV");
};
const abrirRegistroCitaExterna = () => {
  AbrirModal("#frmregistrarcita_externa");
};
const abrirRegistroTratamiento = () => {
  AbrirModal("#frmRegistrarTratamiento");
};
const abrirKardex = () => {
  AbrirModal("#frmKardex");
};
const abrirBuscarCita = () => {
  AbrirModal("#frmBuscarCitas");
};
const abrirCambioPass = (idusuario) => {
  $("#IdUsuario").val(idusuario);
  AbrirModal("#frmCambioPass");
};
const abrirRegistroProcedimiento = () => {
  AbrirModal("#frmRegistrarProcedimiento");
  $("#AccionProcedimiento").val("REGISTRAR_PROCEDIMIENTO");
};
const abrirHistorial = () => {
  AbrirModal("#frmHistorial");
  $(".modal").addClass("w100");
  $(".bg-dark").addClass("all");
};
const abrirRegistroUsuario = () => {
  AbrirModal("#frmregistrarusuario");
  $("#AccionUsuario").val("REGISTRAR_USUARIO");
  $("#Pass").css("display", "block");
};
const abrirRegistroMovimientoAlmacen = () => {
  AbrirModal("#frmRegistrarProducto");
};
const abrirRegistrarAtencion = () => {
  AbrirModal("#frmRegistrarAtencion");
  $(".modal").addClass("w100");
  $(".bg-dark").addClass("all");
};
function AbrirModal(idform) {
  $(".bg-dark").addClass("activo");
  $(".modal").addClass("activo");
  $(".modal form").removeClass("activo");
  $("html, body").animate({ scrollTop: 0 }, "slow");
  $(idform).addClass("activo");
}
function cerrarmodal() {
  $(".bg-dark").removeClass("activo");
  $(".modal").removeClass("w100");
  $(".bg-dark").removeClass("all");
  limpiar();
  $(".modal").removeClass("green");
  $(".modal").removeClass("red");
  $(".modal").removeClass("ambar");
}
function MostrarInputs() {
  $(".cont-input-toggle").addClass("visible");
}
function OcultarInputs() {
  $(".cont-input-toggle").removeClass("visible");
}
function LimpiarInputsCita() {
  $("#NombrePacienteCita").val("");
  $("#ApellidosPacienteCita").val("");
  $("#FechaNacCita").val("");
}
/* OTRAS FUNCIONES */
function DesahabilitarBoton(boton) {
  $(boton).prop("readonly", "readonly");
  $(boton).addClass("textdisabled");
}
function HabilitarBoton(boton) {
  $(boton).prop("readonly", false);
  $(boton).removeClass("textdisabled");
}

//RESET
function limpiar() {
  document.getElementById("frmregistrarusuario").reset();
  document.getElementById("frmregistrarcargo").reset();
  document.getElementById("frmregistrarEstablecimiento").reset();
  document.getElementById("frmregistrarpaciente").reset();
  document.getElementById("frmregistrarcita").reset();
  document.getElementById("frmregistrarpago").reset();
  document.getElementById("frmRegistrarSignosV").reset();
  document.getElementById("frmRegistrarAtencion").reset();
  document.getElementById("frmRegistrarProcedimiento").reset();
  document.getElementById("frmHistorial").reset();
  document.getElementById("frmregistrarcita_externa").reset();
  document.getElementById("frmRegistrarTratamiento").reset();
  document.getElementById("frmRegistrarProducto").reset();
  document.getElementById("frmKardex").reset();
  document.getElementById("frmBuscarCitas").reset();
  document.getElementById("frmCambioPass").reset();

  HabilitarBoton("#NroDocPersonal");
  HabilitarBoton("#NroDocPaciente");

  $(".cont-input-toggle").removeClass("visible");
  CancelarTratamiento();
  $(".consulta_historia").removeClass("examen");
  $(".consulta_historia").removeClass("consulta");
  $("#cont-examen").html("");
  $("#tbKardex").html("");
  $("#lblstockactual").html("Stock Actual : ");
  $("#tbBusquedaCitas").html("");
  $("#lblNombreBuscarCitas").html("Paciente : ");
  $("#Pass").css("display", "block");
}
/* LISTADOS */
const ajaxFunction = (data) => {
  let respuesta;
  $.ajax({
    type: "POST",
    url: "sistema/controlador/controlador.php",
    data: data,
    async: false,
    //dataType: 'JSON',
    error: function () {
      alert("Error occured");
    },
    success: function (response) {
      respuesta = response;
    },
  });
  return respuesta;
};
/* VALIDACIÓN */
$("#frmlogin").on("submit", function (e) {
  e.preventDefault();
  let datax = $("#frmlogin").serializeArray();
  let data = datax;
  let llamadoAjax = ajaxFunction(data);
  if (llamadoAjax == "INICIO") window.location.assign("index.php");
  else alert("DATOS INCORRECTOS");
});
$("#btn-off").on("click", function () {
  let data = { accion: "LOGOUT" };
  let llamadoAjax = ajaxFunction(data);
  if (llamadoAjax == 1) window.location.assign("login.php");
});
function ListarPersonal() {
  let usuario = $("#searchUsuario").val();
  let data = { accion: "LISTAR_PERSONAL", filtro: usuario };
  let llamadoAjax = ajaxFunction(data);
  $("#tbUsuarios").html(llamadoAjax);
}

function ListarCargos() {
  let data = { accion: "LISTAR_CARGOS" };
  let llamadoAjax = ajaxFunction(data);
  $("#idcargo").html(llamadoAjax);
}
function CargarEstablecimientos() {
  let data = { accion: "CARGAR_ESTABLECIMIENTOS" };
  let llamadoAjax = ajaxFunction(data);
  $(".establecimiento").html(llamadoAjax);
}
function ListarPacientes() {
  let data = { accion: "LISTAR_PACIENTES", filtro: "" };
  let llamadoAjax = ajaxFunction(data);
  $("#tbPacientes").html(llamadoAjax);
}
function ListarMedicamentos() {
  let filtro = $("#filtroProducto").val();
  let data = { accion: "LISTAR_MEDICAMENTOS", filtro: filtro };
  let llamadoAjax = ajaxFunction(data);
  $("#tbMedicamentos").html(llamadoAjax);
}
function ListarInsumos() {
  let data = { accion: "LISTAR_INSUMOS" };
  let llamadoAjax = ajaxFunction(data);
  $("#tbInsumos").html(llamadoAjax);
}
function ListarPendientes() {
  let data = { accion: "LISTAR_PENDIENTES" };
  let llamadoAjax = ajaxFunction(data);
  $("#tbPendientes").html(llamadoAjax);
}
function ListarProcedimientos() {
  let data = { accion: "LISTAR_PROCEDIMIENTOS", filtro: "" };
  let llamadoAjax = ajaxFunction(data);
  $("#tbProcedimientos").html(llamadoAjax);
}
function ListarCitas() {
  fecha = $("#FechaCitados").val();
  let data = { accion: "LISTAR_CITAS", fecha: fecha };
  let llamadoAjax = ajaxFunction(data);
  $("#tbCitas").html(llamadoAjax);
}
function ListarConfirmados() {
  let data = { accion: "LISTAR_CITAS_CONFIRMADAS" };
  let llamadoAjax = ajaxFunction(data);
  $("#tbConfirmados").html(llamadoAjax);
}
function ListarAtenciones() {
  fecha = $("#fechaAtenciones").val();
  let data = { accion: "LISTAR_ATENCIONES", fecha: fecha };
  let llamadoAjax = ajaxFunction(data);
  $("#tbAtenciones").html(llamadoAjax);
}
function listargastos() {
  let idcajadiaria = $("#idcajadiaria").val();
  let data = { accion: "LISTAR_GASTOS", idcajadiaria: idcajadiaria };
  let llamadoAjax = ajaxFunction(data);
  $("#tbgastoscaja").html(llamadoAjax);
}
function listarmontoscaja() {
  let data = {
    accion: "LISTAR_MONTOS",
    idcajadiaria: $("#idcajadiaria").val(),
  };
  let llamadoAjax = ajaxFunction(data);
  $("#tbmontoscaja").html(llamadoAjax);
}
function listarultimosingresos() {
  let data = {
    accion: "LISTAR_ULTIMOS_INGRESOS",
    idcajadiaria: $("#idcajadiaria").val(),
  };
  let llamadoAjax = ajaxFunction(data);
  $("#tbingresoscaja").html(llamadoAjax);
}
function ObtenerCitas() {
  let dni = $("#NroDocBuscarCita").val();
  let data = { accion: "OBTENER_DATOS_PACIENTE", dni: dni };
  let llamadoAjax = ajaxFunction(data);
  json = JSON.parse(llamadoAjax);
  paciente = json.paciente;
  $("#lblNombreBuscarCitas").html(
    `Paciente : ${paciente[0].apellidos}, ${paciente[0].nombre}`
  );
  data = { accion: "BUSCAR_CITAS", dni: dni };
  llamadoAjax = ajaxFunction(data);
  $("#tbBusquedaCitas").html(llamadoAjax);
}
function ListarAtencionesPorPaciente(dni) {
  let data = { accion: "LISTAR_ATENCIONES_PACIENTE", dni: dni };
  let llamadoAjax = ajaxFunction(data);
  $("#ul-atenciones").html(llamadoAjax);
}
function ListarOtrosExamenes(dni) {
  let data = { accion: "LISTAR_OTROS_EXAMENES", dni: dni };
  let llamadoAjax = ajaxFunction(data);
  $("#ul-otrosexamenes").html(llamadoAjax);
}
function Kardex() {
  let idproducto = $("#IdProductoKardex").val();
  let fecha1 = $("#KardexDesde").val();
  let fecha2 = $("#KardexHasta").val();
  let data = {
    accion: "KARDEX",
    idproducto: idproducto,
    fecha1: fecha1,
    fecha2: fecha2,
  };
  let llamadoAjax = ajaxFunction(data);
  $("#tbKardex").html(llamadoAjax);
}
/*--------------- FILTROS Y BÚSQUEDAS ------------------ */
function BuscarPersonaPersonal() {
  dni = $("#NroDocPersonal").val();
  ObtenerDatosDni(dni, "PERSONAL");
}
function BuscarPersonaPaciente() {
  dni = $("#NroDocPaciente").val();
  ObtenerDatosDni(dni, "PACIENTE");
}

function ObtenerDatosDni(nro_doc, tipo_persona) {
  let data = { accion: "CONSULTA_DNI", dni: nro_doc };
  let llamadoAjax = ajaxFunction(data);
  let json = JSON.parse(llamadoAjax);
  if (tipo_persona == "PERSONAL") {
    $("#NombrePersonal").val(json["data"].nombres);
    $("#ApellidosPersonal").val(
      json["data"].apellido_paterno + " " + json["data"].apellido_materno
    );
  } else if (tipo_persona == "PACIENTE") {
    bloquearControlsPaciente();
    $("#menorPaciente").prop("checked", false);
    if (json["success"] == false) {
      $("#checkPaciente").addClass("visible");
    } else if (json["success"] == true) {
      $("#checkPaciente").removeClass("visible");
      $("#NombrePaciente").val(json["data"].nombres);
      $("#ApellidosPaciente").val(
        json["data"].apellido_paterno + " " + json["data"].apellido_materno
      );
      $fechanac = json["data"].fecha_nacimiento;
      if ($fechanac !== null) {
        $("#fechanac").val($fechanac);
      } else {
        $("#fechanac").val("");
      }
    }
  }
}
function FiltrarPaciente() {
  filtro = $("#FiltroPaciente").val();
  let data = { accion: "LISTAR_PACIENTES", filtro: filtro };
  let llamadoAjax = ajaxFunction(data);
  $("#tbPacientes").html(llamadoAjax);
}
function FiltrarProcedimiento() {
  filtro = $("#FiltroProcedimiento").val();
  let data = { accion: "LISTAR_PACIENTES", filtro: filtro };
  let llamadoAjax = ajaxFunction(data);
  $("#tbProcedimientos").html(llamadoAjax);
}
function ObtenerDatosPaciente() {
  let dni = $("#NroDocCita").val();
  LimpiarInputsCita();
  bloquearControlsCita();
  $("#menor").prop("checked", false);
  $("#NombrePacienteC").val("");
  $.ajax({
    method: "POST",
    url: "sistema/controlador/controlador.php",
    data: {
      accion: "OBTENER_DATOS_PACIENTE",
      dni: dni,
    },
  }).done(function (respuesta) {
    if (respuesta == "NO REGISTRADO") {
      $.ajax({
        method: "POST",
        url: "sistema/controlador/controlador.php",
        data: {
          accion: "CONSULTA_DNI",
          dni: dni,
        },
      }).done(function (text) {
        let json = JSON.parse(text);
        $("#TipoPaciente").val("NOREG");
        if (json["success"] == false) $("#checkCita").addClass("visible");
        else if (json["success"] == true) {
          $("#NombrePacienteC").val(json["data"].nombre_completo);
          $("#NombrePacienteCita").val(json["data"].nombres);
          $("#ApellidosPacienteCita").val(
            `${json["data"].apellido_paterno} ${json["data"].apellido_materno}`
          );
          let fechanac = json["data"].fecha_nacimiento;
          fechanac = fechanac !== null ? fechanac : "";
          $("#FechaNacCita").val(fechanac);
          $("#checkCita").removeClass("visible");
        }
        MostrarInputs();
      });
    } else {
      let json = JSON.parse(respuesta);
      let paciente = json.paciente;
      $("#TipoPaciente").val("REG");
      $("#NombrePacienteC").val(
        paciente[0].apellidos + ", " + paciente[0].nombre
      );
      $("#NroCelularCita").val(paciente[0].telefono);
      OcultarInputs();
      $("#checkCita").removeClass("visible");
    }
  });
}
function validar_menor() {
  LimpiarInputsCita();
  if (document.getElementById("menor").checked) desbloquearControlsCita();
  else bloquearControlsCita();
}
function validar_menorPaciente() {
  $("#NombrePaciente").val("");
  $("#ApellidosPaciente").val("");
  if (document.getElementById("menorPaciente").checked)
    desbloquearControlsPaciente();
  else bloquearControlsPaciente();
}
function desbloquearControlsCita() {
  $("#NombrePacienteCita").prop("readonly", false);
  $("#ApellidosPacienteCita").prop("readonly", false);
  $("#NombrePacienteCita").removeClass("textdisabled");
  $("#ApellidosPacienteCita").removeClass("textdisabled");
}
function bloquearControlsCita() {
  $("#NombrePacienteCita").prop("readonly", true);
  $("#ApellidosPacienteCita").prop("readonly", true);
  $("#NombrePacienteCita").addClass("textdisabled");
  $("#ApellidosPacienteCita").addClass("textdisabled");
}
function desbloquearControlsPaciente() {
  $("#NombrePaciente").prop("readonly", false);
  $("#ApellidosPaciente").prop("readonly", false);
  $("#NombrePaciente").removeClass("textdisabled");
  $("#ApellidosPaciente").removeClass("textdisabled");
}
function bloquearControlsPaciente() {
  $("#NombrePaciente").prop("readonly", true);
  $("#ApellidosPaciente").prop("readonly", true);
  $("#NombrePaciente").addClass("textdisabled");
  $("#ApellidosPaciente").addClass("textdisabled");
  $("#NombrePaciente").val("");
  $("#ApellidosPaciente").val("");
}
/* REGISTROS */
//Personal
function RegistrarPersonal() {
  let datax = $("#frmregistrarusuario").serializeArray();
  let llamadoAjax = ajaxFunction(datax);
  alert(llamadoAjax);
  ListarPersonal();
  limpiar();
  cerrarmodal();
}
function RegistrarCargo() {
  cargo = $("#NombreCargo").val();
  let data = { accion: "REGISTRAR_CARGO", cargo: cargo };
  let llamadoAjax = ajaxFunction(data);
  alert(llamadoAjax);
  ListarCargos();
  limpiar();
  cerrarmodal();
}
function RegistrarEstablecimiento() {
  let establecimiento = $("#NombreEstablecimiento").val();
  let data = {
    accion: "REGISTRAR_ESTABLECIMIENTO",
    establecimiento: establecimiento,
  };
  let llamadoAjax = ajaxFunction(data);
  alert(llamadoAjax);
  CargarEstablecimientos();
  cerrarmodal();
}
$(function () {
  $(document).on("click", "#tbUsuarios .edit-usuario", function (e) {
    e.preventDefault();
    let parent = $(this).closest("table");
    let tr = $(this).closest("tr");
    let codigo = $(tr).find("td").eq(0).html();
    $("#NroDocPersonal").val(codigo);
    DesahabilitarBoton("#NroDocPersonal");
    let data = { accion: "OBTENER_DATOS_PERSONAL", dni: codigo };
    let llamadoAjax = ajaxFunction(data);
    let json = JSON.parse(llamadoAjax);
    let usuario = json.usuario;
    $("#NombrePersonal").val(usuario[0].nombre);
    $("#ApellidosPersonal").val(usuario[0].apellidos);
    $("#Nick").val(usuario[0].nick);
    $("#idcargo").val(usuario[0].idcargo);
    $("#EstadoUsuario").val(usuario[0].estado);
    $("#AccionUsuario").val("ACTUALIZAR_USUARIO");
    abrirRegistroUsuario();
    $("#Pass").css("display", "none");
  });
});
//Pacientes
function RegistrarPaciente() {
  let datax = $("#frmregistrarpaciente").serializeArray();
  let llamadoAjax = ajaxFunction(datax);
  alert(llamadoAjax);
  ListarPacientes();
  limpiar();
  cerrarmodal();
}

$(function () {
  $(document).on("click", "#tbPacientes .edit-paciente", function (event) {
    event.preventDefault();
    let parent = $(this).closest("table");
    let tr = $(this).closest("tr");
    let codigo = $(tr).find("td").eq(0).html();
    let data = { accion: "OBTENER_DATOS_PACIENTE", dni: codigo };
    $("#NroDocPaciente").val(codigo);
    DesahabilitarBoton("#NroDocPaciente");
    let llamadoAjax = ajaxFunction(data);
    json = JSON.parse(llamadoAjax);
    paciente = json.paciente;
    $("#NombrePaciente").val(paciente[0].nombre);
    $("#ApellidosPaciente").val(paciente[0].apellidos);
    $("#NroCelular").val(paciente[0].telefono);
    $("#fechanac").val(paciente[0].fecha_nac);
    $("#AccionPaciente").val("ACTUALIZAR_PACIENTE");
    abrirRegistrarPaciente();
  });
});

function RegistrarCita() {
  if ($("#TipoPaciente").val() == "NOREG" && $("#FechaNacCita").val() == "") {
    alert("Ingrese Fecha de Nacimiento");
  } else {
    if ($("#FechaCita").val() == "" || $("#HoraCita").val() == "") {
      alert("INGRESE FECHA Y HORA DE CITA");
    } else {
      let datax = $("#frmregistrarcita").serializeArray();
      let llamadoAjax = ajaxFunction(datax);
      $("#IdCita").val(llamadoAjax);
      $("#frmregistrarcita").removeClass("activo");
      $("#frmEleccionPago").addClass("activo");
      ListarCitas();
    }
  }
}
function MostrarPagar() {
  $("#frmEleccionPago").removeClass("activo");
  $("#frmregistrarpago").addClass("activo");
  let idcita = $("#IdCita").val();
  let data = { accion: "OBTENER_DATOS_CITA", idcita: idcita };
  let llamadoAjax = ajaxFunction(data);
  let json = JSON.parse(llamadoAjax);
  let cita = json.cita;
  $("#NombrePago").val(
    cita[0].apellidospaciente + ", " + cita[0].nombrepaciente
  );
  $("#MotivoPago").val(cita[0].motivo);

  if (cita[0].estado === "A CUENTA")
    MostrarPagarCuenta(cita[0].precio_consulta);
  else {
    $("#PrecioPago").val(cita[0].precio_consulta);
    $("#ACuentaPago").val(cita[0].precio_consulta);
  }
}
//
function MostrarPagarCuenta(MontoTotal) {
  $("#frmregistrarpago").addClass("activo");
  $("#PrecioPago").val("");
  $("#ACuentaPago").val("");
  let idcita = $("#IdCita").val();
  let data = { accion: "OBTENER_MOVIMIENTO_CUENTA", idcita: idcita };
  let llamadoAjax = ajaxFunction(data);
  let monto = MontoTotal - llamadoAjax;
  $("#PrecioPago").val(monto);
  $("#ACuentaPago").val(monto);
}

function aperturarcaja() {
  let monto = $("#MontoInicial").val();
  if (monto === "") alert("INGRESE MONTO INICIAL");
  else {
    $("#btnaperturarcaja").prop("disabled", true);
    let data = {
      accion: "APERTURAR_CAJA",
      montoinicial: monto,
      tipo_movimiento: "APERTURA",
      descripcion: "APERTURA CAJA",
    };
    let llamadoAjax = ajaxFunction(data);
    verificarcajaabierta();
    verificarcaja();
    $("#btnaperturarcaja").prop("disabled", false);
    cerrarmodal();
  }
}
function cerrarcaja() {
  let data = {
    accion: "CERRAR_CAJA",
    idcajadiaria: $("#idcajadiaria").val(),
    montocierre: $("#totalcaja").html(),
  };
  let llamadoAjax = ajaxFunction(data);
  $("#fecha_inicio_caja").html("");
  verificarcaja();
  verificarcajaabierta();
  cerrarmodal();
}
function RegistrarPago() {
  if ($("#tipopago").val() == "0") alert("SELECCIONE TIPO DE PAGO");
  else {
    datax = $("#frmregistrarpago").serializeArray();
    let llamadoAjax = ajaxFunction(datax);
    generarticketPDF(llamadoAjax);
    ListarCitas();
    cerrarmodal();
  }
}
function verificarcajaabierta() {
  let data = { accion: "VERIFICAR_CAJA" };
  let llamadoAjax = ajaxFunction(data);
  let tipo = llamadoAjax === "SIN REGISTRO" ? true : false;
  if (llamadoAjax === "SIN REGISTRO") {
    $("#btnsi_mostrarpago").addClass("btndisabled");
    $("#btn-regPago").addClass("btndisabled");
  } else {
    $("#btnsi_mostrarpago").removeClass("btndisabled");
    $("#btn-regPago").removeClass("btndisabled");
  }
  $("#btnsi_mostrarpago").prop("disabled", tipo);
  $("#btn-regPago").prop("disabled", tipo);
}
function verificarcaja() {
  let llamadoAjax = ajaxFunction({ accion: "VERIFICAR_CAJA" });
  if (llamadoAjax === "SIN REGISTRO") {
    $("#fecha_inicio_caja").html("");
    $("#btncerrarcaja").removeClass("btnhabilitado");
    $("#btncerrarcaja").addClass("btndisabled");
    $("#btncerrarcaja").prop("disabled", true);

    $("#btnaperturarcaja").prop("disabled", false);
    $("#btnaperturarcaja").removeClass("btndisabled");
    $("#btnaperturarcaja").addClass("btnhabilitado");
    $(".cont_tablas_caja").css("display", "none");
    $(".cont_caja_cerrada").css("display", "block");
  } else {
    json = JSON.parse(llamadoAjax);
    datoscaja = json.datoscaja;
    $("#idcajadiaria").val(datoscaja[0].idcajadiaria);
    $("#fecha_inicio_caja").html(datoscaja[0].fecha_apertura);
    $("#btnaperturarcaja").removeClass("btnhabilitado");
    $("#btnaperturarcaja").addClass("btndisabled");
    $("#btnaperturarcaja").prop("disabled", true);
    $("#btncerrarcaja").prop("disabled", false);
    $("#btncerrarcaja").addClass("btnhabilitado");
    $("#btncerrarcaja").removeClass("btndisabled");
    $(".cont_tablas_caja").css("display", "block");
    $(".cont_caja_cerrada").css("display", "none");
    listargastos();
    listarmontoscaja();
    listarultimosingresos();
  }
}
function registrargasto() {
  monto = $("#MontoGasto").val();
  descripcion = $("#DescripcionGasto").val();
  if (monto === "" || descripcion === "") alert("INRGRESE MONTO Y DESCRIPCIÓN");
  else {
    $("#btnregistrargasto").prop("disabled", true);
    let datax = $("#frmRegistrarGasto").serializeArray();
    let llamadoAjax = ajaxFunction(datax);
    listargastos();
    listarmontoscaja();
    cerrarmodal();
    $("#btnregistrargasto").prop("disabled", false);
  }
}

$(function () {
  $(document).on("click", "#tbConfirmados .fa-heartbeat", function (e) {
    e.preventDefault();
    let parent = $(this).closest("table");
    let tr = $(this).closest("tr");
    let codigo = $(tr).find("td").eq(1).html();
    $("#idatencion_signos").val(codigo);
    let data = { accion: "OBTENER_SIGNOS_VITALES", idatencion: codigo };
    let llamadoAjax = ajaxFunction(data);
    if (llamadoAjax !== "SIGNOS NO REGISTRADOS") {
      let json = JSON.parse(llamadoAjax);
      let signos = json.signos;
      $("#fr_signosv").val(signos[0].fr);
      $("#pa_signosv").val(signos[0].pa);
      $("#temp_signosv").val(signos[0].temp);
      $("#so2_signosv").val(signos[0].so2);
      $("#peso_signosv").val(signos[0].peso);
      $("#btnregistrarsignos").html("Actualizar Signos");
    } else {
      $("#btnregistrarsignos").html("Registrar Signos");
    }
    abrirRegistroSignosVitales();
  });
});

function registrarSignosVitales() {
  let datax = $("#frmRegistrarSignosV").serializeArray();
  let llamadoAjax = ajaxFunction(datax);
  cerrarmodal();
}
function RegistrarAtencion() {
  $("#btnregistraratencion").prop("disabled", true);
  let datax = $("#frmRegistrarAtencion").serializeArray();
  let llamadoAjax = ajaxFunction(datax);
  if (llamadoAjax == "SE REGISTRÓ ATENCIÓN") {
    $("#btnregistraratencion").prop("disabled", false);
    Swal.fire("Se ha registrado Atención", '', "success");
    cerrarmodal();
    ListarConfirmados();
    //MostrarRegistrarTratamiento();
  }
}
$(function () {
  $(document).on("click", "#tbPacientes .open-atencion", function (e) {
    e.preventDefault();
    let parent = $(this).closest("table");
    let tr = $(this).closest("tr");
    let dni = $(tr).find("td").eq(0).html();
    let data = { accion: "OBTENER_DATOS_PACIENTE", dni: dni };
    let llamadoAjax = ajaxFunction(data);
    let json = JSON.parse(llamadoAjax);
    let paciente = json.paciente;
    $("#h2Paciente").html(
      `${paciente[0].apellidos}, ${paciente[0].nombre}<br/><span>Dni: ${paciente[0].dni} | Fecha Nac.: ${paciente[0].fecha_nac}</span>`
    );
    $("#IdPacienteHistoria").val(dni);
    ListarAtencionesPorPaciente(dni);
    ListarOtrosExamenes(dni);
    limpiarhistoria();
    abrirHistorial();
  });
});
function VerAtencion(idatencion) {
  $(".consulta_historia").removeClass("examen");
  $(".consulta_historia").addClass("consulta");
  $(".consulta_historia").removeClass("otropdf");
  $(".consulta_historia").removeClass("otroimg");
  let data = { accion: "OBTENER_DATOS_ATENCION", idatencion: idatencion };
  let llamadoAjax = ajaxFunction(data);
  let json = JSON.parse(llamadoAjax);
  let atencion = json.atencion;
  $("#hist_fecha").html("Fecha : " + atencion[0].fechaatencion);
  /*   $("#hist_fc").html("<span>FC : " + atencion[0].fr + "</span>");
    $("#hist_pa").html("<span>PA : " + atencion[0].pa + "</span>");
    $("#hist_t").html("<span>T° : " + atencion[0].temp + "</span>");
    $("#hist_so2").html("<span>So2 : " + atencion[0].so2 + "</span>");
    $("#hist_peso").html("<span>PESO : " + atencion[0].peso + "</span>"); */
  $("#hist_antecedente").html(atencion[0].antecedente);
  $("#hist_molestia").html(atencion[0].motivoconsulta);
  $("#hist_anamnesis").html(atencion[0].anamensis);
  $("#hist_exfisico").html(atencion[0].exfisico);
  $("#hist_diagnostico").html(atencion[0].diagnostico);
  $("#hist_tratamiento").html(atencion[0].tratamiento);
  $("#btnEditAtencion").attr("onclick", `editarAtencion(${idatencion})`);
}

function VerExamen(idatencion) {
  $(".consulta_historia").addClass("examen");
  $(".consulta_historia").removeClass("consulta");
  $(".consulta_historia").removeClass("otropdf");
  $(".consulta_historia").removeClass("otroimg");
  $("#cont-examen").html("");
  let data = { accion: "OBTENER_DATOS_ATENCION", idatencion: idatencion };
  let llamadoAjax = ajaxFunction(data);
  let json = JSON.parse(llamadoAjax);
  let atencion = json.atencion;
  $("#hist_fecha").html("Fecha : " + atencion[0].fechaatencion);
  /*   $("#hist_fc").html("<span>FC : " + atencion[0].fr + "</span>");
    $("#hist_pa").html("<span>PA : " + atencion[0].pa + "</span>");
    $("#hist_t").html("<span>T° : " + atencion[0].temp + "</span>");
    $("#hist_so2").html("<span>So2 : " + atencion[0].so2 + "</span>");
    $("#hist_peso").html("<span>PESO : " + atencion[0].peso + "</span>"); */
  $("#hist_antecedente").html(atencion[0].antecedente);
  $("#hist_molestia").html(atencion[0].motivoconsulta);
  $("#hist_anamnesis").html(atencion[0].anamensis);
  $("#hist_exfisico").html(atencion[0].exfisico);
  $("#hist_diagnostico").html(atencion[0].diagnostico);
  $("#hist_tratamiento").html(atencion[0].tratamiento);
  $("#btnEditAtencion").attr("onclick", `editarAtencion(${idatencion})`);
  //data = { accion: "OBTENER_DATOS_EXAMEN", idatencion: idatencion };
  //llamadoAjax = ajaxFunction(data);
  //let jsonExamen = JSON.parse(llamadoAjax);
  //let examen = jsonExamen.atencion;
  /*$("#cont-examen").html(
    `<iframe src="formularios/${examen[0].examen}" width="100%"></iframe>`
  ); */
}
function limpiarhistoria() {
  $("#hist_fecha").html("Fecha : -");
  $("#hist_fc").html("<span>FC : -");
  $("#hist_pa").html("<span>PA : --");
  $("#hist_t").html("<span>T° : -");
  $("#hist_so2").html("<span>So2 : -");
  $("#hist_peso").html("<span>PESO : -");
  $("#hist_antecedente").html("-");
  $("#hist_molestia").html("-");
  $("#hist_anamnesis").html("-");
  $("#hist_exfisico").html("-");
  $("#hist_diagnostico").html("-");
  $("#hist_tratamiento").html("-");
  $("#cont-imagenes").html("");
  $("#cont-examen").html("");
}
// ------------------------------ ↓↓ CAMBIOOOS ↓↓ --------------------------
function VerPDF(idexamen) {
  $(".consulta_historia").addClass("examen");
  $(".consulta_historia").addClass("otropdf");
  $(".consulta_historia").removeClass("consulta");
  $(".consulta_historia").removeClass("otroimg");
  $("#cont-examen").html("");
  let data = { accion: "OBTENER_OTRO_EXAMEN", idexamen: idexamen };
  let llamadoAjax = ajaxFunction(data);
  let json = JSON.parse(llamadoAjax);
  let examenes = json.examenes;
  $("#cont-examen").html(
    `<div class="cont-opciones-examenes"><button type="button" class="btndel" onclick="EliminarExamen(${idexamen})">Eliminar Examen</button></div><iframe src="${examenes[0].archivo}" width="100%"></iframe>`
  );
  console.log(examenes[0].archivo);
}
function VerIMG(idexamen) {
  $(".consulta_historia").removeClass("examen");
  $(".consulta_historia").removeClass("otropdf");
  $(".consulta_historia").removeClass("consulta");
  $(".consulta_historia").addClass("otroimg");
  $("#cont-imagenes").html("");
  let data = { accion: "OBTENER_OTRO_EXAMEN_IMG", idexamen: idexamen };
  let llamadoAjax = ajaxFunction(data);
  $("#cont-imagenes").html(
    `<div class="cont-opciones-examenes"><button type="button" class="btndel" onclick="EliminarExamen(${idexamen})">Eliminar Examen</button></div>${llamadoAjax}`
  );
}
function EliminarExamen(idexamen) {
  dni = $("#IdPacienteHistoria").val();
  Swal.fire({
    title: "Desea Eliminar el examen " + idexamen + "?",
    text: "Esta acción no podrá revertirse",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#b2bec3",
    confirmButtonText: "Sí, Eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      let data = { accion: "ELIMINAR_EXAMEN", idexamen: idexamen };
      let llamadoAjax = ajaxFunction(data);
      Swal.fire("Se ha eliminado el examen", idexamen, "success");
      ListarOtrosExamenes(dni);
      limpiarhistoria();
    }
  });
}
// ------------------------------ ↑↑ CAMBIOOOS ↑↑ --------------------------
function RegistrarProcedimiento() {
  let datax = $("#frmRegistrarProcedimiento").serializeArray();
  let llamadoAjax = ajaxFunction(datax);
  alert(llamadoAjax);
  ListarProcedimientos();
  cerrarmodal();
}
$(function () {
  $(document).on("click", "#tbProcedimientos .fa-edit", function (e) {
    e.preventDefault();
    let parent = $(this).closest("table");
    let tr = $(this).closest("tr");
    let codigo = $(tr).find("td").eq(0).html();
    let nombre = $(tr).find("td").eq(1).html();
    let precio = $(tr).find("td").eq(2).html();

    $("#idprocedimiento").val(codigo);
    DesahabilitarBoton("#idprocedimiento");
    $("#NombreProcedimiento").val(nombre);
    $("#PrecioProcedimiento").val(precio);
    abrirRegistroProcedimiento();
    $("#AccionProcedimiento").val("ACTUALIZAR_PROCEDIMIENTO");
  });
});
$(function () {
  $(document).on("click", "#tbCitas .fa-sliders-h", function (event) {
    event.preventDefault();
    let parent = $(this).closest("table");
    let tr = $(this).closest("tr");
    let idcita = $(tr).find("td").eq(0).html();
    $("#CodigoCita").val(idcita);
    let data = { accion: "OBTENER_DATOS_CITA", idcita: idcita };
    let llamadoAjax = ajaxFunction(data);
    let json = JSON.parse(llamadoAjax);
    let cita = json.cita;
    $("#TipoPaciente").val("REG");
    $("#NroDocCita").val(cita[0].dni);
    $("#NombrePacienteC").val(
      `${cita[0].apellidospaciente}, ${cita[0].nombrepaciente}`
    );
    $("#IdMovitoCita").val(cita[0].idtipoatencion);
    $("#MovitoCita").val(cita[0].motivo);
    $("#PrecioMotivoCita").val(cita[0].precio);
    $("#FechaCita").val(cita[0].fecha);
    $("#HoraCita").val(cita[0].horario);
    $("#NroCelularCita").val(cita[0].telefono);

    abrirRegistrarCita();
    $("#AccionCita").val("ACTUALIZAR_CITA");
  });
});
$(function () {
  $(document).on("click", "#tbAtenciones .fa-eye", function (event) {
    event.preventDefault();
    let parent = $(this).closest("table");
    let tr = $(this).closest("tr");
    let idatencion = $(tr).find("td").eq(0).html();
    let dni = $(tr).find("td").eq(1).html();
    let data = { accion: "OBTENER_DATOS_PACIENTE", dni: dni };
    let llamadoAjax = ajaxFunction(data);
    let json = JSON.parse(llamadoAjax);
    let paciente = json.paciente;
    $("#h2Paciente").html(
      `${paciente[0].apellidos}, ${paciente[0].nombre} <br/><span>Dni: ${paciente[0].dni} | Fecha Nac.: ${paciente[0].fecha_nac}</span>`
    );
    ListarAtencionesPorPaciente(dni);
    ListarOtrosExamenes(dni);
    VerAtencion(idatencion);
    abrirHistorial();
  });
});
function Reporte() {
  let fecha1 = $("#ReporteDesde").val();
  let fecha2 = $("#ReporteHasta").val();
  let tipomov = $("input:radio[name=tipomovimiento]:checked").val();
  let data = {
    accion: "LISTAR_REPORTE",
    tipomovimientocaja: tipomov,
    fecha1: fecha1,
    fecha2: fecha2,
  };
  let llamadoAjax = ajaxFunction(data);
  $("#tbReporte").html(llamadoAjax);
  let total = 0;
  let efectivo = 0;
  let transferencia = 0;
  let pos = 0;
  let yape = 0;
  let num = 0;
  $("#tbReporte tr").each(function () {
    let tipopago = $(this).find("td").eq(5).html();
    let estado = $(this).find("td").eq(7).html();
    let monto = parseFloat($(this).find("td").eq(4).html());
    if (tipopago === "EFECTIVO" && estado !== "ANULADO") efectivo += monto;
    if (tipopago === "TRANSFERENCIA" && estado !== "ANULADO")
      transferencia += monto;
    if (tipopago === "POS" && estado !== "ANULADO") pos += monto;
    if (tipopago === "YAPE" && estado !== "ANULADO") yape += monto;
    num++;
  });
  total = efectivo + transferencia + pos + yape;
  total = total.toFixed(2);
  $("#lbltotal").html(`MONTO TOTAL : S/. ${total}`);
  $("#lbltotalEfectivo").html(`EFECTIVO : S/. ${efectivo}`);
  $("#lbltotalTransf").html(`TRANSFERENCIA : S/. ${transferencia}`);
  $("#lbltotalPos").html(`POS : S/. ${pos}`);
  $("#lbltotalYape").html(`YAPE : S/. ${yape}`);
}
function RegistrarCitaExterna() {
  let datax = $("#frmregistrarcita_externa").serializeArray();
  let llamadoAjax = ajaxFunction(datax);
  alert(llamadoAjax);
  ListarCitasExternas();
  cerrarmodal();
}
function ListarCitasExternas() {
  let fecha1 = $("#FechaExterno1").val();
  let fecha2 = $("#FechaExterno2").val();
  let establecimiento = $("#establecimiento").val();

  let data = {
    accion: "LISTAR_CITAS_EXTERNAS",
    fecha1: fecha1,
    fecha2: fecha2,
    establecimiento: establecimiento,
  };
  let llamadoAjax = ajaxFunction(data);
  $("#tbCitasExternas").html(llamadoAjax);
  let nFilas = $("#tbCitasExternas tr").length;
  let total = 0;
  let num = 0;
  $("#tbCitasExternas tr").each(function () {
    total += parseFloat($(this).find("td").eq(6).html());
    num++;
  });
  total = total.toFixed(2);
  $("#lbltotalexterno").html(`TOTAL : S/. ${total}`);
}
function RegistrarMedicamento() {
  producto = $("#nombreMedicamento").val();
  cantidad = $("#CantidadInicial").val();
  if (producto == "") {
    alert("INGRESE NOMBRE DE PRODUCTO");
  } else if (cantidad == "" || cantidad < 0) {
    alert("INGRESE CANTIDAD VÁLIDA");
  } else {
    let datax = $("#frmMedicamentos").serializeArray();
    let llamadoAjax = ajaxFunction(datax);
    alert(llamadoAjax);
    ListarMedicamentos();
    CancelarRegProd();
  }
}
function CancelarRegProd() {
  document.getElementById("frmMedicamentos").reset();
  $("#accionProducto").val("REGISTRAR_PRODUCTO");
  $("#btnRegistrarProducto").html("Registrar");
  $("#CantidadInicial").css("display", "block");
  $("#btnCancelarProducto").css("display", "none");
  limpiar();
}
function RegistrarMovimientoA() {
  tipomov = $("input:radio[name=movimientoalmacen]:checked").val();
  producto = $("#IdProducto").val();
  cantidad = $("#CantidadProducto").val();
  stock = $("#StockProducto").val();
  descripcion = $("#Descripcion").val();
  if (tipomov == "" || tipomov == null) {
    alert("SELECCIONE TIPO DE MOVIMIENTO");
  } else if (
    producto == "" ||
    cantidad == "" ||
    cantidad < 1 ||
    descripcion == ""
  ) {
    alert("TODOS LOS DATOS SON NECESARIOS");
  } else {
    if (tipomov == "S" && cantidad > stock) {
      alert("CANTIDAD DE EXISTENCIAS INSUFICIENTES");
    } else {
      $("#btnregistrarMovimientoA").prop("disabled", true);

      let datax = $("#frmRegistrarProducto").serializeArray();
      let llamadoAjax = ajaxFunction(datax);
      alert(llamadoAjax);
      ListarMedicamentos();
      cerrarmodal();
      $("#btnregistrarMovimientoA").prop("disabled", false);
    }
  }
}
function CancelarTratamiento() {
  let llamadoAjax = ajaxFunction({ accion: "CANCELAR_CARRITO" });
  $("#tbTratamiento").html(llamadoAjax);
}
function MostrarRegistrarTratamiento() {
  $("#frmRegistrarAtencion").removeClass("activo");
  $("#frmRegistrarTratamiento").addClass("activo");
  let idatencion = $("#ate_idatencion").val();
  $("#idatencion_trat").val(idatencion);
  $(".modal").removeClass("w100");
  $(".bg-dark").removeClass("all");
}

function CambiarPass() {
  let pass1 = $("#pass1").val();
  let pass2 = $("#pass2").val();
  if (pass1 == "" || pass2 == "") alert("INGRESAR CONTRASEÑAS VÁLIDAS");
  else if (pass1 != pass2) alert("CONTRASEÑAS NO COINCIDEN");
  else {
    let datax = $("#frmCambioPass").serializeArray();
    let llamadoAjax = ajaxFunction(datax);
    alert(llamadoAjax);
    cerrarmodal();
  }
}

function generarPDF(idatencion) {
  let ancho = 1000;
  let alto = 800;
  let x = parseInt(window.screen.width / 2 - ancho / 2);
  let y = parseInt(window.screen.height / 2 - alto / 2);

  $url = `recursos/pdf/index.php?idatencion=${idatencion}`;
  window.open(
    $url,
    "Reporte",
    `left=${x},top=${y},height=${alto}width=${ancho},scrollbar=si,location=no,resizable=si,menubar=no`
  );
}
function generarPDFExterno() {
  fecha1 = $("#FechaExterno1").val();
  fecha2 = $("#FechaExterno2").val();
  establecimiento = $("#establecimiento").val();
  let ancho = 1000;
  let alto = 800;
  let x = parseInt(window.screen.width / 2 - ancho / 2);
  let y = parseInt(window.screen.height / 2 - alto / 2);

  $url = `recursos/pdf/reporteexterno.php?fecha1=${fecha1}&fecha2=${fecha2}&establecimiento=${establecimiento}`;
  window.open(
    $url,
    "Reporte",
    `left=${x},top=${y},height=${alto}width=${ancho},scrollbar=si,location=no,resizable=si,menubar=no`
  );
}
function generarticketPDF(idcita) {
  let ancho = 1000;
  let alto = 800;
  let x = parseInt(window.screen.width / 2 - ancho / 2);
  let y = parseInt(window.screen.height / 2 - alto / 2);

  $url = `recursos/pdf/ticket.php?idcita=${idcita}`;
  window.open(
    $url,
    "Reporte",
    `left=${x},top=${y},height=${alto}width=${ancho},scrollbar=si,location=no,resizable=si,menubar=no`
  );
}
function generarPDFReporte() {
  fecha1 = $("#ReporteDesde").val();
  fecha2 = $("#ReporteHasta").val();
  tipomovimiento = $("input:radio[name=tipomovimiento]:checked").val();
  let ancho = 1000;
  let alto = 800;
  let x = parseInt(window.screen.width / 2 - ancho / 2);
  let y = parseInt(window.screen.height / 2 - alto / 2);

  $url = `recursos/pdf/reporte.php?fecha1=${fecha1}&fecha2=${fecha2}&tipomovimiento=${tipomovimiento}`;
  window.open(
    $url,
    "Reporte",
    `left=${x},top=${y},height=${alto}width=${ancho},scrollbar=si,location=no,resizable=si,menubar=no`
  );
}
function ValidarSesion(div, contenido, contenedor, link) {
  let llamadoAjax = ajaxFunction({ accion: "VALIDAR_SESION" });
  if (llamadoAjax == "NECESITA VOLVER A LOGEAR")
    window.location.replace("login.php");
  else {
    abrir_form(div, contenido);
    remove_addClass(contenedor, link);
  }
}
function ValidarSesion2() {
  let data = { accion: "VALIDAR_SESION" };
  let llamadoAjax = ajaxFunction(data);
  if (llamadoAjax == "NECESITA VOLVER A LOGEAR")
    window.location.replace("login.php");
}
function ObtenerDatosPacienteCExt() {
  dni = $("#NroDocCitaExt").val();
  $("#NombrePacienteCExt").val("");
  let data = { accion: "OBTENER_DATOS_PACIENTE", dni: dni };
  let llamadoAjax = ajaxFunction(data);
  if (llamadoAjax == "NO REGISTRADO") {
    data = { accion: "CONSULTA_DNI", dni: dni };
    llamadoAjax = ajaxFunction(data);
    json = JSON.parse(llamadoAjax);
    if (json["success"] == false)
      $("#NombrePacienteCExt").prop("readonly", false);
    else if (json["success"] == true)
      $("#NombrePacienteCExt").val(json["data"].nombre_completo);
  } else {
    json = JSON.parse(llamadoAjax);
    paciente = json.paciente;
    $("#NombrePacienteCExt").val(
      paciente[0].apellidos + ", " + paciente[0].nombre
    );
  }
}

$(function () {
  $(document).on("click", "#tbConfirmados .fa-calendar-plus", function (e) {
    e.preventDefault();
    $("#typeAction").val("REGISTRAR");
    let parent = $(this).closest("table");
    let tr = $(this).closest("tr");
    let codigo = $(tr).find("td").eq(1).html();
    $("#ate_idatencion").val(codigo);
    let data = { accion: "OBTENER_DATOS_ATENCION", idatencion: codigo };
    let llamadoAjax = ajaxFunction(data);
    let json = JSON.parse(llamadoAjax);
    let atencion = json.atencion;
    console.log(llamadoAjax);
    $("#NombresAtencion").html(
      `${atencion[0].paciente}<br/><span>Dni: ${atencion[0].dni} | Edad: ${atencion[0].edad} años</span>`
    );
    $("#ate_fc").val(atencion[0].fr);
    $("#ate_pa").val(atencion[0].pa);
    $("#ate_temp").val(atencion[0].temp);
    $("#ate_so2").val(atencion[0].so2);
    $("#ate_peso").val(atencion[0].peso);
    $("#dni_atencion").val(atencion[0].dni);

    let dataAnt = { accion: "OBTENER_ANTECEDENTES_G", dni: atencion[0].dni };
    let llamadoAjaxAnt = ajaxFunction(dataAnt);
    let jsonAnt = JSON.parse(llamadoAjaxAnt);
    console.log(jsonAnt.antecedentesgenerales.length);

    if (jsonAnt.antecedentesgenerales.length > 0) {
      let antGenerales = jsonAnt.antecedentesgenerales;
      console.log(antGenerales);
      if (antGenerales[0].HTA === "SI") $("#htasi").prop("checked", true);
      if (antGenerales[0].HIV === "SI") {
        $("#hivsi").prop("checked", true);
        $("#frmRegistrarAtencion").css("color", "#f7b731");
        $(".modal").addClass("ambar");
      }
      if (antGenerales[0].DM === "SI") $("#dmsi").prop("checked", true);
      if (antGenerales[0].HEPATITIS === "SI") {
        $("#hepsi").prop("checked", true);
        $("#frmRegistrarAtencion").css("color", "#27ae60");
        $(".modal").addClass("green");
      }
      $("#alergias").val(antGenerales[0].ALERGIAS);
      if ($("#alergias").val() !== "-") {
        $("#frmRegistrarAtencion").css("color", "#e74c3c");
        $(".modal").addClass("red");
      } else $("#alergias").val("-");
    }
    document.getElementById(
      "btnregistraratencion"
    ).innerHTML = `Registrar Atención`;
    abrirRegistrarAtencion();
  });
});
function editarAtencion(codigo) {
  $("#typeAction").val("MODIFICAR");
  $("#ate_idatencion").val(codigo);
  let data = { accion: "OBTENER_DATOS_ATENCION", idatencion: codigo };
  let llamadoAjax = ajaxFunction(data);
  let json = JSON.parse(llamadoAjax);
  let atencion = json.atencion;
  console.log(llamadoAjax);
  $("#NombresAtencion").html(
    `${atencion[0].paciente}<br/><span>Dni: ${atencion[0].dni} | Edad: ${atencion[0].edad} años</span>`
  );
  $("#ate_fc").val(atencion[0].fr);
  $("#ate_pa").val(atencion[0].pa);
  $("#ate_temp").val(atencion[0].temp);
  $("#ate_so2").val(atencion[0].so2);
  $("#ate_peso").val(atencion[0].peso);
  $("#dni_atencion").val(atencion[0].dni);

  let dataAnt = { accion: "OBTENER_ANTECEDENTES_G", dni: atencion[0].dni };
  let llamadoAjaxAnt = ajaxFunction(dataAnt);
  let jsonAnt = JSON.parse(llamadoAjaxAnt);
  console.log(jsonAnt.antecedentesgenerales.length);

  if (jsonAnt.antecedentesgenerales.length > 0) {
    let antGenerales = jsonAnt.antecedentesgenerales;
    console.log(antGenerales);
    if (antGenerales[0].HTA === "SI") $("#htasi").prop("checked", true);
    if (antGenerales[0].HIV === "SI") {
      $("#hivsi").prop("checked", true);
      $("#frmRegistrarAtencion").css("color", "#f7b731");
      $(".modal").addClass("ambar");
    }
    if (antGenerales[0].DM === "SI") $("#dmsi").prop("checked", true);
    if (antGenerales[0].HEPATITIS === "SI") {
      $("#hepsi").prop("checked", true);
      $("#frmRegistrarAtencion").css("color", "#27ae60");
      $(".modal").addClass("green");
    }
    $("#alergias").val(antGenerales[0].ALERGIAS);
    if ($("#alergias").val() !== "-") {
      $("#frmRegistrarAtencion").css("color", "#e74c3c");
      $(".modal").addClass("red");
    } else $("#alergias").val("-");
  }
  $("#ate_antecedentes").html(atencion[0].antecedente);
  $("#ate_molestia").html(atencion[0].motivoconsulta);
  $("#txtanamnesis").html(atencion[0].anamensis);
  $("#txtexamenfisico").html(atencion[0].exfisico);
  $("#txtdiagnostico").html(atencion[0].diagnostico);
  $("#txttratamiento").html(atencion[0].tratamiento);
  document.getElementById("btnregistraratencion").innerHTML =
    "Modificar Atención";
  abrirRegistrarAtencion();
}
