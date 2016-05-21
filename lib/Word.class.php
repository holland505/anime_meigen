<?php

class Word
{
	public $data = array(
		"word" => null,
		"character_id" => null,
		"product_id" => null
	);
	
	function __construct() {}
	
	function existsData($post)
	{
		foreach($this->data as $key => $val)
		{
			if(!$post[$key] || (mb_strlen($val) == 0))
			{
				return false;
			}
		}
		return true;
	}
		
	function getCharacter($pdo)
	{
		$sql = "select id, character_name from m_characters";
		$stmt = $pdo->query($sql);
		$rowArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$html = '<option value="">キャラクターを選択してください</option>\r\n';
		foreach($rowArray as $row)
		{
			$html .= '<option value="'.$row["id"].'">'.$row["character_name"]."</option>\r\n";
		}
		
		return $html;
	}
	
	function getProduct($pdo)
	{
		$sql = "select id, product_name from m_products";
		$stmt = $pdo->query($sql);
		$rowArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$html = '<option value="">作品を選択してください</option>\r\n';
		foreach($rowArray as $row)
		{
			$html .= '<option value="'.$row["id"].'">'.$row["product_name"]."</option>\r\n";
		}
		
		return $html;
	}
	
	function getCharacterById($pdo, $id)
	{
		$sql = "select id, character_name from m_characters where m_characters.product_id = ".$id;
		$stmt = $pdo->query($sql);
		$rowArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rowArray;
	}
	
	
}


?>