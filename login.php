<?php

//共通変数・関数ファイルを読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「ログインページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

//==========================
// ログイン画面処理
//==========================
// post送信されていた場合
if(!empty($_POST)){
  debug('POST送信があります。');

  //変数にユーザー情報を代入
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $pass_save = (!empty($_POST['pass_save'])) ? true : false;

  //emailの形式チェック
  validEmail($email, 'email');
  //emailの最大文字数チェック
  validMaxLen($email, 'email');

  //パスワードの半角英数字チェック
  validHalf($pass, 'pass');
  validMaxLen($pass, 'pass');
  validMinLen($pass, 'pass');

  //未入力チェック
  validRequired($email, 'email');
  validRequired($email, 'email');

  if(empty($err_msg)){
    debug('バリデーションOKです。');

    //例外処理
    try {
    //DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql = 'SELECT password,id FROM users WHERE email = :email AND delete_flg = 0';
    $data = array(':email' => $email);
    //クエリ実行
    $stmt = queryPost($dbh, $sql, $data);
    //クエリ結果の値を取得
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    debug('クエリ結果の中身：'.print_r($result,true));

    //パスワード照合
    if(!empty($result) && password_verify($pass, array_shift($result))){
      debug('パスワードがマッチしました。');

      //ログイン有効期限（デフォルトを1時間とする）
      $sesLimit = 60*60;
      //最終ログイン日時を現在日時に
      $_SESSION['login_date'] = time();

      //ログイン保持にチェックがある場合
      if($pass_save){
        debug('ログイン保持にチェックがあります。');
        //ログイン有効期限を30日にセット
        $_SESSION['login_limit'] = $sesLimit * 24 * 30;
      }else{
        debug('ログイン保持にチェックはありません');
        //次回からrログイン保持しないのでｍログイン有効期限を1時間後にセット
        $_SESSION['login_limit'] = $sesLimit;
      }
      //ユーザーIDを格納
      $_SESSION['user_id'] = $result['id'];

      debug('セッション変数の中身：'.print_r($_SESSION,true));
      debug('マイページへ遷移します。');
      header('Location:index.php');
    }else{
      debug('パスワードがアンマッチです。');
      $err_msg['common'] = MSG09;
    }

  } catch (Exception $e) {
    error_log('エラー発生：' . $e->getMessage());
    $err_msg['common'] = MSG07;
  }
}
}
debug('画面表示処理終了　<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>


<?php
$siteTitle = 'HOME';
require('head.php'); 
?>

    <body>
       <!-- ヘッダー -->
    <?php
      require('header.php'); 
    ?>



 
      <main id="main" role="main" >
          <div id="customers-signin">
             <form action="" class="form" method="post"> 
                 <h2 class="title1">会員登録がお済みのお客様</h2>
                 <section class="form_block">
                 <div class="area-msg">
                    <?php 
                      if(!empty($err_msg['common'])) echo $err_msg['common'];
                     ?>
                 </div>
                     <label class="<?php if(!empty($err_msg['email'])) echo 'err';?>">
                         メールアドレス<br>
                        　<input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>" >   
                     </label>
                  <div class="area-msg">
                      <?php 
                        if(!empty($err_msg['email'])) echo $err_msg['email'];
                      ?>
                  </div>
                  <label class="<?php if(!empty($err_msg['pass'])) echo 'err';?>">
                     パスワード<br>
                     <input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>" >   
                    </label>
                    <div class="area-msg">
                      <?php 
                        if(!empty($err_msg['pass'])) echo $err_msg['pass'];
                      ?>
                  </div>
                     
                      <label>
                             <input type="checkbox" name="pass_save">
                             ログイン情報を保存する
                      </label>
                    
                     <div class="btn_group">
                             <input type="submit" value="LOGIN">
                     </div>
                     <a href="signup.php">まだ登録がお済みでない方はこちら</a>
                 </section>
             </form> 
          </div>
          
         
      </main>


<!--footer-->
      <?php
      require('footer.php'); 
    ?>
    </body>
  </html>