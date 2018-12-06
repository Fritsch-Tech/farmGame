<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once "../src/util/DBConnection.php";
require_once "../src/util/ResponseUtils.php";
/*
$app->Patch('/api/fields/{fieldId}/sow', function(Request $request, Response $response){
    $fieldId = $request->getAttribute('fieldId');
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
*/
