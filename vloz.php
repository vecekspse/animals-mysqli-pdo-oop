<?php
require_once 'config.php';
var_dump($_POST);

//if($_SERVER['REQUEST_METHOD'] === 'POST') {}
//if(empty($_POST)) {}
$errors  = $args = [];
if(isset($_POST['vloz_zvire'])) {
    // A tady bude probít sanitizace a validace dat

    unset($_POST['vloz_zvire']);
    foreach($_POST as $key => $value) {
        if(empty($value)) {
            $errors[] = $key;
        } else {
            $args[':'.$key] = htmlspecialchars($value);
        }
    }
    if(empty($errors)) {
        $aManager->insertAnimal($args);
    } else {
        foreach($errors as $error)
            echo '<p>'. $error . '</p>';
    }
    var_dump($errors);
    var_dump($args);
    /*
    $nazev_zvirete = filter_input(INPUT_POST, 'nazev_zvirete', FILTER_SANITIZE_STRING);
    $latinsky_nazev = htmlspecialchars($_POST['latinsky_nazev']);
    $popis = filter_input(INPUT_POST, 'popis', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $mladat = filter_input(INPUT_POST, 'mladat', FILTER_VALIDATE_INT);
    $druh_id = filter_input(INPUT_POST, 'druh_id', FILTER_VALIDATE_INT);
    $zeme_puvodu_id = filter_input(INPUT_POST, 'zeme_puvodu_id', FILTER_VALIDATE_INT);
    $errors = [];
    if(empty($nazev_zvirete)) 
        $errors[] = 'Nazev zvířete musí být vyplněn';
    if(empty($latinsky_nazev))
        $erorrs[] = 'Latinský název musí být vyplněn';
    if(empty($popis)) 
        $errors[] = 'Popis musí být vyplněn';
    if(empty($mladat)) 
        $errors[] = 'Počet mláďat musí být celý číslo a vyplněno.';
    if(empty($druh_id)) 
        $errors[] = 'Druh musí být celé číslo';
    if(empty($zeme_puvodu_id)) 
        $errors[] = 'Země původu musí být vyplněna';
    if(empty($errors)) {
        echo 'Everything is OK';
    } else {
        foreach($errors as $error)
            echo '<p>'. $error . '</p>';
    }
    */
}   
?>
<meta charset="utf-8">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
form {
    display: block;
    width: 500px;
    margin: auto;
}
input, label, select, button, textarea {
    display: block;
    width: 100%; 
    margin: .3rem 0;
    padding: .5rem;
}
.error { background-color: crimson; color: white;}
</style>
<?php
/*
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
//vlozMYSQLI('Ježek', 'Ježkus latinus', 'Jakože popis', 5, 3, 8);
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
//vlozPDO('Kobra', 'KObra 11', 'Jejich revírem je dálnice...', 5, 3, 8);
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
*/
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="vloz-zvire" method="POST">
    <h1>Vlož zvíře do DB</h1>
    <label>Název zvířete</label>
    <input type="text" name="nazev_zvirete" 
        <?php if(in_array('nazev_zvirete', $errors)) {
            echo 'class="error"';
        } ?>>
    <label>Latinský název zvířete</label>
    <input type="text" name="latinsky_nazev" <?php if(in_array('latinsky_nazev', $errors)) {
        echo 'class="error"';
    } ?>>    <label>Popis zvířete</label>
    <textarea name="popis" rows="10" <?php if(in_array('popis', $errors)) {
            echo 'class="error"';
        } ?>></textarea>
    <label>Počet mláďat</label>
    <input type="number" name="mladat">
    <!-- Here is the magic -->
    <label>Druh ID</label>
    <select name="druh_id">
<?php
    foreach($aManager->showKinds() as $row) {
        echo '<option value="'.$row['id'].'">'.$row['druh'].'</option>';
    }
?>
    </select>
    <select name="zeme_puvodu_id">
<?php 
    foreach($aManager->showStates() as $row) {
        echo '<option value="'.$row['id'].'">'.$row['zeme'].'</option>';
    } 
?>
    </select>
    <!-- Magic ends here -->
    <button type="submit" name="vloz_zvire">Vložit zvíře</button>
</form>