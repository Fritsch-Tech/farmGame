<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once "../src/util/DBConnection.php";
require_once "../src/util/ResponseUtils.php";

$app->get('/api/items', function(Request $request, Response $response){
    try{
        $db = DBConnection::getConnection();

        $stmt = $db->prepare("  SELECT
                                id,
                                name,
                                image,
                                value
                                FROM item
                                ");

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);

        return ResponseUtils::data($response, $data);
    } catch(PDOException $e){
        return ResponseUtils::error($response, $e->getMessage(),500);
    }
});

$app->get('/api/items/{itemId}', function(Request $request, Response $response){
    $itemId = $request->getAttribute('itemId');
    try{
        $db = DBConnection::getConnection();

        $stmt = $db->prepare("  SELECT
                                id,
                                name,
                                image,
                                value
                                FROM item
                                WHERE id = :itemId
                                ");

        $stmt->bindParam(':itemId',	$itemId, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_OBJ);

        return ResponseUtils::data($response, $data);
    } catch(PDOException $e){
        return ResponseUtils::error($response, $e->getMessage(),500);
    }
});
