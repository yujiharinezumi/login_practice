<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';

//　ログインしているかを判定し、していなかったら新規登録画面へ返す

$result = UserLogic::checkLogin();
//もしログインが成功していたら
if(!$result){
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください';
    header('Location: signup_form.php');
    return;

}
//ログイン成功した時に$login_userの中にセッションファイルの中のログイン情報を入れる

$login_user = $_SESSION['login_user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
</head>
<body>
    <h2>マイページ</h2>
    <p>ログインユーザー: <?php echo h($login_user['name'])?></p>
    <p>ログインユーザー:<?php echo h($login_user['email']) ?></p>
    <!--  ログアウトリンクを押した時、　name=logoutがはいってたログアウトする  -->
    <form action="logout.php" method="POST">
        <input type="submit" name="logout" value=" ログアウト" >
    </form>

    
</body>
</html>