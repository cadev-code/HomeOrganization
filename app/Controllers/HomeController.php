<?php

namespace App\Controllers;

use App\Config\Database;
use PDOException;

require_once __DIR__ . '/../config/database.php';

class HomeController
{
  public function index()
  {
    $dbStatus = "Desconectado";

    try
    {
      $db = Database::getConnection();
      $query = $db->query("SELECT version();");
      if ($query)
      {
        $dbStatus = "Conectado a la base de datos. Versión: " . $query->fetchColumn();
      }
    }
    catch (PDOException $e)
    {
      $dbStatus = "Error de conexión: " . $e->getMessage();
    }

    require_once __DIR__ . '/../Views/construction.php';
  }
}