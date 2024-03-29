<?php 
    if(isset($_POST['login'])){
        login();
    }    
    /**
     * Función encargada de verificar los datos ingresados por el usuario para la correcta conexión al sistema.
     * 
     * A través del formulario de login se obtienen los datos del usuario.
     * Luego se realiza la conexión a la base de datos, donde se ingresa la consulta "select" utilizando los datos obtenidos desde el formulario. Una vez
     * ingresada la consulta, se realiza la misma a la base de datos. En el caso de no encontrar coincidencias, se manda un mensaje de error.
     * En el caso contrario, se redirige al usuario a la página principal, dependiendo de su tipo de usuario.
     * 
     * @return void
     */
    function login(){
        session_start();
        require('database.php');
    
        $usuario = $_POST['usuario'];
        $passwd = $_POST['passwd'];
    
        $consulta = "select id, usuario, contrasena, tipo_usuario, piso from usuarios where usuario = ? and contrasena = ?";
    
        $resultado = mysqli_prepare($conexion, $consulta);
            
            
    
        $ok = mysqli_stmt_bind_param($resultado,"ss", $usuario, $passwd);
        $ok = mysqli_stmt_execute($resultado);
        $ok = mysqli_stmt_bind_result($resultado, $r_id, $r_usuario, $r_contra, $r_tipo, $r_piso);
    
        if(!mysqli_stmt_fetch($resultado)){
            $_SESSION['mensaje'] = "Login Fallido, Usuario no encontrado";
            header('location: ../HRoute/index.php');
        }else{
    
            setcookie("usuario", $r_usuario, time() + (86400 * 30)); 
            setcookie("contra", $r_contra, time() + (86400 * 30));
    
            $_SESSION['id'] = $r_id;
            $_SESSION['tipo'] = $r_tipo;
            $_SESSION['piso'] = $r_piso;
            if($r_tipo == 1){
                header('location: ../HRoute/admin/crear.php');
            }else if($r_tipo == 2){
                header('location: ../HRoute/asistente/trasladospendientes.php');
            }else{
                header('location: ../HRoute/enfer/agregar.php');
            }
        }
        mysqli_stmt_close($resultado);
    
        $consulta1 = "update USUARIOS set CONECTADO = 1 where ID = ".$_SESSION['id']."";
        $resultado1 = mysqli_prepare($conexion, $consulta1);
        $ok1 = mysqli_stmt_execute($resultado1);
        mysqli_stmt_close($resultado1);
    
    }
?>