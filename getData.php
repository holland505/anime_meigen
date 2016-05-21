<?php

require_once("config.php");
require_once("lib/Word.php");

$product_id = $_GET["id"];

$pdo = new PDO( PDO_DSN, DATABASE_USER, DATABASE_PASSWORD );
$word = new Word();

$array = $word->getCharacterById($pdo, $product_id);
header('Content-Type: application/json');
echo json_encode($array);

?>