<?php
use App\Model\UserModel;

$app->group('/user/', function () {
    
    $this->post('login', function ($req, $res){
        if(!$_SESSION['logged']){
            $data = $req->getParsedBody();
            $um = new UserModel();
            $query_result = $um->login($data);
            //$this->logger->info(var_dump($query_result));
        
            if($query_result->result){
                $_SESSION['logged'] = 1;
                $_SESSION['nombre'] = $query_result->result['cNombre'];
                $_SESSION['usuariopk'] = $query_result->result['nUsuarioPK'];
                return $res = $this->renderer->render(
                    $res, 
                    'alta_programa.phtml',
                    [
                        "usuariopk" => $query_result->result['nUsuarioPK'],
                        "nombre" => $query_result->result['cNombre']
                    ]);
            }
            else{
                
                return $res = $this->renderer->render(
                    $res, 
                    'index.phtml',
                    [
                        "error" => "Datos incorrectos"
                    ]);
            }
        }
        else {
            return $res = $this->renderer->render(
                $res, 
                'alta_programa.phtml',
                [
                    "usuariopk" => $_SESSION['usuariopk'],
                    "nombre" => $_SESSION['nombre']
                ]);
        }
        
        
    });
    
    $this->post('registrar', function ($req, $res) {
        $um = new UserModel();
        $data = $req->getParsedBody();
        $um = new UserModel();
        $query_result = $um->registrar($data);
        //$this->logger->info(var_dump($query_result));
       
        if($query_result->result){
            return $res = $this->renderer->render(
                $res, 
                'alta_programa.phtml',
                [
                    "usuariopk" => $query_result->result,
                    "nombre" => $data['nombre']
                ]);
        }
        else{
            
            return $res = $this->renderer->render(
                $res, 
                'registro.phtml',
                [
                    "error" => "Ocurrió un error al registrar sus datos"
                ]);
        }
    });
    
});