<?php
session_start();



	if (empty($_POST['name'])) {
		$error['name'] = 'none';
	} elseif (isset($_POST['name'])) {
		$error['name'] = 'ok';
	}
	if (empty($_POST['email'])) {
		$error['email'] = 'none';
	} elseif (isset($_POST['email'])) {
		$error['email'] = 'ok';
	}

	if (strlen($_POST['password']) < 8) {
		$error['password'] = 'length';
	}
	if (empty($_POST['password'])) {
		$error['password'] = 'none';
	} elseif (isset($_POST['password'])) {
		$error['password'] = 'ok';
	}

	
	
if(!empty($_POST["name"])&&($_POST["email"])&&($_POST["password"])){
	header("Location: check.php");
	exit(); 
}
// もし$_POSTに文字があるならフォームに返すための記述
if(isset($_POST['name'])){
	$name = $_POST['name'];
}else{
	$name = "";
}
if(isset($_POST['email'])){
	$email = $_POST['email'];
}else{
	$email = "";
}
if(isset($_POST['password'])){
	$password = $_POST['password'];
}else{
	$password = "";
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>会員登録</title>

	<link rel="stylesheet" href="../style.css" />
</head>

<body>
	<div id="wrap">
		<div id="head">
			<h1>会員登録</h1>
		</div>

		<div id="content">
			<p>次のフォームに必要事項をご記入ください。</p>
			<form action="" method="post" enctype="multipart/form-data">
				<dl>
					<dt>ニックネーム<span class="required">必須</span></dt>
					<dd>
						<input type="text" name="name" size="35" maxlength="255" value="<?php echo(htmlspecialchars($name,ENT_QUOTES)); ?>" />
						<?php if ($error['name'] === 'none') : ?>
							<p class="error">ニックネームを入力してください。</p>
						<?php endif; ?>
						<?php if ($error['name'] === 'ok') : ?>
							<p class="nothing">空いている項目を入力してください</p>
						<?php endif; ?>
					</dd>
					<dt>メールアドレス<span class="required">必須</span></dt>
					<dd>
						<input type="text" name="email" size="35" maxlength="255" value="<?php echo(htmlspecialchars($email,ENT_QUOTES)); ?>" />
						<?php if ($error['email'] === 'none') : ?>
							<p class="error">メールアドレスを入力してください。</p>
						<?php elseif ($error['email'] === 'ok') : ?>
							<p class="nothing">空いている項目の入力してください</p>
						<?php endif; ?>
					</dd>
					<dt>パスワード<span class="required">必須</span></dt>
					<dd>
						<input type="password" name="password" size="10" maxlength="20" value="<?php echo(htmlspecialchars($password,ENT_QUOTES)); ?>" />
						<?php if ($error['password'] === 'length') : ?>
							<p class="error">パスワードは8文字以上で入力してください。</p>
						<?php endif; ?>
						<?php if ($error['password'] === 'none') : ?>
							<p class="error">パスワードを入力してください。</p>
						<?php elseif ($error['password'] === 'ok') : ?>
							<p class="nothing">空いている項目を入力してください</p>
						<?php endif; ?>
					</dd>

					<dt>写真など</dt>
					<dd>
						<input type="file" name="image" size="35" value="test" />
					</dd>
				</dl>
				<div><input type="submit" value="入力内容を確認する" /></div>
			</form>
		</div>
</body>

</html>