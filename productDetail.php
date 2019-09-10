<?php
require('function.php');

//=========================
//画面処理
//=========================

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　商品詳細ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//=========================
//商品IDのGETパラメータを取得
$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id'] : '';
// DBから商品データを取得
$viewData = getProductOne($p_id);
debug('取得した$p_id: '.print_r($p_id,true));


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


      <div class="product-container">
       
          <div class="title">
            
            <?php echo sanitize($viewData['name']); ?>
            
          </div>
          <div class="item-right">
              <div class="product-img-container">
                <div class="img-main">
                 <img src="<?php echo sanitize($viewData['pic1']); ?>" id="js-switch-img-main">
                </div>
               </div>
          </div>
          <div class="item-right">
              <button class="js-click-cart" aria-hidden="true" data-productid="<?php echo sanitize($viewData['id']); ?>">ショッピングカートに入れる</button>
              <p class="price">¥1,500</p>
              <div class="product-detail">
               <p>
                 煮込み料理、カレー、スープなどの下味付けに用いる。<br> ブイヨンと同じ感覚と同様に、肉の臭みを消す働きがあり、独特の苦味が味に深みを加える。<br> 使用する際に手で切れ目を入れると効果的。<br> 料理に用いる場合は乾燥させてから利用する方が、苦味が少なく香りが引き立つ。<br>トルコはローレルの世界生産のほとんどすべてを占める大産地国で、選び抜かれた高品質なローレルを供給している。
               </p>
              </div>
          </div>

  
      </div>
      <div class="backcommand">
          <a href="index.php">&lt; 買い物を続ける</a>
      </div>

    <!-- footer -->
    <?php
      require('footer.php'); 
    ?>
