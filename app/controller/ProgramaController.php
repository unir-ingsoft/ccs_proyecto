<?php
use App\Model\ProgramaModel;

$app->group('/programa/', function () {
    
    $this->get('get/{id}', function ($req, $res, $errorid) {
        $rm = new ProgramaModel();
        $query_result = $rm->obtener();
        //$this->logger->info(var_dump($query_result));
        if ($errorid == 1){
            $msg = "Ocurrio un error al procesar su petición";
        }
        else {
            $msg = "";
        }
        if($query_result->result){
            return $res = $this->renderer->render(
                $res, 
                'programacion.phtml',
                [
                    "programas" => $query_result->result,
                    "msg" => $msg
                ]);
        }
        else{
            return $res = $this->renderer->render(
                $res, 
                'index.phtml',
                [
                    "error" => "Ocurrió un error al obtener la programación"
                ]);
        }
    });

    $this->post('insert', function ($req, $res) {
        $rm = new ProgramaModel();
        $data = $req->getParsedBody();
        $query_result = $rm->crear($data);
        if($query_result->result){
            return $res->withHeader('Location', 'http://kornmexico.com/unirlab02/v1/index.php/programa/get/0');
        }
        else{
            return $res->withHeader('Location', 'http://kornmexico.com/unirlab02/v1/index.php/programa/get/1');
        }
    });
    
    $this->post('update', function ($req, $res) {
        $rm = new ProgramaModel();

        $data = $req->getParsedBody();
        $query_result = $rm->editar($data);
        //$this->logger->info(var_dump($query_result));
       
        if($query_result->result){
            return $res->withHeader('Location', 'http://kornmexico.com/unirlab02/v1/index.php/programa/get/0');
        }
        else{
            return $res->withHeader('Location', 'http://kornmexico.com/unirlab02/v1/index.php/programa/get/1');
        }
        
    });
    
    $this->get('delete/{id}', function ($req, $res, $id) {
        $rm = new ProgramaModel();
        $query_result = $rm->eliminar($id);
        
    });
    if($query_result->result){
        return $res->withHeader('Location', 'http://kornmexico.com/unirlab02/v1/index.php/programa/get/0');
    }
    else{
        return $res->withHeader('Location', 'http://kornmexico.com/unirlab02/v1/index.php/programa/get/1');
    }
});