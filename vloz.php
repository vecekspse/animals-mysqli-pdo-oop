<meta charset="utf-8">
<?php
require_once 'config.php';

// Insert by MYSQLI
function vlozMYSQLI($nazev_zvirete, $latinsky_nazev, $popis, $mladat, $druh_id, $zeme_puvodu_id) {
    $db = connect();
    $sql = 'INSERT INTO zvire VALUES (NULL, ?, ?, ?, ?, ?, ?);';
    if($stmt = $db->prepare($sql)) {
        $stmt->bind_param('sssiii', $nazev_zvirete, $latinsky_nazev, 
                            $popis, $mladat, $druh_id, $zeme_puvodu_id);
        $stmt->execute();
        return $stmt->insert_id;
    }
    return false;
}
vlozMYSQLI('Ježek', 'Ježkus latinus', 'Jakože popis', 5, 3, 8);
// Insert by PDO
function vlozPDO($nazev_zvirete, $latinsky_nazev, $popis, $mladat, $druh_id, $zeme_puvodu_id) {
    $db = pdo_connect();
    $sql = 'INSERT INTO zvire VALUES (NULL, :nazev_zvirete, :latinsky_nazev, 
                                      :popis, :mladat, :druh_id, :zeme_puvodu_id)';
    $stmt = $db->prepare($sql);
    $stmt->execute([':nazev_zvirete' => $nazev_zvirete,
                    ':latinsky_nazev' => $latinsky_nazev,
                    ':popis' => $popis,
                    ':mladat' => $mladat,
                    ':druh_id' => $druh_id,
                    ':zeme_puvodu_id' => $zeme_puvodu_id]);
    return $db->lastInsertId();
}
vlozPDO('Kobra', 'KObra 11', 'Jejich revírem je dálnice...', 5, 3, 8);


$db = new DB();
$sql = 'INSERT INTO zvire VALUES (NULL, :nazev_zvirete, :latinsky_nazev, 
        :popis, :mladat, :druh_id, :zeme_puvodu_id)';
$args = [':nazev_zvirete' => 'Liška',
        ':latinsky_nazev' => 'Ryška',
        ':popis' => 'Rezatá jako liška',
        ':mladat' => 5,
        ':druh_id' => 3,
        ':zeme_puvodu_id' => 3];
$db->run($sql, $args);
