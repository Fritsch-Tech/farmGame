<?php

final class DBConnection {
      const MYSQL_HOST = 		"localhost";
      const MYSQL_DATABASE =	"dblabor";
      const MYSQL_USERNAME = 	"labor-user";
      const MYSQL_PASSWORD = 	"kn4YkSg8pm";

      private static $pdo = null;

       private function __construct() {}

       public static function getConnection() { // Singleton
         if (self::$pdo === null) {
            $opt = array(
                PDO::ATTR_ERRMODE                   => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE        => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY  => true
                );
           self::$pdo = new PDO('mysql:host='.self::MYSQL_HOST.';dbname='.self::MYSQL_DATABASE.';charset=utf8', self::MYSQL_USERNAME, self::MYSQL_PASSWORD,$opt);
         }

         return self::$pdo;
       }
     }
