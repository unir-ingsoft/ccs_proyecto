<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use PDO;

class ProgramaModel
{
    private $db;
    private $table = 'programas';
    private $innertable = 'usuarios';
    private $response;
    
    public function __CONSTRUCT()
    {
        $this->db = Database::StartUp();
        $this->response = new Response();
    }

    public function obtener(){
        try
		{
			$result = array();
            $sql = "SELECT p.*, u.cNombre, u.cApellido FROM $this->table p INNER JOIN $this->innertable u ON u.nUsuarioPK = p.nUsuarioPK";
			$stm = $this->db->prepare($sql);
			$stm->execute();
            
			$this->response->setResponse(true);
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            $this->response->result = $result;

            if(count($result) > 0) {
                $this->response->message  = "Ok";
            }
            else {
                $this->response->message  = "404";
            }
            return $this->response;
		}
		catch(PDOExecption $e)
		{
			$this->response->setResponse(false, $e->getMessage());
            return $this->response;
		}
    }
    
    public function crear($data){
        try
        {   
            $result = 0;
            $stm = $this->db->prepare("INSERT INTO $this->table (nUsuarioPK, dFecha, cHora, cTema, cUrl) VALUES (?,?,?,?,?)");
            $stm->bindParam(1, $data['usuariopk'], PDO::PARAM_STR);
            $stm->bindParam(2, $data['fecha'], PDO::PARAM_STR);
            $stm->bindParam(3, $data['hora'], PDO::PARAM_STR);
            $stm->bindParam(4, $data['tema'], PDO::PARAM_STR);
            $stm->bindParam(5, $data['url'], PDO::PARAM_STR);
            $stm->execute();

            
            $this->response->setResponse(true);
            $result = $this->db->lastInsertId();
            $this->response->result = $result;

            if($result > 0) {
                $this->response->message  = "Ok";
            }
            else {
                $this->response->message  = "404";
            }
            return $this->response;
        }
        catch(PDOExecption $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function editar($data){
        try
        {   
            $encryptedPwd = sha1($data['pass']);
            $result = 0;
           
            $stm = $this->db->prepare("UPDATE $this->table SET dFecha=?, cHora=?, cTema=?, cUrl=? WHERE nProgramaPK=?");
            $stm->bindParam(1, $data['fecha'], PDO::PARAM_STR);
            $stm->bindParam(2, $data['hora'], PDO::PARAM_STR);
            $stm->bindParam(3, $data['tema'], PDO::PARAM_STR);
            $stm->bindParam(4, $data['url'], PDO::PARAM_STR);
            $stm->bindParam(5, $data['programapk'], PDO::PARAM_STR);
            $stm->execute();

            
            $this->response->setResponse(true);
            $result = 1;
            $this->response->result = $result;

            $this->response->message  = "Ok";

            return $this->response;
        }
        catch(PDOExecption $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function eliminar($id)
    try
        {   
            $result = 0;
           
            $stm = $this->db->prepare("DELETE FROM $this->table WHERE nProgramaPK=?");
            $stm->bindParam(1, $id], PDO::PARAM_STR);
            $stm->execute();

            
            $this->response->setResponse(true);
            $result = 1;
            $this->response->result = $result;

            $this->response->message  = "Ok";

            return $this->response;
        }
        catch(PDOExecption $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
}