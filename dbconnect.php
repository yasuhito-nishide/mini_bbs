<?php
try {
  $db = new PDO('mysql:dbname=mini_bbs;host=localhost;charset=utf-8','root','root');
} catch(PDOException $e) {
  print('DB接続エラー:' . $e->getMessage());
}