<?php
final class ResponseUtils {
    private function __construct() {}

    public static function error(&$response, $message, $statusCode) {
        return $response->withStatus($statusCode)
                        ->withHeader('Content-Type', 'text/json') //MIME-Typ
                        ->write(json_encode($message, JSON_UNESCAPED_UNICODE));
    }

    public static function data(&$response, $data, $statusCode = null) {
        if(!$statusCode){
            if($data == null){
                $statusCode = 204;
            }else{
                $statusCode = 200;
            }
        }
        $message = $data;
        return $response->withStatus($statusCode)
                        ->withHeader('Content-Type', 'text/json') //MIME-Typ
                        ->write(json_encode($message, JSON_UNESCAPED_UNICODE));
    }
}
?>
