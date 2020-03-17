<?php
    header('Content-type: application/json');
    include("../app/lib/database.php");
    $accion = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

    if($accion == "login"){
        $result = array();
        $username = $_REQUEST['username'];
        $encryptedPwd = sha1($_REQUEST['password']);
        $parametros = array(':usuario' => $username, ':pass' => $encryptedPwd);

        $sql = "SELECT * FROM usuarios WHERE cCorreo = :usuario AND cPassword = :pass";
        $stmt = $pdo->prepare($sql);

        $stmt->execute($parametros);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($result);
        echo json_encode($result);
    }

    if($accion == "crearShow"){
        $result = 0;
        $tema = $_REQUEST['tema'];
        $urlShow = $_REQUEST['urlShow'];
        $fecha = $_REQUEST['fecha'];
        $hora = $_REQUEST['hora'];
        $usuariopk = $_REQUEST['usuariopk'];
        $parametros = array(
            ':tema' => $tema, 
            ':urlShow' => $urlShow,
            ':fecha' => $fecha
            ':hora' => $hora
            ':usuariopk' => $usuariopk
        );

        $sql = "INSERT INTO programas (nUsuarioPK, dFecha, cHora, cTema, cUrl) VALUES (:usuariopk,:fecha,:hora,:tema,:urlShow)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute($parametros);
        $result = $pdo->lastInsertId();
        //var_dump($result);
        echo $result;
    }

    if($accion == "obtenerProgramas"){
        $result = array();
        $sql = "SELECT p.*, u.cNombre, u.cApellido FROM programas p INNER JOIN $this->innertable u ON u.nUsuarioPK = p.nUsuarioPK";
        $stmt = $pdo->prepare($sql);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($result);
        echo json_encode($result);
    }
    if($accion == "editarPrograma"){
        $result = 0;
        $tema = $_REQUEST['tema'];
        $urlShow = $_REQUEST['urlShow'];
        $fecha = $_REQUEST['fecha'];
        $hora = $_REQUEST['hora'];
        $programapk = $_REQUEST['programapk'];
        $parametros = array(
            ':tema' => $tema, 
            ':urlShow' => $urlShow,
            ':fecha' => $fecha
            ':hora' => $hora
            ':programapk' => $programapk
        );

        $sql = "UPDATE programas SET dFecha=:fecha, cHora=:hora, cTema=:tema, cUrl=:urlShow WHERE nProgramaPK=:programapk";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute($parametros)){
            $result = 1;
        }
        //var_dump($result);
        echo $result;
    }
    if($accion == "eliminarPrograma"){
        $programapk = $_REQUEST['programapk'];
        $parametros = array(
            ':programapk' => $programapk
        );

        $sql = "DELETE FROM programas WHERE nProgramaPK=:programapk";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute($parametros)){
            $result = 1;
        }
        //var_dump($result);
        echo $result;
    }

    
    
?>
