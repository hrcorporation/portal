<?php



class t5_obras extends conexionPDO
{

    protected $con;
    private $id;
    private $estado;
    private $fecha_creacion;
    private $id_cliente;
    private $nombre_obra;
    private $direccion_obra;



    // Iniciar Conexion
    public function __construct()
    {
        $this->PDO = new conexionPDO();
        $this->con = $this->PDO->connect();
    }

    function data_table_obra_for_cliente($id_cliente)
    {
        $this->id_cliente = intval($id_cliente);
        $sql = "SELECT ct5_IdObras , ct5_NombreObra FROM `ct5_obras` WHERE `ct5_IdTerceros` = :id_cliente";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id_cliente', $this->id_cliente, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $num_reg =  $stmt->rowCount();
            if ($num_reg > 0) {
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $datos_obra['id_obra'] = $fila['ct5_IdObras'];
                    $datos_obra['nombre_obra'] =  $fila['ct5_NombreObra'];
                    $datos[] = $datos_obra;
                }
                return $datos;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function estado2_obra($id_obra)
    {
        $this->id_obra = (int)$id_obra;

        $sql = "SELECT `ct5_estado2` FROM `ct5_obras` WHERE `ct5_IdObras` = :id_obra";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id_obra', $this->id_obra, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $num_reg =  $stmt->rowCount();
            if ($num_reg > 0) {
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $estado_obra2 =  $fila['ct5_estado2'];
                }
                return $estado_obra2;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function option_obras($id_cliente, $id_obra = null)
    {
        $this->id_obra = $id_obra;
        $this->id_cliente = intval($id_cliente);

        $selection = "";
        $option = "<option  selected='true' disabled='disabled'> Seleccione una Obra</option>";
        $sql = "SELECT ct5_IdObras , ct5_NombreObra FROM `ct5_obras` WHERE `ct5_IdTerceros` = :id_cliente";
        //Preparar Conexion
        $stmt = $this->con->prepare($sql);

        // Asignando Datos ARRAY => SQL
        $stmt->bindParam(':id_cliente', $this->id_cliente, PDO::PARAM_INT);
        // Ejecutar 
        if ($stmt->execute()) {
            $num_reg =  $stmt->rowCount();
            if ($num_reg > 0) {
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if ($id_obra == $fila['ct5_IdObras']) {
                        $selection = "selected='true'";
                    } else {
                        $selection  = "";
                    }
                    $option .= '<option value="' . $fila['ct5_IdObras'] . '" ' . $selection . ' >' . $fila['ct5_NombreObra']  . ' </option>';
                }
            } else {
                $option .= "<option  selected='true' disabled='disabled'> No hay Obras </option>";
            }
        } else {
            $option .= "<option  selected='true' disabled='disabled'> Error al cargar Obras </option>";
        }



        //resultado
        return $option;

        //Cerrar Conexion
        $this->PDO->closePDO();
    }


    function sincro_obra_nombre($id_cliente, $nombre_obra)
    {
        $this->nombre_obra = $nombre_obra;
        $this->id_cliente = $id_cliente;
        $sql = "SELECT `ct5_IdObras` FROM `ct5_obras` WHERE `ct5_IdTerceros` = :id_cliente AND `ct5_NombreObra` = :nombre_obra";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id_cliente', $this->id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(':nombre_obra', $this->nombre_obra, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $num_reg =  $stmt->rowCount();
            if ($num_reg > 0) {
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id_obra =  $fila['ct5_IdObras'];
                }
                return $id_obra;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function buscar_obra_nombre($nombre_obra)
    {
        $this->nombre_obra = $nombre_obra;
        $sql = "SELECT `ct5_IdObras` FROM `ct5_obras` WHERE `ct5_NombreObra` = :nombre_obra";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':nombre_obra', $this->nombre_obra, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $num_reg =  $stmt->rowCount();
            if ($num_reg > 0) {
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id_obra =  $fila['ct5_IdObras'];
                }
                return $id_obra;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }



    function Select_Obra($id_cliente)
    {
        $this->id_cliente = $id_cliente;
        $error =  '<option value="0">Error al cargar Obras</option>';
        $datos = "";
        $rowsArray_obra = "";
        $sql = "SELECT `ct5_IdObras`, `ct5_EstadoObra`,`ct5_NombreObra` FROM `ct5_obras` WHERE ct5_obras.ct5_IdTerceros = :id_cliente";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id_cliente', $this->id_cliente, PDO::PARAM_INT);

        // $stmt->bind_param("i", $id_cliente);

        if ($stmt->execute()) {
            $rowsArray_obra .= '<option value="0">Seleccionar Obras</option>';

            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rowsArray_obra .= '<option  value="' . $fila['ct5_IdObras'] . '">' . $fila['ct5_NombreObra'] . '</option>';
            }
            return $rowsArray_obra;
        } else {
            return false;
        }
    }



    function option_obra_edit2($id_obra)
    {

        $option = "<option  selected='true' disabled='disabled'> Seleccione una Obra</option>";
        $sql = "SELECT * FROM `ct5_obras` ";
        //Preparar Conexion
        $stmt = $this->con->prepare($sql);

    
        // Asignando Datos ARRAY => SQL


        // Ejecutar 
        $result = $stmt->execute();


        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($id_obra == $fila['ct5_IdObras']) {
                $selection = "selected='true'";
            } else {
                $selection = "";
            }
            $option .= '<option value="' . $fila['ct5_IdObras'] . '" ' . $selection . ' >' . $fila['ct5_NombreObra']  . ' </option>';
        }

        //Cerrar Conexion
        $this->PDO->closePDO();

        //resultado
        return $option;
    }
    function option_obra($id_cliente, $id_obra = null)
    {
        $this->id = $id_cliente;
        $option = "<option  selected='true' disabled='disabled'> Seleccione una Obra</option>";
        $sql = "SELECT * FROM `ct5_obras` WHERE `ct5_IdTerceros` = :id_cliente";
        //Preparar Conexion
        $stmt = $this->con->prepare($sql);

        // Asignando Datos ARRAY => SQL
        $stmt->bindParam(':id_cliente', $this->id, PDO::PARAM_INT);
        // Ejecutar 
        $result = $stmt->execute();


        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($id_obra == $fila['ct5_IdObras']) {
                $selection = "selected='true'";
            } else {
                $selection = "";
            }
            $option .= '<option value="' . $fila['ct5_IdObras'] . '" ' . $selection . ' >' . $fila['ct5_NombreObra']  . ' </option>';
        }

