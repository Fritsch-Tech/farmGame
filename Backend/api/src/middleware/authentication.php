<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once "../src/util/DBConnection.php";
require_once "../src/util/ResponseUtils.php";



$app->add(function ($req, $res, $next) {
    try{
        if($req->getHeader("Authorization") != null){
            $auth = base64_decode(substr($req->getHeader("Authorization")[0], 6));
            $username = explode(':',$auth)[0];
            $password = explode(':',$auth)[1];

            $db = DBConnection::getConnection();

            $stmt = $db->prepare("  SELECT
                                    hash,
                                    id
                                    FROM user
                                    WHERE username = :username");

            $stmt->bindParam(':username',	$username);

            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_OBJ);

            if($data->hash != null){

                if(password_verify($password,$data->hash)){
                    $req = $req->withAttribute('userId',$data->id);
                    $response = $next($req, $res);
                    return $response;
                }else{
                    return ResponseUtils::error($res, 'Permission denied',403);
                }
            }
        }else{
            return ResponseUtils::error($res, 'Permission denied',403);
        }
    } catch(PDOException $e){
        return ResponseUtils::error($response, $e->getMessage(),500);
    }

});
