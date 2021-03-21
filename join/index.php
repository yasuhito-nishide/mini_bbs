<?php
session_start();

// $_POSTに値が入っていなければnoneを入っていればokをそれぞれ渡す
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

	
	// neme.email.passwordが入っていれば処理する
if(!empty($_POST["name"])&&($_POST["email"])&&($_POST["password"])){
	// fileのアップロード　同じファイル名を防ぐために日付を入れている
	$image = date('YmdHis') . $_FILES['image']['name'];
	// $_SESSIONに$_POSTの内容を入れている、check.phpに渡すため
	$_SESSION['join'] = $_POST;
	// name.email.passwordが入っていればcheck.phpに飛ぶ
	header("Location: check.php");
	exit(); 
}

// check.phpから返されてきた$_REQUEST['action']の$_SESSIONの値を$_POSTに入れてvalueに入れている
if ($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
	$_POST = $_SESSION['join'];
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
						<input type="text" name="name" size="35" maxlength="255" value="<?php echo(htmlspecialchars($_POST['name'],ENT_QUOTES)); ?>" />
						<?php if ($error['name'] === 'none') : ?>
							<p class="error">ニックネームを入力してください。</p>
						<?php endif; ?>
						<?php if ($error['name'] === 'ok') : ?>
							<p class="nothing">空いている項目を入力してください</p>
						<?php endif; ?>
					</dd>
					<dt>メールアドレス<span class="required">必須</span></dt>
					<dd>
						<input type="text" name="email" size="35" maxlength="255" value="<?php echo(htmlspecialchars($_POST['email'],ENT_QUOTES)); ?>" />
						<?php if ($error['email'] === 'none') : ?>
							<p class="error">メールアドレスを入力してください。</p>
						<?php elseif ($error['email'] === 'ok') : ?>
							<p class="nothing">空いている項目の入力してください</p>
						<?php endif; ?>
					</dd>
					<dt>パスワード<span class="required">必須</span></dt>
					<dd>
						<input type="password" name="password" size="10" maxlength="20" value="<?php echo(htmlspecialchars($_POST['password'],ENT_QUOTES)); ?>" />
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