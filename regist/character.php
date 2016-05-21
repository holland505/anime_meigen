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
			$sql = "INSERT INTO m_characters (product_id, character_name, created) VALUES (?,?,?)";
			$stmt = $pdo->prepare($sql);
			$valueArray = array($_POST["product_id"],$_POST["character_name"],$now);
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
					<legend>Character Regist</legend>
                  <div class="form-group">
                    <label class="col-lg-2 control-label" for="select">Product</label>
                    <div class="col-lg-10">
                      <select id="product_select" name="product_id" class="form-control">
                      <?php echo $productOption; ?>
                      </select>
                    </div>
                  </div>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="inputEmail">Product Name</label>
						<div class="col-lg-10">
							<input type="text" name="character_name" placeholder="Character Name" id="inputEmail" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<?php  if($error_flg) { echo "<p>選択もしくは、入力してください</p>"; } ?>
							<button class="btn btn-default" type="reset">Cancel</button>
							<button class="btn btn-primary" type="submit">Submit</button>
						</div>
					</div>
				</fieldset>
			</form>
			<div class="btn btn-primary btn-xs" id="source-button" style="display: none;">&lt; &gt;</div>
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