<?php
error_reporting(0);
session_start();
require('../dbconnect.php');

if (!empty($_POST)) {
// $_POSTに値が入っていなければnoneを入っていればokをそれぞれ渡す
if (empty($_POST['name'])) {
	$error['name'] = 'none';
}
if (empty($_POST['email'])) {
	$error['email'] = 'none';
} 
if (empty($_POST['password'])) {
	$error['password'] = 'none';
} 
// 画像のエラーチェック
$filename = $_FILES['image']['name'];
if(!empty($filename)) {
	$ext = substr($filename,-3);
	if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
		$error['image'] = 'type';
	}
}

// データベースにメールアドレスの重複があれば
if(empty($error)) {
	$member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=? ');
	$member->execute(array($_POST['email']));
	$record = $member->fetch();
	if ($record['cnt'] > 0) {
		$error['email'] = 'duplicate';
	}
}

// name.email.passwordが入っていれば処理する
if (empty($error)) {
	// fileのアップロード同じファイル名を防ぐために日付を入れている
	// date('YmdHis)で日付を取得　　202103261123myFace.pngなどの名前になる。
	$image = date('YmdHis') . $_FILES['image']['name'];
	// 画像のアップロード　['image']['tmp_name']に一時的に保管している
	// move_uploaded_fileで送る　第一引数が今ある場所　　　第二引数が保存先
	move_uploaded_file($_FILES['image']['tmp_name'],'../member_picture/'.$image);
	// $_SESSIONに$_POSTの内容を入れている、check.phpに渡すため
	$_SESSION['join'] = $_POST;
	// $imageを$_SESSION['join']['image']に保存
	$_SESSION['join']['image'] = $image;
	// name.email.passwordが入っていればcheck.phpに飛ぶ
	header("Location: check.php");
	exit();
}
}

// check.phpから返されてきた$_REQUEST['action']の$_SESSIONの値を$_POSTに入れてvalueに入れている
// URLパラメーターが付いていれば  check.phpからaction?rewriteという値が帰ってきている
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
					</dd>
					<dt>メールアドレス<span class="required">必須</span></dt>
					<dd>
						<input type="email" name="email" size="35" maxlength="255" value="<?php echo (htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?>" />
						<?php if ($error['email'] === 'none') : ?>
							<p class="error">メールアドレスを入力してください。</p>
						<?php endif; ?>
						<?php if ($error['email'] === 'duplication') : ?>
							<p class="error">指定されたメールアドレスはすでに登録されています。</p>
						<?php endif; ?>
					</dd>
					<dt>パスワード<span class="required">必須</span></dt>
					<dd>
						<input type="password" id="password" name="password" size="10" minlength="8" value="<?php echo (htmlspecialchars($_SESSION['join']['password'], ENT_QUOTES)); ?>" />
						<?php if ($error['password'] === 'none') : ?>
							<p class="error">パスワードを入力してください。</p>
						<?php endif; ?>
					</dd>

					<dt>写真など</dt>
					<dd>
						<input type="file" name="image" size="35" value="test" />
						<?php if ($error['image'] === 'type') :  ?>
							<p class="nothing">「jpg」か「png」か「gif」でアップロードしてください。</p>
							<?php endif; ?>
						<?php if(!empty($error)):  ?>
						<p class="error">恐れ入りますが、画像を改めて指定して下さい。</p>
							<?php endif; ?>
					</dd>
				</dl>
				<div><input type="submit" value="入力内容を確認する" /></div>
			</form>
		</div>
		
</body>


</html>