<?php

$csv = array();
$file = "tweets.csv";

$products = array(
"攻殻機動隊"=>1,
"秒速5センチメートル"=>2,
"魔法少女まどか☆マギカ"=>3,
"ドラえもん"=>4,
"ドラゴンボール"=>5,
"機動戦士Ｚガンダム"=>6,
"北斗の拳"=>7,
"もののけ姫"=>8,
"CLANNAD"=>9,
"機動戦士ガンダムUC"=>10,
"新世紀エヴァンゲリオン"=>11,
"天空の城ラピュタ"=>12,
"スラムダンク"=>13,
"ジョジョの奇妙な冒険"=>14,
"天元突破グレンラガン"=>15,
"化物語"=>16,
"交響詩篇エウレカセブン"=>17,
"ゼーガペイン"=>18,
"ひぐらしのなく頃に"=>19,
"機動戦士ガンダム"=>20
);

$characters = array(
"合田一人"=>1,
"遠野貴樹"=>2,
"インキュベーター"=>3,
"野比のび太"=>4,
"ベジータ"=>5,
"カミーユ・ビダン"=>6,
"聖帝サウザー"=>7,
"バトー"=>8,
"トキ"=>9,
"岡崎直幸"=>10,
"アンジェロ・ザウパー"=>11,
"碇シンジ"=>12,
"シータ"=>13,
"桜木花道"=>14,
"澄田花苗"=>15,
"エシディシ"=>16,
"赤木剛憲"=>17,
"ロムスカ・パロ・ウル・ラピュタ"=>18,
"ニア"=>19,
"モウロ将軍"=>20,
"戦場ヶ原ひたぎ"=>21,
"ラオウ"=>22,
"アネモネ"=>23,
"ダイアン・サーストン"=>24,
"草薙素子"=>25,
"パズー・シータ"=>26,
"ジェリド・メサ"=>27,
" - "=>28,
"流川楓"=>29,
"キョウ"=>30,
"ジコ坊"=>31,
"オードリー・バーン"=>32,
"リディ・マーセナス"=>33,
"レントン・サーストン"=>34,
"ドーラ"=>35,
"暁美ほむら"=>36,
"フル・フロンタル"=>37,
"荒巻大輔"=>38,
"バナージ・リンクス"=>39,
"ジョナサン"=>40,
"綾波レイ"=>41,
"ストナー"=>42,
"ランバ・ラル"=>43,
"佐倉杏子"=>44,
"トグサ"=>45,
"三井寿"=>46,
"安西先生"=>47,
"加持リョウジ"=>48,
"カミナ"=>49,
"カミナギ"=>50,
"アムロ・レイ"=>51,
"竜宮レナ"=>52,
"エウレカ"=>53
);



$fp = fopen($file, "r");


$pattern = "/「(.+?)」【(.+?)】- (.+?) /";
$splitWordArray = array();

while(($row = fgetcsv($fp, 0, ",")) !== false)
{
	splitWord($row[5], $splitWordArray, $pattern);
}

$splitWordArray = array_unique($splitWordArray, SORT_REGULAR);

#print_r($splitWordArray);

$insert_format_products = "insert into m_products (product_name, created) values ('%s', NOW());\r\n";
$insert_format_characters = "insert into m_characters (product_id, character_name, created) values (%s,'%s', NOW());\r\n";

$insert_format_words = "insert into t_words (product_id, character_id, word, created) values (%d, %d, '%s', NOW());\r\n";


$insert_txt = "";
for($i=0; $i<count($splitWordArray); $i++)
{
	if($splitWordArray[$i]["product"] && strpos($insert_txt, $splitWordArray[$i]["character"]) == 0)
	{
		$insert_txt .= sprintf($insert_format_words, $products[$splitWordArray[$i]["product"]], $characters[$splitWordArray[$i]["character"]], $splitWordArray[$i]["word"]);
	}
}

echo $insert_txt;

function splitWord($word, &$splitWordArray, $pattern)
{
	if(preg_match($pattern, $word, $match))
	{
		array_push($splitWordArray, array("word"=> $match[1], "character"=> $match[2], "product"=> trim($match[3])));
	}
}

?>