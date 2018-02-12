<?php
mb_internal_encoding('UTF-8');
session_start();

// MYSQLI
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');
define('DBNAME', 'zoo');

function connect() {
    $mysqli = new mysqli(HOST, USER, PASSWORD, DBNAME);
    if($mysqli->errno > 0)
        die('Nepovedlo se připojit k databázi');
    $mysqli->set_charset('utf8');
    return $mysqli;
}
//var_dump(connect());
// PDO
define('DSN', 'mysql:host=localhost;dbname=zoo;charset=utf8;');
function pdo_connect() {
    try {        
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $pdo = new PDO(DSN, USER, PASSWORD, $options);
        return $pdo;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
//var_dump(pdo_connect());
class DB extends PDO {
    public function __construct() {
        try {
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
            parent::__construct(DSN, USER, PASSWORD, $options);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function run($sql, $args = NULL) {
        if(!$args) {
            return $this->query($sql);  
        }
        $stmt = $this->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}
class AnimalManager extends DB {
    public function __construct() {
        parent::__construct();
    }
    public function showAnimals() {
        return $this->run('SELECT * FROM zvire;')->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insertAnimal($args) {
        $sql = 'INSERT INTO zvire VALUES (NULL, :nazev_zvirete, :latinsky_nazev, 
        :popis, :mladat, :druh_id, :zeme_puvodu_id)';
        $this->run($sql, $args);
        return $this->lastInsertId();
    }
    public function deleteAnimal($id) {
        $sql = 'DELETE FROM zvire WHERE id = :id';
        $this->run($sql, [':id' => $id]);
    }
}

$aManager = new AnimalManager();
var_dump($aManager->showAnimals());