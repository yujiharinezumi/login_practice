<?php

//XSS対策:エスケープ処理
//第一引数、エスケープしたいもの、第二引数エスケープの内容、第３引数文字コード
/**
 * @param string　対象の文字列
 * @return string 処理された文字列
 */

function h($str){
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}


/**
 * CSRF対策　
 * @param void
 * @return string $csrf_token
 * 
 */

function setToken(){
    ///トークンを生成
    //フォームからそのトークンを送信
    //送信後の画面でそのとトークンを照会
    //トークンを削除

    
    //$csrf_tokenに生成したトークンを入れる
    $csrf_token = bin2hex(random_bytes(32));
    //先ほど生成したトークンをセッションファイルに入れる
    $_SESSION['csrf_token'] = $csrf_token;

    return $csrf_token;
}

?>