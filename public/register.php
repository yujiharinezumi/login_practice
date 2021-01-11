<?php
session_start();



require_once '../classes/UserLogic.php';

//エラーメッセージを配列の中に入れる
$err = [];

//$tokenという変数の中に新規作成で生成されたトークンを入れる
$token = filter_input(INPUT_POST,'csrf_token');
//トークンが無い、もしくは一致しない場合中止

if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    exit('不正なリクエストです');
}

//トークンの確認ができた後、トークンの中身を消す
//二重対策
unset($_SESSION['csrf_token']);


//バリデーション
//usernameはsignup_formのinputタグの名前を入力した値が入る
// if文の先頭に！をつけることによってからの場合、エラーメッセージを追加する
if(!$username = filter_input(INPUT_POST, 'username')){
    $err[] = 'ユーザー名を記入してください'; 
}

if(!$email = filter_input(INPUT_POST, 'email')){
    $err[] = 'メールアドレスを記入してください'; 
}

$password = filter_input(INPUT_POST, 'password');

//形式があっていた場合trueになるため！で形式が会ってなかったらエラーを出す
if (!preg_match("/\A[a-z\d]{8,100}+\z/i",$password)){
    $err[] = 'パスワードは英数8文字以上100文字以下にしてください';
}

$password_conf = filter_input(INPUT_POST, 'password_conf');

if($password !== $password_conf){
    $err[] = '確認用パスワードと異なっています';
}

//カウントメソッドでエラーが０つまりエラーが無い場合ユーザーを登録する処理を
//エラーがあれば。登録処理をしない
if(count($err) === 0){
    //ユーザーを作るメソッド
    //$hasCreatedは登録結果をtrue or falseで受け取る
    $hasCreated = UserLogic::createUser($_POST);

    if(!$hasCreated){
        $err[] = '登録に失敗しました';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録完了画面</title>
</head>
<body>
<?php if (count($err) > 0) :?>
<?php foreach($err as $e) :?>
<p><?php echo $e ?></p>
<?php endforeach ?>
<?php else :?>
<p>ユーザー登録が完了しました</p>
<p><?php endif ?></p>
<a href="./signup_form.php">戻る</a>
    
</body>
</html>