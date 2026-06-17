<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
  private static ?PDO $connection = null;

  public static function getConnection(): PDO
  {
    if (self::$connection === null) 
    {
      $host = $_ENV['DB_HOST'] ?? null;
      $port = $_ENV['DB_PORT'] ?? null;
      $dbname = $_ENV['DB_NAME'] ?? null;
      $user = $_ENV['DB_USER'] ?? null;
      $password = $_ENV['DB_PASSWORD'] ?? null;

      if (!$host || !$port || !$dbname || !$user || !$password)
        die("Error: Error en la configuración de la base de datos.");
      
      $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

      try {
        self::$connection = new PDO($dsn, $user, $password, [
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // lanza excepciones si hay errores SQL
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // devuelve arrays asociativos por defecto
          PDO::ATTR_EMULATE_PREPARES   => false,                  // usa preparaciones nativas para evitar SQL Injection
        ]);
      }
      catch (PDOException $e)
      {
        if (($_ENV['APP_ENV'] ?? 'production') === 'local')
        {
          die ("Error de conexión a la base de datos: " . $e->getMessage());
        }
        else
        {
          die ("Error crítico: No se pudo conectar a la base de datos.");
        }
      }
    }

    return self::$connection;
  }
}