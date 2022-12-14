<?php
require_once '../ado/clsPersonal.php';
require_once '../ado/clsPaciente.php';
require_once '../ado/clsProcedimiento.php';
require_once '../ado/clsCita.php';
require_once '../ado/clsCaja.php';
require_once '../ado/clsAtencion.php';
require_once '../ado/clsConsultas.php';
require_once '../ado/clsEstablecimiento.php';
require_once '../ado/clsAntecedentes.php';
require_once '../ado/clsMedicamentos.php';
require_once '../ado/clsExamenes.php';

$accion = $_POST['accion'];
controlador($accion);

function controlador($accion)
{
    $objPersonal = new clsPersonal();
    $objPaciente = new clsPaciente();
    $objProcedimiento = new clsProcedimiento();
    $objCita = new clsCita();
    $objCaja = new clsCaja();
    $objAtencion = new clsAtencion();
    $objConsultas = new clsConsultas();
    $objEstablecimiento = new clsEstablecimiento();
    $objAntecedentes = new clsAntecedentes();
    $objMedicamentos = new clsMedicamentos();
    $objExamenes = new clsExamenes();

    switch ($accion) {
        case 'LISTAR_PERSONAL':
            session_start();
            $filtro = $_POST['filtro'];
            if (empty($filtro)) {
                $listadopersonal = $objPersonal->ListarPersonal();
                while ($fila = $listadopersonal->fetch(PDO::FETCH_NAMED)) {
                    echo '<tr>';
                    echo '<td class="ta-center">' . $fila['dni'] . '</td>';
                    echo '<td class="ta-center">' . $fila['nombre'] . '</td>';
                    echo '<td class="ta-center">' . $fila['nick'] . '</td>';
                    echo '<td class="ta-center">' . $fila['cargo'] . '</td>';
                    if ($_SESSION['cargo'] == 1) {
                        echo '<td class="ta-center">' .
                            $fila['estado'] .
                            '</td>';
                        echo '<td class="ta-center"><i class="far fa-edit edit-usuario"></i></td>';
                        echo '<td class="ta-center"><i class="fas fa-unlock-alt" onclick="abrirCambioPass(' . $fila['dni'] . ')"></i></td>';
                    }
                    echo '</tr>';
                }
            } else {
                echo 'Meow';
            }
            break;
        case 'LISTAR_CARGOS':
            session_start();

            $listadocargos = $objPersonal->ListarCargo();
            echo '<option value="0">Seleccione Cargo</option>';
            while ($fila = $listadocargos->fetch(PDO::FETCH_NAMED)) {
                echo '<option value="' .
                    $fila['idcargo'] .
                    '">' .
                    $fila['nombre'] .
                    '</option>';
            }
            break;

        case 'CONSULTA_DNI':
            $dni = $_POST['dni'];
            $token =
                'e49fddfa2a41c2c2f26d48840f7d81a66dc78dc2b0e085742a883f0ab0f84158';
            $url =
                'https://apiperu.dev/api/dni/' . $dni . '?api_token=' . $token;
            $curl = curl_init();

            $header = [];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            //para ejecutar los procesos de forma local en windows
            //enlace de descarga del cacert.pem https://curl.haxx.se/docs/caextract.html
            curl_setopt(
                $curl,
                CURLOPT_CAINFO,
                dirname(__FILE__) . '/../cacert-2022-10-11.pem'
            );

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo 'cURL Error #:' . $err;
            } else {
                echo $response;
            }
            break;
        case 'REGISTRAR_USUARIO':
            $usuario = [
                'dni' => $_POST['NroDocPersonal'],
                'nombre' => $_POST['NombrePersonal'],
                'apellidos' => $_POST['ApellidosPersonal'],
                'nick' => $_POST['Nick'],
                'pass' => md5($_POST['Pass']),
                'idcargo' => $_POST['idcargo'],
                'estado' => $_POST['EstadoUsuario'],
            ];
            $objPersonal->RegistrarPersonal($usuario);
            echo 'SE REGISTRÓ USUARIO';
            break;
        case 'ACTUALIZAR_USUARIO':
            $usuario = [
                'dni' => $_POST['NroDocPersonal'],
                'nombre' => $_POST['NombrePersonal'],
                'apellidos' => $_POST['ApellidosPersonal'],
                'nick' => $_POST['Nick'],
                'idcargo' => $_POST['idcargo'],
                'estado' => $_POST['EstadoUsuario'],
            ];
            $objPersonal->ActualizarPersonal($usuario);
            echo 'SE ACTUALIZÓ LA INFORMACIÓN';
            break;
        case 'CAMBIAR_PASS':
            $usuario = [
                'dni' => $_POST['IdUsuario'],
                'pass' => md5($_POST['pass1'])
            ];
            $objPersonal->CambiarPass($usuario);
            echo 'SE ACTUALIZÓ LA INFORMACIÓN';
            break;
        case 'REGISTRAR_CARGO':
            $objPersonal->RegistrarCargo($_POST['cargo']);
            echo 'CARGO REGISTRADO CORRECTAMENTE';
            break;
        case 'OBTENER_DATOS_PERSONAL':
            $usuario = $objPersonal->ObtenerDatosPersonal($_POST['dni']);
            if ($usuario->rowCount() > 0) {
                $usuario = $usuario->fetchAll(PDO::FETCH_NAMED);
                $usuario = ['usuario' => $usuario];
                echo json_encode($usuario);
            } else {
                echo 'NO REGISTRADO';
            }
            break;
        case 'LISTAR_PACIENTES':
            session_start();
            $filtro = $_POST['filtro'];
            if (empty($filtro)) {
                $listadopacientes = $objPaciente->ListarPaciente();
            } else {
                $listadopacientes = $objPaciente->FiltrarPaciente($filtro);
            }
            while ($fila = $listadopacientes->fetch(PDO::FETCH_NAMED)) {
                echo '<tr>';
                echo '<td class="ta-center">' . $fila['dni'] . '</td>';
                echo '<td class="ta-center">' .
                    $fila['apellidos'] .
                    ', ' .
                    $fila['nombre'] .
                    '</td>';
                //echo '<td class="ta-center">' . $fila['nombre'] . '</td>';
                echo '<td class="ta-center">' . $fila['fecha_nac'] . '</td>';
                echo '<td class="ta-center">' . $fila['telefono'] . '</td>';
                if ($_SESSION['cargo'] == 1 || $_SESSION['cargo'] == 4) {
                    echo '<td class="ta-center"><i class="fas fa-user-cog edit-paciente"></i></td>
                    <td class="ta-center"><i class="fas fa-user-times"></i></td>';
                }
                if ($_SESSION['cargo'] == 1 || $_SESSION['cargo'] == 2 || $_SESSION['cargo'] == 4) {
                    echo '<td class="ta-center"><i class="far fa-address-card open-atencion"></i></td>';
                }
                echo '<td class="ta-center"><i class="far fa-images"></i></td>';
                echo '<td class="ta-center"><i class="fas fa-file-pdf"></i></td>';
                echo '</tr>';
            }
            break;
        case 'REGISTRAR_PACIENTE':
            $paciente = [
                'dni' => $_POST['NroDocPaciente'],
                'nombre' => $_POST['NombrePaciente'],
                'apellidos' => $_POST['ApellidosPaciente'],
                'telefono' => $_POST['NroCelular'],
                'fecha_nac' => $_POST['fechanac'],
            ];
            $objPaciente->RegistrarPaciente($paciente);
            echo 'PACIENTE REGISTRADO CORRECTAMENTE';
            break;
        case 'ACTUALIZAR_PACIENTE':
            $paciente = [
                'dni' => $_POST['NroDocPaciente'],
                'nombre' => $_POST['NombrePaciente'],
                'apellidos' => $_POST['ApellidosPaciente'],
                'telefono' => $_POST['NroCelular'],
                'fecha_nac' => $_POST['fechanac'],
            ];
            $objPaciente->ActualizarPaciente($paciente);
            echo 'DATOS ACTUALIZADOS CORRECTAMENTE';
            break;
        case 'ELIMINAR_PACIENTE':
            $idpaciente = $_POST['idpaciente'];
            $registros_paciente = $objAtencion->ListarAtencionesPorPaciente(
                $idpaciente
            );
            if ($registros_paciente->rowCount() < 1) {
                $objPaciente->EliminarPaciente($idpaciente);
                echo 'SE ELIMINÓ PACIENTE';
            } else {
                echo 'NO SE PUEDE ELIMINAR PACIENTE PORQUE CONTIENE REGISTROS';
            }
            break;
        case 'OBTENER_DATOS_PACIENTE':
            $paciente = $objPaciente->ObtenerDatosPaciente($_POST['dni']);
            if ($paciente->rowCount() > 0) {
                $paciente = $paciente->fetchAll(PDO::FETCH_NAMED);
                $paciente = ['paciente' => $paciente];
                echo json_encode($paciente);
            } else {
                echo 'NO REGISTRADO';
            }
            break;
        case 'OBTENER_PROC_NOMBRE':
            $tipo_atencion = $objProcedimiento->ObtenerProcedimientoNombre(
                $_POST['filtro']
            );
            if ($tipo_atencion->rowCount() > 0) {
                $tipo_atencion = $tipo_atencion->fetchAll(PDO::FETCH_NAMED);
                $tipo_atencion = ['tipo_atencion' => $tipo_atencion];
                echo json_encode($tipo_atencion);
            } else {
                echo 'NO REGISTRADO';
            }
            break;
        case 'REGISTRAR_CITA':
            $dni = $_POST['NroDocCita'];

            $paciente_existe = $objPaciente->ObtenerDatosPaciente($dni);
            if ($paciente_existe->rowCount() < 1) {
                $paciente = [
                    'dni' => $dni,
                    'nombre' => $_POST['NombrePacienteCita'],
                    'apellidos' => $_POST['ApellidosPacienteCita'],
                    'telefono' => $_POST['NroCelularCita'],
                    'fecha_nac' => $_POST['FechaNacCita'],
                ];
                $objPaciente->RegistrarPaciente($paciente);
            }
            $cita = [
                'dni' => $dni,
                'fecha' => $_POST['FechaCita'],
                'horario' => $_POST['HoraCita'],
                'motivo_consulta' => $_POST['IdMovitoCita'],
                'precio_consulta' => $_POST['PrecioMotivoCita'],
                'estado' => 'POR PAGAR',
            ];
            $objCita->RegistrarCita($cita);
            $ultima_cita = $objCita->ObtenerUltimaCita();
            $ultima_cita = $ultima_cita->fetch(PDO::FETCH_NAMED);

            echo $ultima_cita['idcita'];
            break;
        case 'ACTUALIZAR_CITA':
            $dni = $_POST['NroDocCita'];
            $paciente_existe = $objPaciente->ObtenerDatosPaciente($dni);
            if ($paciente_existe->rowCount() < 1) {
                $paciente = [
                    'dni' => $dni,
                    'nombre' => $_POST['NombrePacienteCita'],
                    'apellidos' => $_POST['ApellidosPacienteCita'],
                    'telefono' => $_POST['NroCelularCita'],
                    'fecha_nac' => $_POST['FechaNacCita'],
                ];
                $objPaciente->RegistrarPaciente($paciente);
            }
            $cita = [
                'dni' => $dni,
                'fecha' => $_POST['FechaCita'],
                'horario' => $_POST['HoraCita'],
                'motivo_consulta' => $_POST['IdMovitoCita'],
                'precio_consulta' => $_POST['PrecioMotivoCita'],
                'idcita' => $_POST['CodigoCita'],
            ];
            $objCita->ActualizarCita($cita);

            echo 'SE ACTUALIZARON DATOS DE CITA';
            break;
        case 'ANULAR_CITA':
            $idcita = $_POST['idcita'];
            $buscarMovimiento = $objCaja->BuscarMovimientoXcita($idcita);
            $buscarMovimiento = $buscarMovimiento->fetch(PDO::FETCH_NAMED);
            $idmovimiento = $buscarMovimiento['idmovimientocaja'];
            $objAtencion->EliminarAtencion($idmovimiento);
            $objCaja->AnularIngreso($idmovimiento);
            $objCita->AnularCita($idcita);
            echo 'SE ANULÓ CITA';
            break;
        case 'LISTAR_CITAS':
            session_start();
            $cargo = $_SESSION['cargo'];
            $filtro = $_POST['fecha'];
            $listadoCitas = $objCita->ListarCitasFecha($filtro);
            if ($listadoCitas->rowCount() > 0) {
                while ($fila = $listadoCitas->fetch(PDO::FETCH_NAMED)) {
                    $idcita = $fila['idcita'];
                    $obteneratencion = $objAtencion->BuscarAtencionPorCita(
                        $idcita
                    );
                    echo '<tr>';
                    echo '<td class="ta-center td-nvisible">' .
                        $idcita .
                        '</td>';
                    echo '<td class="ta-center">' . $fila['horario'] . '</td>';
                    echo '<td class="ta-center">' . $fila['paciente'] . '</td>';
                    echo '<td class="ta-center">' . $fila['motivo'] . '</td>';
                    echo '<td class="ta-center">' . $fila['telefono'] . '</td>';
                    if ($fila['estado'] !== 'ANULADO') {
                        if ($fila['estado'] == 'POR PAGAR') {
                            echo '<td class="ta-center"><a href="javascript:void(0)" class="lnk-RegPago lnk-red">Registrar Pago</a></td>';
                        } elseif ($fila['estado'] == 'A CUENTA') {
                            echo '<td class="ta-center"><a href="javascript:void(0)" class="lnk-RegPago lnk-Ambar">A CUENTA</a></td>';
                        } else {
                            echo '<td class="ta-center td-green">' .
                                $fila['estado'] .
                                '</td>';
                        }
                        if ($obteneratencion->rowCount() > 0) {
                            $obteneratencion = $obteneratencion->fetch(
                                PDO::FETCH_NAMED
                            );
                            if ($obteneratencion['estado'] === 'FINALIZADO') {
                                echo '<td colspan="2" class="ta-center td-green">ATENDIDO</td>';
                            } else {
                                echo '<td class="ta-center"><i class="fas fa-sliders-h"></i></td>';
                                if ($cargo === '1') {
                                    echo '<td class="ta-center"><i class="far fa-times-circle"></i></td>';
                                }
                            }
                        } else {
                            echo '<td class="ta-center"><i class="fas fa-sliders-h"></i></td>';
                            if ($cargo === '1') {
                                echo '<td class="ta-center"><i class="far fa-times-circle"></i></td>';
                            }
                        }
                        if ($fila['estado'] == 'A CUENTA' || $fila['estado'] == 'PAGADO') {
                            echo '<td class="ta-center"><i class="fas fa-print" onclick="generarticketPDF(' . $idcita . ')"></i></td>';
                        } else {
                            echo '<td class="ta-center td-green"></td>';
                        }
                    } else {
                        echo '<td colspan="3" class="ta-center lnk-red">ANULADO</td>';
                    }
                    echo '</tr>';
                }
            } else {
                echo 'NO HAY PERSONAS CITADAS';
            }
            break;
        case 'BUSCAR_CITAS':
            session_start();
            $dni = $_POST['dni'];
            $ListaCitas = $objCita->BuscarCitasPorPaciente($dni);
            if ($ListaCitas->rowCount() > 0) {
                while ($fila = $ListaCitas->fetch(PDO::FETCH_NAMED)) {
                    $idcita = $fila['idcita'];
                    $estado = $fila['estado'];
                    $obteneratencion = $objAtencion->BuscarAtencionPorCita(
                        $idcita
                    );
                    echo '<tr>';
                    echo '<td class="ta-center">' .
                        $idcita .
                        '</td>';
                    echo '<td class="ta-center">' . $fila['fecha'] . '</td>';
                    echo '<td class="ta-center">' . $fila['horario'] . '</td>';
                    echo '<td class="ta-center">' . $fila['motivo'] . '</td>';
                    if ($estado !== 'ANULADO') {
                        if ($estado == 'POR PAGAR') {
                            echo '<td colspan="2" class="ta-center"><a href="javascript:void(0)" class="lnk-red">' . $estado . '</a></td>';
                        } elseif ($estado == 'A CUENTA') {
                            echo '<td class="ta-center"><a href="javascript:void(0)" class="lnk-Ambar">' . $estado . '</a></td>';
                        } else {
                            echo '<td class="ta-center td-green">' .
                                $estado .
                                '</td>';
                        }
                        if ($obteneratencion->rowCount() > 0) {
                            $obteneratencion = $obteneratencion->fetch(
                                PDO::FETCH_NAMED
                            );
                            if ($obteneratencion['estado'] === 'FINALIZADO') {
                                echo '<td class="ta-center td-green">ATENDIDO</td>';
                            } else {
                                echo '<td class="ta-center lnk-ambar">PENDIENTE</td>';
                            }
                        }
                        if ($estado == 'A CUENTA' || $estado == 'PAGADO') {
                            echo '<td class="ta-center"><i class="fas fa-print" onclick="generarticketPDF(' . $idcita . ')"></i></td>';
                        } else {
                            echo '<td class="ta-center td-green"></td>';
                        }
                    } else {
                        echo '<td colspan="2" class="ta-center lnk-red">' . $estado . '</td>';
                    }
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="7">NO SE ENCONTRON REGISTROS</td></tr>';
            }
            break;
        case 'LISTAR_CITAS_CONFIRMADAS':
            session_start();
            $fecha = date('Y/m/d');
            $filtro = [
                'fecha' => $fecha,
                'estado' => 'PAGADO',
            ];
            $listadoConfirmados = $objCita->AtencionesConfirmadasHoy($filtro);
            if ($listadoConfirmados->rowCount() > 0) {
                while ($fila = $listadoConfirmados->fetch(PDO::FETCH_NAMED)) {
                    $idcita = $fila['idcita'];
                    $obteneratencion = $objAtencion->BuscarAtencionPorCita(
                        $idcita
                    );
                    $obteneratencion = $obteneratencion->fetch(
                        PDO::FETCH_NAMED
                    );

                    $obtenerpendientes = $objCita->BuscarPendientes(
                        $fila['dni']
                    );

                    if ($obteneratencion['estado'] !== 'FINALIZADO') {
                        if ($obtenerpendientes->rowCount() > 0) {
                            echo '<tr class="tr-pendiente">';
                        } else {
                            echo '<tr>';
                        }
                        echo '<td class="ta-center td-nvisible">' .
                            $idcita .
                            '</td>';
                        echo '<td class="ta-center td-nvisible">' .
                            $obteneratencion['idatencion'] .
                            '</td>';
                        echo '<td class="ta-center">' .
                            $fila['horario'] .
                            '</td>';
                        echo '<td class="ta-center">' .
                            $fila['paciente'] .
                            '</td>';
                        echo '<td class="ta-center">' .
                            $fila['motivo'] .
                            '</td>';
                        echo '<td class="ta-center"><i class="fas fa-heartbeat"></i></td>';
                        session_start();
                        $idcargo = $_SESSION['cargo'];

                        if ($idcargo == 1 || $idcargo == 2) {
                            if (
                                $fila['motivo'] === 'CONSULTA MÉDICA' || $fila['motivo'] === 'CITA DE CONTROL' ||
                                $obteneratencion['estado'] === 'EN PROGR'
                            ) {
                                echo '<td class="ta-center"><i class="far fa-calendar-plus"></i></td>';
                            } else {
                                echo '<td class="ta-center"><i class="fas fa-file-medical"></i></td>';
                            }
                        }
                        echo '</tr>';
                    }
                }
            } else {
                echo 'NO HAY PERSONAS REGISTROS';
            }
            break;
        case 'OBTENER_DATOS_CITA':
            $cita = $objCita->ObtenerDatosCita($_POST['idcita']);
            $cita = $cita->fetchAll(PDO::FETCH_NAMED);
            $cita = ['cita' => $cita];
            echo json_encode($cita);
            break;
        case 'APERTURAR_CAJA':
            session_start();
            $fecha = date('Y/m/d H:i:s');
            $monto = $_POST['montoinicial'];
            $tipo_mov = $_POST['tipo_movimiento'];
            $descripcion = $_POST['descripcion'];
            $monto_cierre = 0.0;

            $cajadiaria = [
                'fecha_apertura' => $fecha,
                'monto_apertura' => $monto,
                'monto_cierre' => $monto_cierre,
            ];
            //REGISTRO EN BASE DE DATOS
            $objCaja->aperturarCaja($cajadiaria);
            $ult_caja = $objCaja->obtenerUltimaCajaAperturada();
            $ult_caja = $ult_caja->fetch(PDO::FETCH_NAMED);
            $detalle_caja = [
                'idtipopago' => 1,
                'idcajadiaria' => $ult_caja['idcajadiaria'],
                'tipomovimientocaja' => $tipo_mov,
                'descripcion' => $descripcion,
                'monto' => $monto,
                'codigoreferencia' => 0,
                'fecha' => $fecha,
                'idusuario' => $_SESSION['iduser'],
            ];
            $objCaja->insertaDetalleCaja($detalle_caja);
            $ultimaapertura = $ult_caja['fecha_apertura'];
            echo $ultimaapertura;

            break;
        case 'CERRAR_CAJA':
            session_start();
            $fecha = date('Y/m/d H:i:s');
            $idcaja = $_POST['idcajadiaria'];

            $cajadiaria = [
                'fecha_cierre' => $fecha,
                'idcajadiaria' => $idcaja,
                'monto_cierre' => $_POST['montocierre'],
                //'monto_cierre' => 0.0,
            ];

            //REGISTRO EN BASE DE DATOS
            $objCaja->cierreCaja($cajadiaria);
            echo 'CAJA CERRADA';

            break;
        case 'VERIFICAR_CAJA':
            $datoscaja = $objCaja->obtenerUltimaCajaAperturada();
            if ($datoscaja->rowCount() > 0) {
                $datoscaja = $datoscaja->fetchAll(PDO::FETCH_NAMED);
                $datoscaja = ['datoscaja' => $datoscaja];
                echo json_encode($datoscaja);
            } else {
                echo 'SIN REGISTRO';
            }
            break;
        case 'REGISTRAR_GASTO':
            session_start();
            $idusuario = $_SESSION['iduser'];
            $fecha = date('Y/m/d H:i:s');
            $monto = $_POST['MontoGasto'];
            $tipo_mov = 'GASTO';
            $descripcion = $_POST['DescripcionGasto'];

            $ult_caja = $objCaja->obtenerUltimaCajaAperturada();
            $ult_caja = $ult_caja->fetch(PDO::FETCH_NAMED);

            $movimientocaja = [
                'idtipopago' => '1',
                'idcajadiaria' => $ult_caja['idcajadiaria'],
                'tipomovimientocaja' => 'GASTO',
                'descripcion' => $descripcion,
                'monto' => $monto,
                'codigoreferencia' => 0,
                'fecha' => $fecha,
                'idusuario' => $idusuario,
            ];
            //REGISTRO EN BASE DE DATOS
            $objCaja->insertaDetalleCaja($movimientocaja);
            echo 'GASTO REALIZADO';
            break;
        case 'LISTAR_GASTOS':
            session_start();
            $listadogastos = $objCaja->listarGastos($_POST['idcajadiaria']);

            while ($fila = $listadogastos->fetch(PDO::FETCH_NAMED)) {
                echo '<tr>';
                echo '<td class="td-nvisible">' .
                    $fila['idmovimientocaja'] .
                    '</td>';
                echo '<td class="ta-center">' . $fila['fecha'] . '</td>';
                echo '<td class="ta-center">' . $fila['descripcion'] . '</td>';
                echo '<td class="ta-center">' . $fila['monto'] . '</td>';
                echo '<td class="ta-center">' . $fila['nick'] . '</td>';
                echo '</tr>';
            }
            break;
        case 'LISTAR_ULTIMOS_INGRESOS':
            session_start();
            $ultimosingresos = $objCaja->Listar5Ultimasventas(
                $_POST['idcajadiaria']
            );

            while ($fila = $ultimosingresos->fetch(PDO::FETCH_NAMED)) {
                echo '<tr>';
                echo '<td class="td-nvisible">' .
                    $fila['idmovimientocaja'] .
                    '</td>';
                echo '<td class="ta-center">' . $fila['fecha'] . '</td>';
                echo '<td class="ta-center">' . $fila['descripcion'] . '</td>';
                echo '<td class="ta-center">' . $fila['monto'] . '</td>';
                echo '<td class="ta-center">' . $fila['nick'] . '</td>';
                echo '<td class="ta-center">' . $fila['tipopago'] . '</td>';
                echo '</tr>';
            }
            break;
        case 'LISTAR_MONTOS':
            session_start();
            $totalcaja = 0;
            //SUMA DE GASTOS
            $sumagastos = $objCaja->calculosCaja(
                $_POST['idcajadiaria'],
                'GASTO'
            );
            $sumagastos = $sumagastos->fetch(PDO::FETCH_NAMED);
            // SUMA DE INGRESOS A CAJA
            $sumaingresosCaja = $objCaja->calculosCaja(
                $_POST['idcajadiaria'],
                'INGRESO'
            );
            $sumaingresosCaja = $sumaingresosCaja->fetch(PDO::FETCH_NAMED);

            //SUMA DE INGRESOS TOTALES
            $sumaingresosTotales = $objCaja->calculosUtilidadTotal(
                $_POST['idcajadiaria'],
                'INGRESO'
            );
            $sumaingresosTotales = $sumaingresosTotales->fetch(
                PDO::FETCH_NAMED
            );

            $ult_caja = $objCaja->obtenerUltimaCajaAperturada();
            $ult_caja = $ult_caja->fetch(PDO::FETCH_NAMED);

            $otros_calculos = $objCaja->calculosOtrosIngresos(
                $ult_caja['fecha_apertura']
            );
            //$otros_calculos = $otros_calculos->fetch(PDO::FETCH_NAMED);
            echo '<tr>';
            echo '<td>EFECTIVO:</td>';
            echo '<td>' . $sumaingresosCaja['suma'] . '</td>';
            echo '</tr>';
            while ($fila = $otros_calculos->fetch(PDO::FETCH_NAMED)) {
                echo '<tr>';
                echo '<td>' . $fila['tipopago'] . '</td>';
                echo '<td>' . $fila['suma'] . '</td>';
                echo '</tr>';
            }
            echo '<tr>';
            echo '<td>APERTURA CAJA</td>';
            echo '<td>' . $ult_caja['monto_apertura'] . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>GASTOS:</td>';
            echo '<td>' . $sumagastos['suma'] . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td class="negrita">TOTAL EN CAJA:</td>';
            $totalcaja =
                $sumaingresosCaja['suma'] +
                $ult_caja['monto_apertura'] -
                $sumagastos['suma'];
            echo '<td id="totalcaja" class="negrita">' . $totalcaja . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td class="negrita">TOTAL UTILIDAD:</td>';
            echo '<td id="total_utilidad" class="negrita">' .
                $sumaingresosTotales['suma'] .
                '</td>';
            echo '</tr>';

            break;
        case 'REGISTRAR_PAGO':
            session_start();
            $idusuario = $_SESSION['iduser'];
            $fecha = date('Y/m/d H:i:s');
            $tipo_mov = 'INGRESO';
            $descripcion = 'PAGO POR ' . $_POST['MotivoPago'];
            $MontoTotal = $_POST['PrecioPago'];
            $MontoPagado = $_POST['ACuentaPago'];
            $estadoCita = '';

            //REGISTRO EN BASE DE DATOS
            $ult_caja = $objCaja->obtenerUltimaCajaAperturada();
            $ult_caja = $ult_caja->fetch(PDO::FETCH_NAMED);
            $detalle_caja = [
                'idtipopago' => $_POST['tipopago'],
                'idcajadiaria' => $ult_caja['idcajadiaria'],
                'tipomovimientocaja' => $tipo_mov,
                'descripcion' => $descripcion,
                'monto' => $MontoPagado,
                'codigoreferencia' => $_POST['IdCita'],
                'fecha' => $fecha,
                'idusuario' => $idusuario,
            ];
            $objCaja->insertaDetalleCaja($detalle_caja);
            /*Último idmovimientoCaja */
            $ult_movimientoCaja = $objCaja->ObtenerUltimoMovimientoCaja();
            $ult_movimientoCaja = $ult_movimientoCaja->fetch(PDO::FETCH_NAMED);
            //Actualizar estado de cita a PAGADO O PAGO A CUENTA
            if ($MontoTotal > $MontoPagado) {
                $estadoCita = 'A CUENTA';
            } else {
                $estadoCita = 'PAGADO';
            }
            $objCita->ActualizarEstadoCita($_POST['IdCita'], $estadoCita);
            // Obtener datos de cita para usarlos en atención
            $DatosCita = $objCita->ObtenerDatosCita($_POST['IdCita']);
            $DatosCita = $DatosCita->fetch(PDO::FETCH_NAMED);

            $atencion = [
                'idpaciente' => $DatosCita['dni'],
                'idtipoatencion' => $DatosCita['idtipoatencion'],
                'idmovimiento' => $ult_movimientoCaja['idmovimientocaja'],
                'idusuario' => $idusuario,
                'fechaatencion' => null,
                'motivoconsulta' => '-',
                'antecedente' => '-',
                'anamensis' => '-',
                'exfisico' => '-',
                'diagnostico' => '-',
                'tratamiento' => '-',
                'examen' => '-',
                'estado' => 'INICIADO',
            ];

            $objAtencion->RegistrarAtencion($atencion);
            echo $_POST['IdCita'];

            break;
        case 'REGISTRAR_ATENCION':
            session_start();
            $idusuario = $_SESSION['iduser'];
            $fecha = date('Y/m/d H:i:s');
            $paciente = $_POST['dni_atencion'];
            //REGISTRO EN BASE DE DATOS
            $atencion = [
                'idatencion' => $_POST['ate_idatencion'],
                'idusuario' => $idusuario,
                'fechaatencion' => $fecha,
                'motivoconsulta' => $_POST['ate_molestia'],
                'antecedente' => $_POST['ate_antecedentes'],
                'anamensis' => $_POST['txtanamnesis'],
                'exfisico' => $_POST['txtexamenfisico'],
                'diagnostico' => $_POST['txtdiagnostico'],
                'tratamiento' => $_POST['txttratamiento'],
                'estado' => 'FINALIZADO',
            ];
            if ($_POST['typeAction'] === 'REGISTRAR')
                $objAtencion->ActualizarAtencion($atencion);
            else $objAtencion->editarAtencion($atencion);
            //ACTUALIZACIÓN O REGISTRO DE ANTECEDENTES
            $antecedentesGen = [
                'dni' => $paciente,
                'HTA' => $_POST['hta'],
                'HIV' => $_POST['hiv'],
                'DM' => $_POST['dm'],
                'HEPATITIS' => $_POST['hep'],
                'ALERGIAS' => $_POST['alergias'],
            ];
            $existe_antecedentesGen = $objAntecedentes->obtenerAntecedentesGenerales(
                $paciente
            );
            if ($existe_antecedentesGen->rowCount() > 0) {
                $objAntecedentes->ActualizarAntecedentesGenerales(
                    $antecedentesGen
                );
            } else {
                $objAntecedentes->RegistrarAntecedentesGenerales(
                    $antecedentesGen
                );
            }
            //REGISTRO ANTECEDENTES QUIRURGICOS
            $antecedentesAte = [
                'idatencion' => $_POST['ate_idatencion'],
                'cirugias' => $_POST['cirugias'],
                'endoscopias' => $_POST['endoscopias'],
                'covid' => $_POST['covid'],
            ];
            $objAntecedentes->RegistrarAntecedentesAtencion($antecedentesAte);
            echo 'SE REGISTRÓ ATENCIÓN';
            break;
        case 'LISTAR_ATENCIONES':
            session_start();
            $filtro = $_POST['fecha'];
            $ListadoAtenciones = $objAtencion->ListarAtencionesFecha($filtro);
            if ($ListadoAtenciones->rowCount() > 0) {
                while ($fila = $ListadoAtenciones->fetch(PDO::FETCH_NAMED)) {
                    echo '<tr>';
                    echo '<td class="ta-center td-nvisible">' .
                        $fila['idatencion'] .
                        '</td>';
                    echo '<td class="ta-center td-nvisible">' .
                        $fila['dni'] .
                        '</td>';
                    echo '<td class="ta-center">' .
                        $fila['fechaatencion'] .
                        '</td>';
                    echo '<td class="ta-center">' . $fila['paciente'] . '</td>';
                    echo '<td class="ta-center">' . $fila['motivo'] . '</td>';
                    if ($_SESSION['cargo'] == 1) {
                        echo '<td class="ta-center"><i class="far fa-eye"></i></td>';
                    }
                    /*echo '<td class="ta-center"><i class="far fa-edit"></i></td>
                     <td class="ta-center"><i class="far fa-trash-alt"></i></td>';*/
                    echo '</tr>';
                }
            } else {
                echo 'NO HAY PERSONAS CITADAS';
            }

            break;
        case 'LISTAR_ATENCIONES_PACIENTE':
            session_start();
            $filtro = $_POST['dni'];
            $atenciones = $objAtencion->ListarAtencionesPorPaciente($filtro);
            if ($atenciones->rowCount() > 0) {
                while ($fila = $atenciones->fetch(PDO::FETCH_NAMED)) {
                    $fecha = date_create($fila['fechaatencion']);
                    if ($fila['nombre'] === 'CONSULTA MÉDICA') {
                        echo '<li><a href="javascript:void(0)" onclick="VerAtencion(' .
                            $fila['idatencion'] .
                            ')" >' .
                            date_format($fecha, 'd-m-Y H:i') .
                            ' - ' .
                            $fila['nombre'] .
                            '</a></li>';
                    } else {
                        echo '<li><a href="javascript:void(0)" onclick="VerExamen(' .
                            $fila['idatencion'] .
                            ')" >' .
                            date_format($fecha, 'd-m-Y H:i') .
                            ' - ' .
                            $fila['nombre'] .
                            '</a></li>';
                    }
                }
            } else {
                echo 'NO REGISTRA ATENCIONES';
            }
            break;
        case 'REGISTRAR_SIGNOS_VITALES':
            session_start();
            $idatencion = $_POST['idatencion_signos'];
            $SignosVitales = [
                'idatencion' => $idatencion,
                'fr' => $_POST['fr_signosv'],
                'peso' => $_POST['peso_signosv'],
                'so2' => $_POST['so2_signosv'],
                'temp' => $_POST['temp_signosv'],
                'pa' => $_POST['pa_signosv'],
            ];
            //CONSULTA
            $signos = $objAtencion->ObtenerSignosVitales($idatencion);
            if ($signos->rowCount() > 0) {
                $objAtencion->ActualizarSignosVitales($SignosVitales);
            } else {
                $objAtencion->RegistrarSignosVitales($SignosVitales);
            }
            echo 'SIGNOS VITALES REALIZADOS';
            break;
        case 'OBTENER_DATOS_ATENCION':
            $atencion = $objAtencion->ObtenerDatosAtencion(
                $_POST['idatencion']
            );
            $atencion = $atencion->fetchAll(PDO::FETCH_NAMED);
            $atencion = ['atencion' => $atencion];
            echo json_encode($atencion);
            break;
        case 'OBTENER_DATOS_EXAMEN':
            $atencion = $objAtencion->ObtenerExamen($_POST['idatencion']);
            $atencion = $atencion->fetchAll(PDO::FETCH_NAMED);
            $atencion = ['atencion' => $atencion];
            echo json_encode($atencion);
            break;
        case 'OBTENER_ANTECEDENTES_G':
            $antecedentesgenerales = $objAntecedentes->obtenerAntecedentesGenerales(
                $_POST['dni']
            );
            $antecedentesgenerales = $antecedentesgenerales->fetchAll(
                PDO::FETCH_NAMED
            );
            $antecedentesgenerales = [
                'antecedentesgenerales' => $antecedentesgenerales,
            ];
            echo json_encode($antecedentesgenerales);
            break;
        case 'OBTENER_SIGNOS_VITALES':
            $signos = $objAtencion->ObtenerSignosVitales($_POST['idatencion']);
            if ($signos->rowCount() > 0) {
                $signos = $signos->fetchAll(PDO::FETCH_NAMED);
                $signos = ['signos' => $signos];
                echo json_encode($signos);
            } else {
                echo 'SIGNOS NO REGISTRADOS';
            }
            break;
        case 'REGISTRAR_PROCEDIMIENTO':
            $procedimiento = [
                'nombre' => $_POST['NombreProcedimiento'],
                'precio' => $_POST['PrecioProcedimiento'],
            ];
            $objProcedimiento->RegistrarProcedimiento($procedimiento);
            echo 'PROCEDIMIENTO REGISTRADO CORRECTAMENTE';
            break;
        case 'ACTUALIZAR_PROCEDIMIENTO':
            $procedimiento = [
                'idtipoatencion' => $_POST['idprocedimiento'],
                'nombre' => $_POST['NombreProcedimiento'],
                'precio' => $_POST['PrecioProcedimiento'],
            ];
            $objProcedimiento->ActualizarProcedimiento($procedimiento);
            echo 'ACTUALIZADO CORRECTAMENTE';
            break;
        case 'ELIMINAR_PROCEDIMIENTO':
            $idprocedimiento = $_POST['idprocedimiento'];
            $proc_existe = $objProcedimiento->VerificarRegistros(
                $idprocedimiento
            );

            if ($proc_existe->rowCount() < 1) {
                $objProcedimiento->EliminarProcedimiento($idprocedimiento);
                echo 'SE ELIMINÓ PROCEDIMIENTO';
            } else {
                echo 'NO SE PUEDE ELIMINAR TIPO ATENCIÓN PORQUE CONTIENE REGISTROS, EDITE LA INFORMACIÓN';
            }
            break;

        case 'LISTAR_PROCEDIMIENTOS':
            session_start();
            $filtro = $_POST['filtro'];
            if (empty($filtro)) {
                $listadoprocedimientos = $objProcedimiento->ListarProcedimientos();
            } else {
                $listadoprocedimientos = $objProcedimiento->FiltrarProcedimiento(
                    $filtro
                );
            }
            while ($fila = $listadoprocedimientos->fetch(PDO::FETCH_NAMED)) {
                echo '<tr>';
                echo '<td class="ta-center">' .
                    $fila['idtipoatencion'] .
                    '</td>';
                echo '<td class="ta-center">' . $fila['nombre'] . '</td>';
                echo '<td class="ta-center">' . $fila['precio'] . '</td>';
                echo '<td class="ta-center"><i class="far fa-edit"></i></td>
                    <td class="ta-center"><i class="far fa-trash-alt"></i></td>';
                echo '</tr>';
            }
            break;
        case 'VALIDAR_LOGIN':
            $usuario = [
                'user' => $_POST['user'],
                'pass' => md5($_POST['pass']),
            ];
            $user_existe = $objPersonal->validarUsuario($usuario);
            if ($user_existe->rowCount() > 0) {
                $user_existe = $user_existe->fetch(PDO::FETCH_NAMED);
                session_start();
                $_SESSION['active'] = true;
                $_SESSION['nombre'] = $user_existe['nombre'];
                $_SESSION['apellidos'] = $user_existe['apellidos'];
                $_SESSION['iduser'] = $user_existe['dni'];
                $_SESSION['cargo'] = $user_existe['idcargo'];
                echo 'INICIO';
            } else {
                echo 'FAIL';
            }
            break;
        case 'LOGOUT':
            session_start();
            $_SESSION['active'] = false;
            session_destroy();
            echo '1';
            break;
        case 'LISTAR_REPORTE':
            session_start();
            $fecha1 = $_POST['fecha1'];
            $fecha2 = $_POST['fecha2'];

            $fecha1 .= ' 00:00:00';
            $fecha2 .= ' 23:59:59';
            $filtro = [
                'tipomovimientocaja' => $_POST['tipomovimientocaja'],
                'fecha1' => $fecha1,
                'fecha2' => $fecha2,
            ];
            $listadoreporte = $objConsultas->ReporteCantidades($filtro);

            while ($fila = $listadoreporte->fetch(PDO::FETCH_NAMED)) {
                $tipomovimiento = $fila['tipomovimientocaja'];
                $codigoreferencia = $fila['codigoreferencia'];
                $paciente = $objCita->ObtenerDatosCita($codigoreferencia);
                $paciente = $paciente->fetch(PDO::FETCH_NAMED);
                $paciente = $paciente['apellidospaciente'] . ', ' . $paciente['nombrepaciente'];
                $estado = '';
                if ($tipomovimiento === 'A-INGRESO' || $tipomovimiento === 'A-GASTO') $estado = 'ANULADO';
                echo '<tr>';
                echo '<td class="td-nvisible">' .
                    $fila['idmovimientocaja'] .
                    '</td>';
                echo '<td class="ta-center">' . $fila['fecha'] . '</td>';
                echo '<td class="ta-center">' . $paciente . '</td>';
                echo '<td class="ta-center">' . $fila['descripcion'] . '</td>';
                echo '<td class="ta-center">' . $fila['monto'] . '</td>';
                echo '<td class="ta-center">' . $fila['tipopago'] . '</td>';
                echo '<td class="ta-center">' . $fila['nick'] . '</td>';
                echo '<td class="ta-center lnk-red">' . $estado . '</td>';
                echo '</tr>';
            }
            break;
        case 'CARGAR_ESTABLECIMIENTOS':
            session_start();
            $listadoestablecimientos = $objEstablecimiento->ListarEstablecimientos();
            echo '<option value="0">SELECCIONAR</option>';
            while ($fila = $listadoestablecimientos->fetch(PDO::FETCH_NAMED)) {
                echo '<option value="' .
                    $fila['idhospital'] .
                    '">' .
                    $fila['nombre'] .
                    '</option>';
            }
            break;
        case 'REGISTRAR_ESTABLECIMIENTO':
            $objEstablecimiento->RegistrarEstablecimiento(
                $_POST['establecimiento']
            );
            echo 'ESTABLECIMIENTO REGISTRADO CORRECTAMENTE';
            break;
        case 'REGISTRAR_CITA_EXTERNA':
            $CitaExterna = [
                'paciente' => $_POST['NroDocCitaExt'] . ' - ' . $_POST['NombrePacienteCExt'],
                'idhospital' => $_POST['establecimientoCitaExterna'],
                'idtipoatencion' => $_POST['IdMovitoCitaExterna'],
                'precio' => $_POST['PrecioMotivoCitaExterna'],
                'fecha' => $_POST['FechaCitaExterna'],
                'hora' => $_POST['HoraCitaExterna'],
                'estado' => 'PENDIENTE',
            ];

            $objCita->RegistrarCitaExterna($CitaExterna);
            echo 'CITA EXTERNA REGISTRADA CORRECTAMENTE';
            break;
        case 'LISTAR_CITAS_EXTERNAS':
            session_start();
            $fecha1 = $_POST['fecha1'];
            $fecha2 = $_POST['fecha2'];
            $establecimiento = $_POST['establecimiento'];

            if ($establecimiento == '' || $establecimiento == '0') {
                $listadoCitasExternas = $objCita->ListarCitasExternas(
                    $fecha1,
                    $fecha2
                );
            } else {
                $datos = [
                    'fecha1' => $fecha1,
                    'fecha2' => $fecha2,
                    'establecimiento' => $establecimiento,
                ];
                $listadoCitasExternas = $objCita->FiltrarCitasExternas($datos);
            }
            //$listadoCitasExternas = $objCita->ListarCitasExternas($fecha);
            if ($listadoCitasExternas->rowCount() > 0) {
                while ($fila = $listadoCitasExternas->fetch(PDO::FETCH_NAMED)) {
                    echo '<tr>';
                    echo '<td class="ta-center td-nvisible">' .
                        $fila['idtrabajoexterno'] .
                        '</td>';

                    echo '<td class="ta-center">' . $fila['hora'] . '</td>';
                    echo '<td class="ta-center">' . $fila['fecha'] . '</td>';
                    echo '<td class="ta-center">' . $fila['paciente'] . '</td>';
                    echo '<td class="ta-center">' .
                        $fila['establecimiento'] .
                        '</td>';
                    echo '<td class="ta-center">' . $fila['motivo'] . '</td>';
                    echo '<td class="ta-center">' . $fila['precio'] . '</td>';
                    //echo '<td class="ta-center">' . $fila['estado'] . '</td>';
                    if ($fila['estado'] == 'PENDIENTE') {
                        echo '<td class="ta-center"><i class="far fa-times-circle"></i></td>';
                    } else {
                        echo '<td class="ta-center td-green">' .
                            $fila['estado'] .
                            '</td>';
                    }
                    echo '</tr>';
                }
            } else {
                echo 'NO HAY PERSONAS CITADAS';
            }

            break;
        case 'ANULAR_CITA_EXTERNA':
            $idcitaExterna = $_POST['CodigoCitaExterna'];
            $objCita->AnularCitaExterna($idcitaExterna);
            echo 'SE ANULÓ CITA';
            break;
        case 'LISTAR_MEDICAMENTOS':
            session_start();
            $filtro = $_POST['filtro'];
            if (empty($filtro)) {
                $listadoProductos = $objMedicamentos->ListarProductos();
            } else {
                $listadoProductos = $objMedicamentos->FiltrarMedicamento($filtro);
            }
            if ($listadoProductos->rowCount() > 0) {
                while ($fila = $listadoProductos->fetch(PDO::FETCH_NAMED)) {
                    echo '<tr>';
                    echo '<td class="ta-center">' .
                        $fila['idmedicina'] .
                        '</td>';
                    echo '<td class="ta-center">' . $fila['nombre'] . '</td>';
                    echo '<td class="ta-center">' . $fila['stock'] . '</td>';
                    echo '<td class="ta-center">' . $fila['tipoinsumo'] . '</td>';
                    echo '<td class="ta-center"><i class="far fa-edit"></i></td>';
                    echo '<td class="ta-center"><i class="far fa-times-circle"></i></td>';
                    echo '</tr>';
                }
            } else {
                echo 'NO HAY REGISTROS';
            }
            break;
        case 'REGISTRAR_PRODUCTO':
            session_start();
            $fecha = date('Y/m/d H:i:s');
            $producto = [
                'nombre' => $_POST['nombreMedicamento'],
                'stock' => $_POST['CantidadInicial'],
                'tipoinsumo' => $_POST['TipoInsumo'],
            ];
            $objMedicamentos->RegistrarMedicamento($producto);
            $ultimoProd = $objMedicamentos->ObtenerUltimoProducto();
            $ultimoProd = $ultimoProd->fetch(PDO::FETCH_NAMED);
            $movimiento = [
                'tipomovimiento' => 'I',
                'idproducto' => $ultimoProd['idproducto'],
                'cantidad' => $_POST['CantidadInicial'],
                'descripcion' => 'INGRESO AL SISTEMA',
                'fecha' => $fecha,
                'usuario' => $_SESSION['iduser'],
            ];
            $objMedicamentos->RegistrarMovimientoAlmacen($movimiento);

            echo 'PRODUCTO REGISTRADO CORRECTAMENTE';
            break;
        case 'ACTUALIZAR_PRODUCTO':
            session_start();
            $producto = [
                'nombre' => $_POST['nombreMedicamento'],
                'tipoinsumo' => $_POST['TipoInsumo'],
                'idmedicina' => $_POST['IdProducto_M'],
            ];
            $objMedicamentos->ActualizarMedicamento($producto);

            echo 'PRODUCTO MODIFICADO CORRECTAMENTE';
            break;
        case 'ELIMINAR_MEDICAMENTO':
            //$idmedicamento = $_POST['CodigoCitaExterna'];
            $objMedicamentos->EliminarMedicamento($_POST['idmedicamento']);
            echo 'SE ELIMINÓ MEDICAMENTO';
            break;
        case 'OBTENER_MEDICAMENTO_NOMBRE':
            $medicamento = $objMedicamentos->ObtenerMedicamentoNombre(
                $_POST['filtro']
            );
            if ($medicamento->rowCount() > 0) {
                $medicamento = $medicamento->fetchAll(PDO::FETCH_NAMED);
                $medicamento = ['medicamento' => $medicamento];
                echo json_encode($medicamento);
            } else {
                echo 'NO REGISTRADO';
            }
            break;
        case 'AGREGAR_CARRITO':
            session_start();
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }
            $carrito = $_SESSION['carrito'];
            $item = count($carrito) + 1;
            $carrito[$item] = [
                'codigo' => $_POST['codigo'],
                'medicamento' => $_POST['medicamento'],
                'indicacion' => $_POST['indicacion'],
            ];
            $_SESSION['carrito'] = $carrito;
            llenarcarrito();
            break;
        case 'QUITAR_CARRITO':
            session_start();
            $carrito = $_SESSION['carrito'];
            foreach ($carrito as $k => $v) {
                if ($v['codigo'] == $_POST['codigo']) {
                    unset($carrito[$k]);
                }
            }
            /* ORDENANDO ARRAY CARRITO POR ELIMINAR ELEMENTOS */
            $i = 1;
            $nuevocarrito = [];
            foreach ($carrito as $k => $v) {
                $nuevocarrito[$i] = $carrito[$k];
                $i++;
            }
            $carrito = $nuevocarrito;
            $_SESSION['carrito'] = $carrito;
            llenarcarrito();

            break;
        case 'CANCELAR_CARRITO':
            session_start();
            limpiarcarrito();
            break;
        case 'REGISTRAR_TRATAMIENTO':
            session_start();
            $carrito = $_SESSION['carrito'];

            $detalle = [];
            foreach ($carrito as $k => $v) {
                $itemx = [
                    'idmedicina' => $v['codigo'],
                    //'medicamento' => $v['medicamento'],
                    'indicaciones' => $v['indicacion'],
                ];
                $itemx;
                $detalle[] = $itemx;
            }
            $objAtencion->RegistrarTratamiento(
                $_POST['idatencion_trat'],
                $detalle
            );
            //FIN DE REGISTRO EN BASE DE DATOS
            echo 'SE REGISTRÓ TRATAMIENTO';
            limpiarcarrito();
            break;
        case 'REGISTRAR_MOVIMIENTO_ALM':
            session_start();
            $tipomovimiento = $_POST['movimientoalmacen'];
            $cantidad = $_POST['CantidadProducto'];
            $fecha = date('Y/m/d H:i:s');
            $movimiento = [
                'tipomovimiento' => $tipomovimiento,
                'idproducto' => $_POST['IdProducto'],
                'cantidad' => $cantidad,
                'descripcion' => $_POST['Descripcion'],
                'fecha' => $fecha,
                'usuario' => $_SESSION['iduser'],
            ];
            $objMedicamentos->RegistrarMovimientoAlmacen($movimiento);
            $datosProd = $objMedicamentos->ObtenerDatosProducto($_POST['IdProducto']);
            $datosProd = $datosProd->fetch(PDO::FETCH_NAMED);
            $stockactual = $datosProd['stock'];

            if ($tipomovimiento == 'I') {
                $stockactual = $stockactual + $cantidad;
            } else if ($tipomovimiento == 'S') {
                $stockactual = $stockactual - $cantidad;
            }
            $producto = [
                'idproducto' => $_POST['IdProducto'],
                'stock' => $stockactual,
            ];
            $objMedicamentos->ActualizarStock($producto);
            echo 'SE REGISTRÓ MOVIMIENTO';
            break;
        case 'OBTENER_MOVIMIENTO_CUENTA':
            $idcita = $_POST['idcita'];
            $buscarMovimiento = $objCaja->BuscarMovimientoXcita($idcita);
            $buscarMovimiento = $buscarMovimiento->fetch(PDO::FETCH_NAMED);
            $monto = $buscarMovimiento['monto'];
            //$buscarAtencion = $objAtencion->BuscarAtencionxMovimiento($buscarMovimiento['idmovimientocaja']);
            echo $monto;
            break;
        case 'LISTAR_PENDIENTES':
            session_start();
            $listadoPendientes = $objCita->ListarPendientes();
            if ($listadoPendientes->rowCount() > 0) {
                while ($fila = $listadoPendientes->fetch(PDO::FETCH_NAMED)) {
                    $idcita = $fila['idcita'];
                    $estado = $fila['estado'];
                    echo '<tr>';
                    echo '<td class="ta-center td-nvisible">' .
                        $idcita .
                        '</td>';
                    echo '<td class="ta-center">' . $fila['fecha'] . '</td>';
                    echo '<td class="ta-center">' . $fila['horario'] . '</td>';
                    echo '<td class="ta-center">' . $fila['paciente'] . '</td>';
                    echo '<td class="ta-center">' . $fila['motivo'] . '</td>';
                    echo '<td class="ta-center">' . $fila['telefono'] . '</td>';
                    if ($estado === 'A CUENTA')
                        echo '<td class="ta-center"><a href="javascript:void(0)" class="lnk-RegPago lnk-Ambar">A CUENTA</a></td>';
                    else if ($estado === 'POR PAGAR') echo '<td class="ta-center"><a href="javascript:void(0)" class="lnk-RegPago lnk-red">Registrar Pago</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">NO HAY PAGOS PENDIENTES</td></tr>';
            }
            break;
        case 'LISTAR_OTROS_EXAMENES':
            session_start();
            $filtro = $_POST['dni'];
            $examenes = $objExamenes->ListarOtrosExamenes($filtro);
            if ($examenes->rowCount() > 0) {
                while ($fila = $examenes->fetch(PDO::FETCH_NAMED)) {
                    $fecha = date_create($fila['fecha']);
                    if ($fila['tipoexamen'] === 'IMG') {
                        echo '<li><a href="javascript:void(0)" onclick="VerIMG(' .
                            $fila['idexamen'] .
                            ')" >' .
                            date_format($fecha, 'd-m-Y H:i') .
                            ' - ' .
                            $fila['nombre'] .
                            ' (IMG)' .
                            '</a></li>';
                    } else {
                        echo '<li><a href="javascript:void(0)" onclick="VerPDF(' .
                            $fila['idexamen'] .
                            ')" >' .
                            date_format($fecha, 'd-m-Y H:i') .
                            ' - ' .
                            $fila['nombre'] .
                            ' (PDF)' .
                            '</a></li>';
                    }
                }
            } else {
                echo 'NO REGISTRA ATENCIONES';
            }
            break;
        case 'OBTENER_OTRO_EXAMEN':
            $examenes = $objExamenes->ObtenerDatosOtroexamen(
                $_POST['idexamen']
            );
            $examenes = $examenes->fetchAll(PDO::FETCH_NAMED);
            $examenes = ['examenes' => $examenes];
            echo json_encode($examenes);
            break;
        case 'OBTENER_OTRO_EXAMEN_IMG':
            $examenes = $objExamenes->ObtenerDatosOtroexamen(
                $_POST['idexamen']
            );
            if ($examenes->rowCount() > 0) {
                while ($fila = $examenes->fetch(PDO::FETCH_NAMED)) {
                    echo '<div class="imagen">';
                    echo '<img src="' . $fila['archivo'] . '" alt="">';
                    echo '</div>';
                }
            }
            break;
        case 'KARDEX':
            session_start();
            $fecha1 = $_POST['fecha1'];
            $fecha2 = $_POST['fecha2'];

            $fecha1 .= ' 00:00:00';
            $fecha2 .= ' 23:59:59';

            $datos = [
                'idproducto' => $_POST['idproducto'],
                'fecha1' => $fecha1,
                'fecha2' => $fecha2,
            ];

            $datoskardex = $objConsultas->mostrarDatosKardex($datos);
            /* CALCULOS DE KARDEX */
            $ingresos = $objConsultas->ObtenerCantidadesKardex(
                $datos,
                'I'
            );
            if ($row = $ingresos->fetch(PDO::FETCH_NAMED)) {
                $total_ingresos = $row['tipokardex'];
            }
            $salidas = $objConsultas->ObtenerCantidadesKardex($datos, 'S');
            if ($row = $salidas->fetch(PDO::FETCH_NAMED)) {
                $total_salidas = $row['tipokardex'];
            }
            $inicio_saldo = $total_ingresos - $total_salidas;
            /* --------- ----------- -------------  */
            while ($fila = $datoskardex->fetch(PDO::FETCH_NAMED)) {
                $tipomov = $fila['tipomovimiento'];
                $cantidad = $fila['cantidad'];

                echo '<tr>';
                echo '<td>' . $fila['fecha'] . '</td>';
                //echo '<td>' . $tipomov . '</td>';
                echo '<td>' . $fila['descripcion'] . '</td>';
                echo '<td>' . $fila['nick'] . '</td>';
                if ($tipomov == 'I') {
                    echo '<td class="td-lleno">' . $cantidad . '</td>';
                    echo '<td>-</td>';
                    $inicio_saldo = $inicio_saldo + $cantidad;
                } else {
                    echo '<td>-</td>';
                    echo '<td class="td-lleno">' . $cantidad . '</td>';
                    $inicio_saldo = $inicio_saldo - $cantidad;
                }
                echo '<td>' . $inicio_saldo . '</td>';
                echo '</tr>';
            }
            break;
        case 'VALIDAR_SESION':
            session_start();
            if (empty($_SESSION['active']) || empty($_SESSION['iduser'])) {
                echo 'NECESITA VOLVER A LOGEAR';
            } else {
                echo 'USUARIO LOGEADO';
            }
            break;
            // ---CAMBIOS ↓↓
        case 'ELIMINAR_EXAMEN':
            $idexamen = $_POST['idexamen'];
            $objExamenes->EliminarDetalleExamen($idexamen);
            $objExamenes->EliminarExamen($idexamen);
            echo 'SE HA ELIMINADO EL ARCHIVO';
            break;
    }
}
function llenarcarrito()
{
    $carrito = $_SESSION['carrito'];
    foreach ($carrito as $k => $v) {
        echo '<tr>';
        echo '<td>' .
            $k .
            '</td><td>' .
            $v['codigo'] .
            '</td><td>' .
            $v['medicamento'] .
            '</td><td>' .
            $v['indicacion'] .
            "</td><td class='td_icon'><i class='fas fa-times' onclick='QuitarCarrito(" .
            $v['codigo'] .
            ")' ></i> </td>";
        echo '</tr>';
    }
}
function limpiarcarrito()
{
    $carritovacio = [];
    $_SESSION['carrito'] = $carritovacio;
}
