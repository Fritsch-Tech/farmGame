<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once "../src/util/DBConnection.php";
require_once "../src/util/ResponseUtils.php";


$app->get('/api/farm/{farmId}', function(Request $request, Response $response){
    $farmId = $request->getAttribute('farmId');
    try{
        $db = DBConnection::getConnection();

        $stmt = $db->prepare("  SELECT
                                id,
                                name,
                                sizex,
                                sizey,
                                money
                                FROM farm
                                WHERE id = :farmId
                                ");

        $stmt->bindParam(':farmId',	$farmId, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_OBJ);

        return ResponseUtils::data($response, $data);
    } catch(PDOException $e){
        return ResponseUtils::error($response, $e->getMessage(),500);
    }
});

$app->get('/api/farm/{farmId}/fields', function(Request $request, Response $response){
    $farmId = $request->getAttribute('farmId');
    try{
        $db = DBConnection::getConnection();

        $stmt = $db->prepare("  SELECT
                                id,
                                posX,
                                posY,
                                cropId,
                                sowTime
                                FROM field
                                WHERE farmId = :farmId
                                ");

        $stmt->bindParam(':farmId',	$farmId, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return ResponseUtils::data($response, $data);
    } catch(PDOException $e){
        return ResponseUtils::error($response, $e->getMessage(),500);
    }
});

$app->get('/api/farm/{farmId}/inventory', function(Request $request, Response $response){
    $farmId = $request->getAttribute('farmId');
    try{
        $db = DBConnection::getConnection();

        $stmt = $db->prepare("  SELECT
                                farmId,
                                itemId,
                                quantity
                                FROM inventory
                                WHERE farmId = :farmId
                                ");

        $stmt->bindParam(':farmId',	$farmId, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return ResponseUtils::data($response, $data);
    } catch(PDOException $e){
        return ResponseUtils::error($response, $e->getMessage(),500);
    }
});
