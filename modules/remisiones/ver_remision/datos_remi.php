<?php

//========================================================================================================
// ENCABEZADO
//========================================================================================================
require '../../../librerias/autoload.php';
require '../../../modelos/autoload.php';
require '../../../vendor/autoload.php';

$php_clases = new php_clases();
$t29_batch = new t29_batch();
$t26_remision = new t26_remisiones();

date_default_timezone_set('America/Bogota');
setlocale(LC_ALL, 'es_ES');
setlocale(LC_TIME, 'es_ES');

$titulo = "";
$metros = 0;


//$datos_array = $t29_batch->select_batch_id($id_batch);

$datos_array = $t26_remision->get_remision($id_remision);

if (isset($datos_array)) {

    foreach ($datos_array as $datos) {
        $estado = $datos['ct26_estado'];
        $num_remi = $datos['ct26_codigo_remi'];
        
        $fecha_remision_remi = $datos['ct26_fecha_remi'];
        //$fecha_remision_remi = "20-10-2020";
        $fecha  = date('Y-m-d', strtotime($fecha_remision_remi));
        $fecha_remision_remi = strftime("%A , %d de %B  del %Y", strtotime($fecha));
        $nombre_cliente_remi = $datos['ct26_razon_social'];
        $nombre_obra =  $datos['ct26_nombre_obra'];
        $hora = $datos['ct26_hora_remi'];
        //$hora = "0:00";
        $placa = $datos['ct26_vehiculo'];
        $conductor = $datos['ct26_nombre_conductor'];
        $sello = $datos['ct26_sello'];
        //$sello = 0000;
        $metros = $datos['ct26_metros'];

        $idplanta = $datos['ct26_idplanta'];
        $descripcion_formula = $datos['ct26_descripcion_producto'];
        $asentamiento = $datos['ct26_asentamiento'];
        
        $despachador = $datos['ct26_despachador'];
        //$despachador = "";
        $producto = $datos['ct26_codigo_producto'];

        $hora_salida = $datos['ct26_hora_salida_planta'];
        $hora_llegada = $datos['ct26_hora_llegada_obra'];
        $hora_inicio = $datos['ct26_hora_inicio_descargue'];
        $hora_terminada = $datos['ct26_hora_terminada_descargue'];


        
        $observaciones_cliente = $datos['ct26_observaciones_cli'];
        $observaciones_funcionario = $datos['ct26_observaciones'];
        $observaciones_despachador = $datos['ct26_observaciones_desp'];


        $observaciones = $observaciones_cliente . " ; " . $observaciones_funcionario. " ; ".$observaciones_despachador;
        
        $nombres_recibido = $datos['ct26_recibido'];
        //$ = $datos[''];

        
        //$ = $datos[''];
        //$ = $datos[''];
    }
    
    switch ($idplanta) 
    {
        case "RMI":
            $planta = "PLANTA";
            $linea_planta = "LINEA 1";
            break;
        case "RZO":
            $planta = "PLANTA ";
            $linea_planta = "LINEA 2";
            break;

            case "RMT":
                $planta = "PLANTA DOS";
                $linea_planta = "CIUDAD TORREON";
    
                break;

        default:
            $planta = "PLANTA";
            $linea_planta = "";
    }
}
