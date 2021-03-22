<?php
error_reporting(0);
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
// 画像のエラーチェック
$filename = $_FILES['image']['name'];
if(!empty($filename)) {
	$ext = substr($filename,-3);
	if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
		$error['image'] = 'type';
	}
}

// name.email.passwordが入っていれば処理する
if (!empty($_POST["name"]) && ($_POST["email"]) && ($_POST["password"])) {
	// fileのアップロード同じファイル名を防ぐために日付を入れている
	$image = date('YmdHis') . $_FILES['image']['name'];
	// 画像のアップデート
	move_uploaded_file($_FILES['image']['tmp_name'],'../member_picture/'.$image);
	// $_SESSIONに$_POSTの内容を入れている、check.phpに渡すため
	$_SESSION['join'] = $_POST;
	$_SESSION['join']['image'] = $image;
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
			<form id="form" action="" method="post" enctype="multipart/form-data">
				<dl>
					<dt>ニックネーム<span class="required">必須</span></dt>
					<dd>
						<input type="text" name="name" size="35" maxlength="255" value="<?php echo (htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?>" />
						<?php if ($error['name'] === 'none') : ?>
							<p class="error">ニックネームを入力してください。</p>
						<?php endif; ?>
						<?php if ($error['name'] === 'ok') : ?>
							<p class="nothing">空いている項目を入力してください</p>
						<?php endif; ?>
					</dd>
					<dt>メールアドレス<span class="required">必須</span></dt>
					<dd>
						<input type="email" name="email" size="35" maxlength="255" value="<?php echo (htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?>" />
						<?php if ($error['email'] === 'none') : ?>
							<p class="error">メールアドレスを入力してください。</p>
						<?php elseif ($error['email'] === 'ok') : ?>
							<p class="nothing">空いている項目の入力してください</p>
						<?php endif; ?>
					</dd>
					<dt>パスワード<span class="required">必須</span></dt>
					<dd>
						<input type="password" id="password" name="password" size="10" minlength="8" value="<?php echo (htmlspecialchars($_SESSION['join']['password'], ENT_QUOTES)); ?>" />

						<p id="error"></p>

						<?php if ($error['password'] === 'none') : ?>
							<p class="error">パスワードを入力してください。</p>
						<?php elseif ($error['password'] === 'ok') : ?>
							<p class="nothing">空いている項目を入力してください</p>
						<?php endif; ?>
					</dd>

					<dt>写真など</dt>
					<dd>
						<input type="file" name="image" size="35" value="test" />
						<?php if ($error['image'] === 'type') :  ?>
							<p class="nothing">「jpg」か「png」か「gif」でアップロードしてください。</p>
						<?php endif; ?>
					</dd>
				</dl>
				<div><input type="submit" value="入力内容を確認する" /></div>
			</form>
		</div>
		<!-- <script>
			let input1 = document.getElementById('password').value;
			document.getElementById('form').onsubmit = function() {
				if (input1.length < 8) {
					document.getElementById('error').textContent = 'パスワードは8文字以上で入力してください';
					return false;
				} else {
					return true;
				}
			}
			console.log(input1.length);
		</script> -->
</body>


</html>