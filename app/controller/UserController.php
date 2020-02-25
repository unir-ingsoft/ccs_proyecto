<?php
use App\Model\UserModel;

$app->group('/user/', function () {
    
    $this->post('login', function ($req, $res){
        $data = $req->getParsedBody();
        $um = new UserModel();
        $query_result = $um->login($data);
        
        if($query_result->result != ''){
            $res = $this->renderer->render(
                $res, 
                'alta_programa.phtml',
                array("nombre" => $query_result->result['cNombre']));
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