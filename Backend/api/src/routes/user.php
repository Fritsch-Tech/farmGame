<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once "../src/util/DBConnection.php";
require_once "../src/util/ResponseUtils.php";


$app->get('/api/user', function(Request $request, Response $response){
    try{
        $db = DBConnection::getConnection();

        $stmt = $db->prepare("  SELECT
                                user.id,
                                user.name,
                                user.surname,
                                user.username,
                                user.eMail,
                                farm.id as farmId
                                FROM user
                                INNER JOIN farm
                                ON farm.userId = user.id
                                WHERE user.id = :userId
                                ");

        $stmt->bindParam(':userId',	$request->getAttribute('userId'));

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_OBJ);

        return ResponseUtils::data($response, $data);
    } catch(PDOException $e){
        return ResponseUtils::error($response, $e->getMessage(),500);
    }
});
