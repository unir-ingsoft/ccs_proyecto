<?php
    include("lib/database.php");
    $accion = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

    if($accion == "login"){
        $result = array();
        $username = $_REQUEST['username'];
        $encryptedPwd = sha1($_REQUEST['password']);
        $parametros = array(':usuario' => $username, ':pass' => $encryptedPwd);

        $pdo->prepare("SELECT * FROM usuarios WHERE cCorreo = :usuario AND cPassword = :pass");

        $pdo->execute($parametros);
        $result = $pdo->fetch(PDO::FETCH_ASSOC);

        echo json_encode($result);
    }
?>