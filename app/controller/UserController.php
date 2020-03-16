<?php
use App\Model\UserModel;

$app->group('/user/', function () {
    
    $this->post('login', function ($req, $res){
        $um = new UserModel();

        return $res
          ->withHeader('Content-type', 'application/json')
          ->getBody()
          ->write(
              json_encode($um->login($req->getParsedBody()))
        );
        
    });
    
    $this->post('registrar', function ($req, $res) {
        $um = new UserModel();
        $data = $req->getParsedBody();
        $um = new UserModel();
        $query_result = $um->registrar($data);
        //$this->logger->info(var_dump($query_result));
       
        if($query_result->result){
            $_SESSION['logged'] = 1;
            $_SESSION['nombre'] = $data['nombre'];
            $_SESSION['usuariopk'] = $query_result->result;
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