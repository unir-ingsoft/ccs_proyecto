<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;
use PDO;

class UserModel
{
    private $db;
    private $table = 'usuarios';
    private $response;
    
    public function __CONSTRUCT()
    {
        $this->db = Database::StartUp();
        $this->response = new Response();
    }

    public function login($data){
        try {
            if (isset($data['username']) && isset($data['password'])) {
                $result = array();
                $encryptedPwd = sha1($data['password']);

                $stm = $this->db->prepare("SELECT * FROM $this->table WHERE cCorreo = ? AND cPassword = ?");
                $stm->bindParam(1, $data['email'], PDO::PARAM_STR);
                $stm->bindParam(2, $encryptedPwd, PDO::PARAM_STR);
                $stm->execute();

                $this->response->setResponse(true);
                $result = $stm->fetch(PDO::FETCH_ASSOC);
                $this->response->result = $result;

                if(count($result) > 0) {
                    $this->response->message  = "Ok";
                }
                else {
                    $this->response->message  = "404";
                }
                
            }
            else {
                $this->response->setResponse(false, "Error faltan datos");

            }
            return $this->response;
        }
        catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response
        }
    }
    
    public function registrar($data){
        try
        {   
            $encryptedPwd = sha1($data['pass']);
            $result = 0;
            $stm = $this->db->prepare("INSERT INTO $this->table (cNombre, cApellido, cCorreo, cPassword) VALUES (?,?,?,?)");
            $stm->bindParam(1, $data['nombre'], PDO::PARAM_STR);
            $stm->bindParam(2, $data['apellidos'], PDO::PARAM_STR);
            $stm->bindParam(3, $data['email'], PDO::PARAM_STR);
            $stm->bindParam(4, $encryptedPwd, PDO::PARAM_STR);
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


}