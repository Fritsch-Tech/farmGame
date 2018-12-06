<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once "../src/util/DBConnection.php";
require_once "../src/util/ResponseUtils.php";

$app->get('/api/crops', function(Request $request, Response $response){
    try{
        $db = DBConnection::getConnection();

        $stmt = $db->prepare("  SELECT
                                id,
                                name,
                                image,
                                price,
                                growTime,
                                dropId
                                FROM crop
                                ");

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return ResponseUtils::data($response, $data);
    } catch(PDOException $e){
        return ResponseUtils::error($response, $e->getMessage(),500);
    }
});

$app->get('/api/crops/{cropId}', function(Request $request, Response $response){
    $cropId = $request->getAttribute('cropId');
    try{
        $db = DBConnection::getConnection();

        $stmt = $db->prepare("  SELECT
                                id,
                                name,
                                image,
                                price,
                                growTime,
                                dropId
                                FROM crop
                                WHERE id = :cropId
                                ");

        $stmt->bindParam(':cropId',	$cropId, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_OBJ);

        return ResponseUtils::data($response, $data);
    } catch(PDOException $e){
        return ResponseUtils::error($response, $e->getMessage(),500);
    }
});
