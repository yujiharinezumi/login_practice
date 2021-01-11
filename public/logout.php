<?php
session_start();
require_once '../classes/UserLogic.php';

//ログアウトのリンクを押した時に送信される'logout'入っているかフィルタリングする
//そしてその中身を変数にいれ、中身がなかったらエラーメッセージを表示する
$logout = filter_input(INPUT_POST,'logout');
if(!$logout){
    exit('不正なアクセスです');
}


//　ログインしているかを判定し、セッションが切れていたら、ログインしてくださいとメッセージを出す
//何もしないで２４分立つとセッションが切れるため


$result = UserLogic::checkLogin();
//もしログインが成功していたら
if(!$result){
    exit('セッションが切れましたので、ログインし直してください');
}

//ログアウトする
UserLogic::logout();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ログアウト</title>
</head>
<body>
    <h2>ログアウト</h2>
    <p>ログアウトしました</p>
    <a href="login_form.php">ログイン画面へ</a>
</body>
</html>