        //Cerrar Conexion
        $this->PDO->closePDO();

        //resultado
        return $option;
    }


    function eliminar_obra($id)
    {
        $this->id = $id;

        $sql = "DELETE FROM `ct5_obras` WHERE `ct5_IdObras` = :id_obra";

        //Preparar Conexion
        $stmt = $this->con->prepare($sql);

        // Asignando Datos ARRAY => SQL
        $stmt->bindParam(':id_obra', $this->id, PDO::PARAM_INT);
        // Ejecutar 
        $result = $stmt->execute();

        //Cerrar Conexion
        $this->PDO->closePDO();

        //resultado
        return $result;
    }



    function option_obra_edit($id_cliente, $id_obra)
    {
        $this->id = $id_cliente;
        $option = "<option  selected='true' disabled='disabled'> Seleccione una Obra</option>";
        $sql = "SELECT * FROM `ct5_obras` WHERE `ct5_IdTerceros` = :id_cliente";
        //Preparar Conexion
        $stmt = $this->con->prepare($sql);

        // Asignando Datos ARRAY => SQL
        $stmt->bindParam(':id_cliente', $this->id, PDO::PARAM_INT);
        // Ejecutar 
        $result = $stmt->execute();


        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($id_obra == $fila['ct5_IdObras']) {
                $selection = "selected='true'";
            } else {
                $selection = "";
            }
            $option .= '<option value="' . $fila['ct5_IdObras'] . '" ' . $selection . ' >' . $fila['ct5_NombreObra']  . ' </option>';
        }

        //Cerrar Conexion
        $this->PDO->closePDO();

        //resultado
        return $option;
    }

    function select_obras_id_for_table($id_obra)
    {

        $this->id = $id_obra;

        $sql = "SELECT ct5_NombreObra, ct5_IdTerceros FROM `ct5_obras` WHERE `ct5_IdObras` = :id_obra";
        //Preparar Conexion
        $stmt = $this->con->prepare($sql);

        // Asignando Datos ARRAY => SQL
        $stmt->bindParam(':id_obra', $this->id, PDO::PARAM_INT);
        // Ejecutar 
        if ($result = $stmt->execute()) {
            $num_reg =  $stmt->rowCount();
            if ($num_reg > 0) {
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) { // Obtener los datos de los valores
                    $datos[] = $fila;
                }
                return $datos;
            } else {
                return false;
            }
        } else {
            return false;
        }

        //Cerrar Conexion
        $this->PDO->closePDO();

        //resultado

    }
    function select_obras_id($id_obra)
    {

        $this->id = $id_obra;

        $sql = "SELECT * FROM `ct5_obras` WHERE `ct5_IdObras` = :id_obra";
        //Preparar Conexion
        $stmt = $this->con->prepare($sql);

        // Asignando Datos ARRAY => SQL
        $stmt->bindParam(':id_obra', $this->id, PDO::PARAM_INT);
        // Ejecutar 
        $result = $stmt->execute();

        //Cerrar Conexion
        $this->PDO->closePDO();

        //resultado
        return $stmt;
    }

    function select_obras()
    {


        $sql = "SELECT * FROM ct5_obras ORDER BY `ct5_IdObras` DESC";
        //Preparar Conexion
        $stmt = $this->con->prepare($sql);

        // Asignando Datos ARRAY => SQL
        //$stmt->bindParam(':id_tercero', $this->id, PDO::PARAM_INT);
        // Ejecutar 
        $result = $stmt->execute();

        //Cerrar Conexion
        $this->PDO->closePDO();

        //resultado
        return $stmt;
    }

    function insertar_obra($id_cliente, $nombre_obra, $direccion_obra = null, $fecha_creacion)
    {
        $this->estado = 1;
        $this->fecha_creacion = $fecha_creacion;
        $this->id_cliente = $id_cliente;
        $this->nombre_obra = $nombre_obra;
        $this->direccion_obra = $direccion_obra;


        $sql = "INSERT INTO `ct5_obras`(`ct5_EstadoObra`, `ct5_FechaCreacion`, `ct5_IdTerceros`, `ct5_NombreObra`, `ct5_DireccionObra`) VALUES (:estado, :fecha_creacion, :id_cliente, :nombre_obra, :direccion_obra)";
        $stmt = $this->con->prepare($sql);

        $stmt->bindParam(':estado', $this->estado, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_creacion', $this->fecha_creacion, PDO::PARAM_STR);
        $stmt->bindParam(':id_cliente', $this->id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(':nombre_obra', $this->nombre_obra, PDO::PARAM_STR);
        $stmt->bindParam(':direccion_obra', $this->direccion_obra, PDO::PARAM_STR);

        $result = $stmt->execute();


        return $result;
        //Cerrar Conexion
        $this->PDO->closePDO();
    }

    function editar_obra($id_obra, $id_cliente, $nombre_obra, $direccion_obra,$segmento,$departamento, $ciudad )
    {


        $this->id_cliente = $id_cliente;
        $this->nombre_obra = $nombre_obra;
        $this->direccion_obra = $direccion_obra;
        $this->id = $id_obra;
        $this->segmento = $segmento;
        $this->departamento = $departamento;
        $this->ciudad = $ciudad;


        $sql = "UPDATE `ct5_obras` SET `ct5_IdTerceros`= :id_cliente,`ct5_NombreObra`= :nombre_obra,`ct5_DireccionObra`= :direccion_obra, ct5_segmento = :segmento, ct5_id_departamento = :departamento , ct5_id_ciudad = :ciudad  WHERE `ct5_IdObras` = :id_obra";
        //$sql="INSERT INTO `ct5_obras`(`ct5_EstadoObra`, `ct5_FechaCreacion`, `ct5_IdTerceros`, `ct5_NombreObra`, `ct5_DireccionObra`) VALUES (:estado, :fecha_creacion, :id_cliente, :nombre_obra, :direccion_obra)";
        $stmt = $this->con->prepare($sql);




        $stmt->bindParam(':id_cliente',  $this->id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(':nombre_obra', $this->nombre_obra, PDO::PARAM_STR);
        $stmt->bindParam(':direccion_obra', $this->direccion_obra, PDO::PARAM_STR);
        $stmt->bindParam(':segmento', $this->segmento, PDO::PARAM_STR);
        $stmt->bindParam(':departamento', $this->departamento, PDO::PARAM_STR);
        $stmt->bindParam(':ciudad', $this->ciudad, PDO::PARAM_STR);
        $stmt->bindParam(':id_obra',  $this->id, PDO::PARAM_INT);

        $result = $stmt->execute();
        //Cerrar Conexion
        $this->PDO->closePDO();

        return $result;
    }
}
