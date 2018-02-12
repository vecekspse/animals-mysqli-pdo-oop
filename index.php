<meta charset="UTF-8">
<?php
require_once 'config.php';
// Simple mysqli SELECT without prepared statements
function mysqli_show_all($order = NULL) {
    $mysqli = connect();
    $order = ($order) ? ' ORDER BY ' . $order : '';
    $sql = 'SELECT * FROM zvire' . $order;
    $query = $mysqli->query($sql);
    $result = $query->fetch_all(MYSQLI_ASSOC);
    return $result;
}
// Simple PDO SELECT without prepared statements
function pdo_show_all($order = NULL) {
    $pdo = pdo_connect();
    $order = ($order) ? ' ORDER BY ' . $order : '';
    $sql = 'SELECT * FROM zvire' . $order;
    $query = $pdo->query($sql);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
/*
var_dump(mysqli_show_all('latinsky_nazev DESC'));
var_dump(pdo_show_all('mladat DESC'));
*/
$db = new DB();
$result = $db->run('SELECT * FROM zvire')->fetchAll(PDO::FETCH_OBJ);
var_dump($result);