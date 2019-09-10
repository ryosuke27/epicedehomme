<?php
//　共通関数・関数ファイルの読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「 Ajax ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//==============================
// Ajax処理
//==============================

//postがあり、ユーザーIDがあり、ログインしている場合
if(isset($_POST['productId']) && isset($_SESSION['user_id']) && isLogin()){
    debug('POST送信があります。');
    $p_id = $_POST['productId'];
    debug('商品ID:'.$p_id);
    //例外処理
    try { 
    //DBへ接続
    $dbh = dbConnect();
    // レコードがあるか検索
    //SELECT * cart WHERE product_id = :p_id AND user_id = :u_id
    $sql = 'SELECT * FROM cart WHERE product_id = :p_id AND user_id = :u_id';
    $data = array(':u_id' => $_SESSION['user_id'], ':p_id' => $p_id);
    // クエリ実行
    $stmt = queryPost($dbh, $sql, $data);
    $resultCount = $stmt->rowCount();
    debug('$resultCountの中身:'.$resultCount);
    // レコードが1行でもある場合
    if(!empty($resultCount)){
        //レコード削除する
        $sql = 'DELETE FROM cart WHERE product_id = : p_id AND user_id = :u_id';
        $data = array(':u_id' => $_SESSION['user_id'], ':p_id' => $p_id);
        //クエリ実行
        $stmt = queryPost($dbh, $sql, $data);
    }else{
        $sql = 'INSERT INTO cart (product_id, user_id, create_date) VALUES (:p_id, :u_id, :date)';
        $data = array(':u_id' => $_SESSION['user_id'], ':p_id' => $p_id, ':date' => date('Y-m-d H:i:s'));
        //クエリ実行
        $stmt = queryPost($dbh, $sql, $data);
      }
    } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());

    }
}
debug('Ajax処理終了　<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>