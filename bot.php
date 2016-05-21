<?php

require_once("config.php");

require "twitteroauth-0.5.3/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$rowArray = array();
$pdo = new PDO( PDO_DSN, DATABASE_USER, DATABASE_PASSWORD );
try
{
	$sql = "
	select 
		t_words.id, 
		t_words.word, 
		m_products.product_name, 
		m_characters.character_name 
	from 
		t_words 
		left join m_characters on (t_words.character_id = m_characters.id) 
		left join m_products on (m_characters.product_id  = m_products.id) 
	order by rand() limit 1";

	$stmt = $pdo->query($sql);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
}
catch(PDOException $e)
{
	var_dump($e->getMessage());
}

// Array ( [id] => 38 [word] => カミナギ。舞浜の空は、青いか？ [product_name] => ゼーガペイン [character_name] => キョウ ) 

$MEG_FORMAT = "「%s」【%s】- #%s";
$tsubuyaki = sprintf($MEG_FORMAT, $row["word"], $row["character_name"], $row["product_name"]);

$connection = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);
$connection->post("statuses/update", array("status" => $tsubuyaki));

?>