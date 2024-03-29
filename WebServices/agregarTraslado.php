<?php
    if(array_key_exists('btnGuardar', $_POST)) {
        agregarTraslado();
    }    
    /**
     * Función encargada de agregar traslados a la base de datos.
     *
     * A través del formulario que se encuentra en la intefaz de enfermero/a obtenemos los datos del traslado. 
     * Luego se conecta a la base de datos donde se intenta agregar datos a través de una consulta "insert". En
     * caso de no poder lograr el ingreso de datos se manda un mensaje de error, en el otro caso se redirige a la
     * intefaz de enfermero/a donde se muestran los traslados. 
     *  
     * @return void
     */
    function agregarTraslado(){
        $origen = $_POST['oriTraslado'];
        $destino = $_POST['desTraslado'];
        $tipo_traslado = $_POST['tipoTraslado'];
        $nivel_prioridad = $_POST['idPrioridad'];
        $nombre_trabajador = 2;
        $nombre_personal = $_POST['nomPersonal'];
        $nombre_paciente = $_POST['nomPaciente'];
    
        require 'database.php';
    
        $consulta = "insert into traslados (ORIGEN, DESTINO, TIPO_TRASLADO, NIVEL_PRIORIDAD, NOMBRE_TRABAJADOR, NOMBRE_PERSONAL, NOMBRE_PACIENTE) values ('".$origen."','".$destino."','".$tipo_traslado."','".$nivel_prioridad."','".$nombre_trabajador."','".$nombre_personal."','".$nombre_paciente."')"; 
    
        $resultado = mysqli_query($conexion, $consulta);
    
        //Acceder a los registros
    
        if(!$resultado){
            echo "Error al insertar: ".mysqli_error($conexion);
        }else{
            header('location: ../enfer/traslados.php');
        }
    
        mysqli_close($conexion);
    }
?>