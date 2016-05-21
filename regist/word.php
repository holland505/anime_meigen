<?php

require_once("../config.php");
require_once("../lib/Word.class.php");


$pdo = new PDO( PDO_DSN, DATABASE_USER, DATABASE_PASSWORD );
$word = new Word();
$productOption = $word->getProduct($pdo);

$rowArray = array();

$error_flg = false;
$error = "選択してください。";

if(!empty($_POST))
{
	if($word->existsData($_POST))
	{
		try
		{
			$now = date("Y-m-d H:i:s");
			$sql = "INSERT INTO t_words (word, character_id, product_id,created) VALUES (?,?,?,?)";
			$stmt = $pdo->prepare($sql);
			$valueArray = array($_POST["word"],$_POST["character_id"],$_POST["product_id"],$now);
			$stmt->execute($valueArray);
		}
		catch(PDOException $e)
		{
			var_dump($e->getMessage());
		}
	}
	else
	{
		$error_flg = true;
	}
}

try
{
#	$sql = "select * from t_words order by id desc limit 10";
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
	order by t_words.id desc limit 20";

	$stmt = $pdo->query($sql);
	$rowArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e)
{
	var_dump($e->getMessage());
}

//$smt = $pdo->prepare('insert into テーブル名 (name,tel) values(?,?)');


?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Word Register</title>

    <!-- Bootstrap core CSS -->
    <!-- <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Custom styles for this template -->
    <link href="../common/css/cover.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../common/js/set.js"></script>
  </head>

  <body>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-7 col-sm-6">
            <h1>Meigen Register</h1>
            <?php include_once("../common/include/navi.php"); ?>
            <br />
          </div>
        </div>
			<div class="well bs-component">
              <form class="form-horizontal" method="post">
                <fieldset>
                  <legend>Regist</legend>
                  <div class="form-group">
                    <label class="col-lg-2 control-label" for="select">Product</label>
                    <div class="col-lg-10">
                      <select id="product_select" name="product_id" class="form-control">
                      <?php echo $productOption; ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label" for="select">Character</label>
                    <div class="col-lg-10">
                      <select id="character_select" name="character_id" class="form-control">
												<option value="">----</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label" for="inputEmail">Meigen</label>
                    <div class="col-lg-10">
                      <input type="text" name="word" placeholder="Meigen" id="inputEmail" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
						<?php  if($error_flg) {echo "<p>選択もしくは、入力してください</p>";}?>
                      <button class="btn btn-default" type="reset">Cancel</button>
                      <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                  </div>
                </fieldset>
              </form>
            <div class="btn btn-primary btn-xs" id="source-button" style="display: none;">&lt; &gt;</div>
            </div>
        <div class="row">
          <div class="col-lg-12">
			<h2>Data Table</h2>
            <div class="bs-component">
              <table class="table table-striped table-hover table-bordered">
                <thead>
                  <tr>
				  	<th>id</th>
				  	<th>meigen</th>
				  	<th>character</th>
				  	<th>product</th>
                  </tr>
                </thead>
                <tbody>
<?php
if($rowArray)
{
	foreach($rowArray as $row)
	{
$html =<<<EOF
			  <tr>
			  	<td>{$row["id"]}</td>
			  	<td>{$row["word"]}</td>
			  	<td>{$row["character_name"]}</td>
			  	<td>{$row["product_name"]}</td>
			  </tr>
EOF;
echo $html;
	}
}
?>
                </tbody>
              </table>
            </div>
      <footer>
        <div class="row">
          <div class="col-lg-12">
            <p>@thurston.</p>
          </div>
        </div>
      </footer>
    </div>
  </body>
</html>
