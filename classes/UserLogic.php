<?php

require_once '../dbconnect.php';

class UserLogic
{

    /**
     * ユーザーを登録する
     * @param  array $userData
     * @return bool $result
     */

    public static function createUser($userData){
        //userDataの中身は$_POST
        //最初に$resultの値をfalseにしておき、成功した時のみtrueに書き換わる処理を行う
        $result = false;
        //プレースホルダーではてなを使う
        $sql = 'INSERT INTO users (name,email,password) VALUE (?,?,?)';

        //?に値を入れる方法
        
        //ユーザーデータを配列に入れます
        $arr = [];
        //VALUESの１個目の?に入る
        $arr[] = $userData['username'];
        //VALUESの2個目の?に入る
        $arr[] = $userData['email'];
        //VALUESの３個目の?に入る
        //パスワードをハッシュ化する
        $arr[] = password_hash($userData['password'],
        PASSWORD_DEFAULT);

        try{
            $stmt = connect()->prepare($sql);
            //ここでarrを引数に入れることによってプレースホルダーの部分が置き換わり、SQLが実行できる
            //executeは成功するとtrueを返します
            $result = $stmt->execute($arr);
        }catch(\Exception $e){
            //失敗した場合はfalseとなる
            return $result;
        }
        //成功した場合ここの$resultはtrueになる
        return $result;

    }

    /**
     * ログイン処理
     * @param  stirng $email
     * @param  stirng $password
     * @return bool $result
     */

    public static function login($email,$password){

        //結果
        $result = false;

        //ユーザをメールアドレスから検索する
        $user = self::getUserByEmail($email);
        
        if (!$user){
            $_SESSION['msg'] = 'emailが一致しません';
            //メールアドレスが一致しない場合、ログインを失敗させるためfalseにする
            return $result;
        }
        //パスワードの照会
        //第一引数にログイン時に入力したパスワード、第二引数にユーザー登録時に登録したパスワード
        //成功したらtrueを返す
        if(password_verify($password,$user['password'])){
            //ログイン成功処理
            session_regenerate_id(true);
            //セッションファイルの中に$login_userを作り、その中に$user(メールアドレスから検索してきたユーザーのデータのこと)を入れる
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }

        //パスワードがい一致しない場合
        $_SESSION['msg'] = 'パスワードが一致しません';
        //$resultをfalseのままにして処理を失敗させる
        return $result;

    }

    /**
     * メールアドレスからユーザーを取得する
     * @param  stirng $email
     * @return array bool $user false
     */

    public static function getUserByEmail($email){


        //SQLの準備
        //SQLの実行
        //SQLの結果を返す
        $result = false;
        $sql = 'SELECT * FROM users WHERE email = ?';

        //emailを配列に入れる
        $arr = [];
        $arr[] = $email;

        try{
            $stmt = connect()->prepare($sql);
            //ここでプレースホルダーの？の中にメールメールアドレスを入れる 
            $stmt->execute($arr);
            //SQLの結果を返す
            $user = $stmt->fetch();
            //$userの中はユーザーの情報が配列で入っている
            //実行したらtrueを返す
            return $user; 

        }catch(\PDOException $e){
            echo 'SQLの実行に失敗しました';
            return $result;

        }
    }

    /**
     *  ログインチェック
     * @param  stirng void
     * @return  bool $result
     */

    public static function checkLogin()
    {
        $result = false;
        //セッションにログインユーザーが入っていなかったらfalseにする
        //セッションの中にログインユーザーがあって、ログインユーザーの中にIDがあるかどうか
        if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0){
            return $result = true;
        }

        return $result;
    
    }

    /**
     * ログアウト処理
     */

     public static function logout()
     {
         //まずはセッションの中身をからにします
         $_SESSION = array();
         //セッションを消す
         session_destroy();
     }

}




?>