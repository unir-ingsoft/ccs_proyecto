<?php
namespace Middleware;
use Slim\Http\Request;
use Slim\Http\Response;
class sessionAuth
{
	private $container;

    public function __construct($container) {
        //var_dump($container);
        $this->container = $container;
    }
    function ACL($path){
        //init access list
        $accessList = array(
            array( 
                'path' => "/user/login"
            ),
            array( 
                'path' => "/user/registrar"
            )
        );

        //search access list
        foreach ($accessList as $value) {
            if($value['path'] == $path){
                return false;
            }
        }
        return true;
    }
    public function denyAccess(){
        //http_response_code(401);
        return $res = $this->renderer->render(
            $res, 
            'registro.phtml',
            [
                "error" => "Ocurrió un error al registrar sus datos"
            ]);
        exit;
    }

    public function requireUpgrade() {
    	http_response_code(426);
    	exit;
    }
    
    public function __invoke(Request $request, $response, $next)
    {
    	$token = null;
    	$version = $request->getParam('version');
        $isMobile = $request->getParam('isMobile');

    	//Validate versions
    	$validVersion = $this->container->validateVersion->compare($version, $isMobile);
        
        if($validVersion == 1){
        	if(isset($request->getHeader('Auth')[0])){
	            $token = $request->getHeader('Auth')[0];
	        }

	        //same format as api route
	        $route = $request->getAttribute('route');
	        $path = $route->getPattern();
	        $accessRule = $this->ACL($path);

	        if($accessRule) {
	        	//Authenticate
	        	if ($token != null){
	        		$checkToken = $this->container->tokenAuth->validateToken($token, $isMobile);
	        		if($checkToken != 0){
	        			$response = $next($request, $response);
	        		} 
	        		else{
	        			$this->denyAccess();
	        		}
	        	}
	        	else {
	        		$this->denyAccess();
	        	}
	        }
	        else {
	        	//not authenticate
	        	$response = $next($request, $response);
	        }
        }
        else {
        	$this->requireUpgrade();
        }
        

        return $response
        	->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS'); 
    }
}
?>