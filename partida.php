<?php



header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: GET,POST,OPTIONS,DELETE");



/*

API per guardar, carregar o esborrar partides

Només accepta peticions GET, POST & DELETE

*/



$method = $_SERVER['REQUEST_METHOD'];



$token = $_GET["token"];

$slot = "";



if (isset($_GET["slot"])){
    $slot = "partides/" . $token . "_" . $_GET["slot"];
}


switch ($method) {
    
    case 'POST':
        
        if (isset($_POST["json"])) {
            
            if (!file_exists($slot)) {
                
                file_put_contents($slot, $_POST["json"], FILE_APPEND);
                
                http_response_code(200);
                
            }
            
            else
                http_response_code(404);
            
        }
        
        else
            http_response_code(404);
        
        break;
    
    case 'GET':
        
        if ($slot != "") {
            
            if (file_exists($slot)) {
                
                echo file_get_contents($slot);
                
                // Amb resposta
                
                http_response_code(200);
                
            }
            
            else
                http_response_code(404);
            
        }
        
        else {
            
            // Retorna llista
            
            $arr = array();
            
            if (file_exists("partides/" . $token . "_nueva"))
                $arr[count($arr)] = "nueva";
            
            if (file_exists("partides/" . $token . "_1"))
                $arr[count($arr)] = "1";
            
            if (file_exists("partides/" . $token . "_2"))
                $arr[count($arr)] = "2";
            
            echo json_encode($arr);
            
            http_response_code(200);
            
        }
        
        break;
    
    case 'OPTIONS':
        
        if (file_exists($slot)) {
            
            unlink($slot);
            
            // Amb resposta
            
            http_response_code(200);
            
        }
        
        else {
            
            // Retorna NOT FOUND
            
            http_response_code(404);
            
        }
        
        break;
    
    case 'DELETE':
        
        http_response_code(202);
        
        break;
    
    default:
        
        // Error, retorna NOT FOUND
        
        http_response_code(404);
        
        break;
        
}



?>