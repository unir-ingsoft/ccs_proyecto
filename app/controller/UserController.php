<?php
use App\Model\UserModel;

$app->group('/user/', function () {
    
    $this->post('login', function ($req, $res){
        $data = $req->getParsedBody();
        $um = new UserModel();
        $query_result = $um->login($data);
        //$this->logger->info(var_dump($query_result));
       
        if($query_result->result){
            return $res = $this->renderer->render(
                $res, 
                'alta_programa.phtml',
                [
                    "nombre" => $query_result->result['cNombre']
                ]);
        }
        else{
            $app->redirect('/');
            return $res = $this->renderer->render(
                $res, 
                'index.phtml',
                [
                    "error" => "Datos incorrectos"
                ]);
        }
        
    });
    
    $this->post('registrar', function ($req, $res) {
        $um = new UserModel();
        //$token = $req->getHeader('Auth')[0];
        return $res
        ->withHeader('Content-type', 'application/json')
        ->getBody()
        ->write(
            json_encode($um->registrar($req->getParsedBody()))
        );
    });
    
});