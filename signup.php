<?php

//共通変数・関数ファイルを読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「ログインページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//post送信されていた場合
if(!empty($_POST)){

  //変数にユーザー情報を代入
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $pass_re = $_POST['pass_re'];

  //未入力チェック
  validRequired($email, 'email');
  validRequired($pass, 'pass');
  validRequired($pass_re, 'pass_re');

  if(empty($err_msg)){

    //emailの形式チェック
    validEmail($email, 'email');
    //emailの最大文字数チェック
    validMaxLen($email, 'email');
    //email重複チェック
    validEmailDup($email);

    //パスワードの半角英数字チェック
    validHalf($pass, 'pass');
    //パスワードの最大文字数チェック
    validMaxLen($pass, 'pass');
    //パスワードの最小文字数チェック
    validMinLen($pass, 'pass');

    //パスワード（再入力）の最大文字数チェック
    validMaxLen($pass_re, 'pass_re');
    //パスワード（再入力）の最小文字数チェック
    validMinLen($pass_re, 'pass_re');

    if(empty($err_msg)){

      //パスワードとパスワード再入力が合っているかチェック
      validMatch($pass, $pass_re, 'pass_re');

      if(empty($err_msg)){

        //例外処理
        try {
          // DBへ接続
          $dbh = dbConnect();
          // SQL文作成
          $sql = 'INSERT INTO users (email,password,login_time,create_date) VALUES(:email,:pass,:login_time,:create_date)';
          $data = array(':email' => $email, ':pass' => password_hash($pass, PASSWORD_DEFAULT),
                        ':login_time' => date('Y-m-d H:i:s'),
                        ':create_date' => date('Y-m-d H:i:s'));
          // クエリ実行
          $stmt = queryPost($dbh, $sql, $data);
          
          // クエリ成功の場合
          if($stmt){
            //ログイン有効期限（デフォルトを１時間とする）
            $sesLimit = 60*60;
            // 最終ログイン日時を現在日時に
            $_SESSION['login_date'] = time();
            $_SESSION['login_limit'] = $sesLimit;
            // ユーザーIDを格納
            $_SESSION['user_id'] = $dbh->lastInsertId();

            debug('セッション変数の中身：'.print_r($_SESSION,true));

            header("Location:index.php"); //マイページへ
          }

        } catch (Exception $e) {
          error_log('エラー発生:' . $e->getMessage());
          $err_msg['common'] = MSG07;
        }

      }
    }
  }
}
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
          
          <div id="customers-signup">
          <form action="" class="form" method="post"> 
                 <h2 class="title1">まだ会員登録がお済みでないお客様</h2>
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
                  <label class="<?php if(!empty($err_msg['email'])) echo 'err';?>">
                         メールアドレス（確認用）<br>
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
                  <label class="<?php if(!empty($err_msg['pass_re'])) echo 'err';?>">
                     パスワード（確認用）<br>
                     <input type="password" name="pass_re" value="<?php if(!empty($_POST['pass_re'])) echo $_POST['pass_re']; ?>" >   
                    </label>
                    <div class="area-msg">
                      <?php 
                        if(!empty($err_msg['pass_re'])) echo $err_msg['pass_re'];
                      ?>
                  </div>
                     
                      <label>
                             <input type="checkbox" name="pass_save">
                             ログイン情報を保存する
                      </label>
                    
                     <div class="btn_group">
                             <input type="submit" value="LOGIN">
                     </div>
                 </section>
             </form> 
         </div>
      </main>



      <?php
      require('footer.php'); 
    ?>