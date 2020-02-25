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
            if (isset($data['email']) && isset($data['pass'])) {
                $result = array();
                $encryptedPwd = sha1($data['pass']);

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
                return $this->response;
            }
            else {
                $this->response->setResponse(false, "Error faltan datos");
                return $this->response;
            }
        }
        catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }
    
    public function getData($token){
        try
        {
            $result = array();
            $sql = "Exec mv_SociosSelByToken ?";
            $stm = $this->db->prepare($sql);
            $stm->bindParam(1, $token, PDO::PARAM_STR);
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
            return $this->response;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }


}