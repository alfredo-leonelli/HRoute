<?php
    
    /**
     * getNivelOptions
     *
     * @param  mixed $nivel_id
     * @return void
     */
    function getNivelOptions($nivel_id) {
        require 'database.php';
        $consulta = "select * from NIVEL_PRIORIDAD";
        $resultado = mysqli_prepare($conexion, $consulta);

        if(!$resultado) {
            echo "Error: ".mysqli_error($conexion);
        }
        $ok = mysqli_stmt_execute($resultado);

        if(!$ok) {
            echo "Error";
        } else {
            $ok = mysqli_stmt_bind_result($resultado, $r_id, $r_nivel);
            while ($fila = mysqli_stmt_fetch($resultado)) {
                if ($r_id == $nivel_id) {
                    echo "<option value='$r_id' selected>$r_nivel</option>";
                } else {
                    echo "<option value='$r_id'>$r_nivel</option>";
                }
            }
        }
    }
?>