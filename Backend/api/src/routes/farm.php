<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once "../util/DBConnection.php";
require_once "../src/util/ResponseUtils.php";

$json = $request->getBody();
$bodyData = json_decode($json, true);

$app->GET('/api/farm/{farmId}', function(Request $request, Response $response){
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

$app->GET('/api/farm/{farmId}/fields', function(Request $request, Response $response){
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

$app->GET('/api/farm/{farmId}/inventory', function(Request $request, Response $response){
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

$app->UPDATE('/api/farm/{farmId}/inventory/{itemId}/sell', function(Request $request, Response $response){
    $farmId = $request->getAttribute('farmId');
    $itemId = $request->getAttribute('itemId');
    $json = $request->getBody();
    $bodyData = json_decode($json, true);

    if(!isset($bodyData["quantity"])){
        return ResponseUtils::customError($response, 106);
    }

    try{
        $db = DBConnection::getConnection();
        $stmt = $db->prepare("  SELECT
                                quantity
                                FROM inventory
                                WHERE farmId = :farmId and
                                itemId = :itemId
                                ");

        $stmt->bindParam(':farmId',	$farmId, PDO::PARAM_INT);
        $stmt->bindParam(':itemId',	$itemId, PDO::PARAM_INT);

        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ);


        $db->beginTransaction();
        if($data->quantity > $bodyData["quantity"]){
            return ResponseUtils::error($response,'quantity out of bounds',400);
        }elseif ($data->quantity == $bodyData["quantity"]) {
            $stmt = $db->prepare("  DELETE FROM inventory
                                    WHERE farmId = :farmId and
                                    itemId = :itemId
                                    ");
            $stmt->bindParam(':farmId',	    $farmId, PDO::PARAM_INT);
            $stmt->bindParam(':itemId',	    $itemId, PDO::PARAM_INT);

            $stmt->execute();
        }else{
            $stmt = $db->prepare("  UPDATE inventory
                                    SET quantity = :quantity
                                    WHERE farmId = :farmId and
                                    itemId = :itemId
                                    ");
            $stmt->bindParam(':quantity',	$bodyData["quantity"], PDO::PARAM_INT);
            $stmt->bindParam(':farmId',	    $farmId, PDO::PARAM_INT);
            $stmt->bindParam(':itemId',	    $itemId, PDO::PARAM_INT);

            $stmt->execute();
        }
        $db->commit();
        return ResponseUtils::data($response, '');
    } catch(PDOException $e){
        return ResponseUtils::error($response, $e->getMessage(),500);
    }
});
