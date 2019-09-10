<?php
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「マイページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//=============================
//  画面処理
//=============================
//ログイン認証
if( !empty($_SESSION['login_date']) ){
  debug('ログイン済みユーザーです。');

  //現在日時が最終ログイン日次＋有効期限を超えていた場合
  if( ($_SESSION['login_date'] + $_SESSION['login_limit']) < time()){
    debug('ログイン有効期限オーバーです。');

    // セッションを削除（ログアウトする）
    session_destroy();
    //ログインページへ
    header("Location:login.php");
  }else{
    debug('ログイン有効期限内です。');
    //最終ログイン日時を現在日時に更新
    $_SESSION['login_date'] = time();

    if(basename($_SERVER['PHP_SELF']) === 'login.php'){
      debug('マイページへ遷移します。');
      header("Location:mypage.php");
    }
  }
}else{
  debug('未ログインユーザーです。');
  if(basename($_SERVER['PHP_SELF']) !== 'login.php'){
    header("Location:login.php");
  }
}

//画面表示データ取得
//=============================
$u_id = $_SESSION['user_id'];
// DBから商品データを取得
$productData = getMyProducts($u_id);
//DBからカートデータを取得
$cartData = getMycart($u_id);

// DBからきちんとデータがすべて取れているかの確認は取らず、取れなければ何も表示しない

debug('取得した商品データ：'.print_r($productData,true));
debug('取得したお気に入りデータ'.print_r($cartData,true));

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
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



   <!--メインコンテンツ-->
    <div id="cart-contents" class="site-width">
      <h1 class="page-title">SHOPPING CART</h1>

      <!--Main-->
     
          <div class="cartbutton">
            <input type="submit" value="購入手続きに進む">
            <a href="index.php"><input type="submit" value="ショッピングを続ける"></a>
          </div>
          <div class="cartpanel-list">
           
      
            <?php
             if(!empty($cartData)):
              foreach($cartData as $key => $val):
            ?>
              <a href="productDeatail.php?p_id=<?php echo $val['id']; ?>" class="cartpanel">
                <div class="cartpanel-head">
                  <img src="<?php echo sanitize($val['pic1']); ?>" alt="<?php echo sanitize($val['name']); ?>">
                </div>
                <div class="cartpanel-body">
                  <p class="cartpanel-title"><?php echo sanitize($val['name']); ?> <span class="price">¥<?php echo sanitize(number_format($val['price'])); ?></span></p>
                </div>
              </a>
            <?php
              endforeach;
            endif;
            ?>
         </div>
    

          


    </div>


      <!--FOOTER-->
      <?php
      require('footer.php'); 
    ?>

    </body>
  </html>