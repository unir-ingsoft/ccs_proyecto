<?php
use App\Model\ProgramaModel;

$app->group('/programa/', function () {
    
    $this->get('get/{id}', function ($req, $res) {
        $rm = new ProgramaModel();
        $query_result = $um->obtener();
        //$this->logger->info(var_dump($query_result));
       
        if($query_result->result){
            return $res = $this->renderer->render(
                $res, 
                'programacion.phtml',
                [
                    "programas" => $query_result->result
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
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $rm->getAll()
            )
        );
    });
    
    $this->post('update', function ($req, $res) {
        $rm = new ProgramaModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $rm->updateByPk(
                    $req->getParsedBody()
                )
            )
        );
    });
    
    $this->post('delete', function ($req, $res) {
        $rm = new ProgramaModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $rm->delete(
                    $req->getParsedBody()
                )
            )
        );
    });
    
});