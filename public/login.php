<?php
session_start();
//セッションを開始した状態でファイルを読み込む
require_once '../classes/UserLogic.php';

//session idが入って、セッションが使えるようになる


//エラーメッセージを配列の中に入れる
$err = [];

//バリデーション
//usernameはsignup_formのinputタグの名前を入力した値が入る
// if文の先頭に！をつけることによってからの場合、エラーメッセージを追加する

if(!$email = filter_input(INPUT_POST, 'email')){
    $err['email'] = 'メールアドレスを記入してください'; 
}

if(!$password = filter_input(INPUT_POST, 'password')){
    $err['password'] = 'パスワードを入力してください';
}


//エラーがあった場合は処理を戻す
if(count($err) > 0){
    //エラーがあった場合はlogin.phpの画面に遷移させる
    //$_SESSIONは連想配列で値が入る
    $_SESSION = $err;
    header('Location: login_form.php');
    return;
    }
//エラーがなかった場合ログインする処理
    // ここの引数はログインフォームから受け取ったメールとパスワードになります
    $result = UserLogic::login($email,$password);
//ログイン失敗じの処理
    if (!$result){
        header('Location: login_form.php');
        return;
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー完了</title>
</head>
<body>
    <h2>ログイン完了</h2>
    <p>ログインしました</p>
<a href="./mypage.php">マイページへ</a>
    
</body>
</html>