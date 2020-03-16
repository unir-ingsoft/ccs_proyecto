<?php
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
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($result);
    }
?>