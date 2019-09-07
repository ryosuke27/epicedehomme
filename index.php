<?php

require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　トップページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();
//================================
// 画面処理
//================================

// 画面表示用データ取得
//================================
// GETパラメータを取得
//--------------------------------
// カレントページ
$currentPageNum = (!empty($_GET['p'])) ? $_GET['p'] : 1; //デフォルトは1ページ目
// カテゴリー
$category = (!empty($_GET['c_id'])) ? $_GET['c_id'] : '';
// ソート順
$sort = (!empty($_GET['sort'])) ? $_GET['sort'] : '';
// パラメータに不正な値が入っているかチェック
if(!is_int($currentPageNum)){
  error_log('エラー発生:指定ページに不正な値が入りました');
  header("Location:index.php"); //トップページへ
}
$listSpan = 20;
// 現在の表示レコード先頭を算出
$currentMinNum = (($currentPageNum-1)*$listSpan); //1ページ目なら(1-1)*20 = 0 、 ２ページ目なら(2-1)*20 = 20
// DBから商品データを取得
$dbProductData = getProductList($currentMinNum, $category, $sort);
// DBからカテゴリデータを取得
$dbCategoryData = getCategory();
//$dbProductData = getProductAll($currentMinNum, $category, $sort);
debug('$dbProductDataの中身：'.print_r($dbProductData,true));

debug('画面表示処理終了　<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
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


    <div id="hero">
      
      <img src="img/spicetitle01.jpeg">
      <h2><span>Let  you  Chill  out.<br>Let  heat  your  tongue.</span></h2>
    </div>

    <div id="about">
      <h1>ABOUT ÉPICE DE HOMME</h1>
    <div class="about-containers">
      <div class="about-container">
        <img src="img/spicyback.jpg">
      </div>
      <div class="about-container">
        <div class="text">
        <h2><span>男性の趣向、生活スタイルを</span><br>
        <span>研究し尽くしたからこそできた</span><br>
        <span>新しいスパイスブランド</span></h2>
        <p>男性のライフスタイルは、ビジネスやトレーニングなどに時間を割き、<br>食事にあまり手をかけられないという特徴があります。<br>
          男性が不足しがちな栄養素を多く含んだスパイスやハーブを厳選し、<br>スマートかつクールなパッケージングをすることで、<br>男性がより楽しく手軽に料理をすることをライフワークとして位置づけます。</p>
        </div>
      </div>
      </div>
    </div>
    <div id="container">

      <h1>PRODUCT</h1>
      
        <div class="items">
          <div class="item">
          
          <input type="image" id="spiceCategory" src="img/spice1.jpg">
          <p>SPICE</p>
          
          
          </div>
          <div class="item">
          <input type="image" src="img/spice2.jpg">
          <p>ORGANIC SPICE</p>
          
          </div>
          <div class="item">
          <input type="image" src="img/herb1.jpg">
          <p>HERB</p>
         
        </div>
        <div class="item">
          <input type="image" src="img/herb2.jpg">
          <p>ORGANIC HERB</p>
          
        </div>
      </div>
    </div>


    <!--メインコンテンツ-->
  <div id="categoryDetail" >
   <div class="one-container">     
    
    <h1>SPICE</h1>
    <p>世界各国から最高基準の品質を満たしたスパイスのみを取り寄せ、<br>
        不純物が確実にないよう選別を行ってから包装をおこなっています。<br>
        スパイスには種類ひとつひとつにそれぞれのストーリーがあり、それを<br>
        感じるさせる香りがあります。</p>

     

    </div>

   <!-- main -->
   
   
    <div class="panel-list">
      <?php
        foreach($dbProductData['data'] as $key => $val):
      ?>
        <a href="productDetail.php?p_id=<?php echo $val['id']; ?>" class="panel">
          <div class="panel-head">
            <img src="<?php echo sanitize($val['pic1']); ?>" alt="<?php echo sanitize($val['name']); ?>">
          </div>
          <div class="panel-body">
            <p class="panel-title"><?php echo sanitize($val['name']); ?></span></p>
            <p class="panel-title">¥<?php echo sanitize($val['price']); ?>-</span></p>
          </div>
        </a>
    <?php
      endforeach;
    ?>
    </div>
   
 

 <div class="one-container">  
  <h1>ORGANIC SPICE</h1>
  <p>厳しい生産基準を満たし、生産された有機の食品のみにつけられる<br>
       有機JASマークの認証を得たものだけを扱っています。<br>
        通常、流通しているスパイスとは違い、香りが強く野性味あふれる<br>
        風味が特徴で、パンチの強い料理が作りたいときにはうってつけです。</p>
<!--メインコンテンツ-->
      

      </div>

   <!-- main -->
   
 
    <div class="panel-list">
      <?php
        foreach($dbProductData['data'] as $key => $val):
      ?>
        <a href="productDetail.php"<?php echo (!empty(appendGetParam())) ? appendGetParam().'&p_id='.$val['id'] : '?p_id='.$val['id']; ?>" class="panel">
          <div class="panel-head">
            <img src="<?php echo sanitize($val['pic1']); ?>" alt="<?php echo sanitize($val['name']); ?>">
          </div>
          <div class="panel-body">
            <p class="panel-title"><?php echo sanitize($val['name']); ?></span></p>
            <p class="panel-title">¥<?php echo sanitize($val['price']); ?>-</span></p>
          </div>
        </a>
    <?php
      endforeach;
    ?>
    </div>
    
  

 <div class="one-container">   
 
    <h1>HERB</h1>
    <p>世界各国から最高基準の品質を満たしたスパイスのみを取り寄せ、<br>
        不純物が確実にないよう選別を行ってから包装をおこなっています。<br>
        スパイスには種類ひとつひとつにそれぞれのストーリーがあり、それを<br>
        感じるさせる香りがあります。</p>

  </div>
   
    <div class="panel-list">
      <?php
        foreach($dbProductData['data'] as $key => $val):
      ?>
        <a href="productDetail.php?p_id=<?php echo $val['id']; ?>" class="panel">
          <div class="panel-head">
            <img src="<?php echo sanitize($val['pic1']); ?>" alt="<?php echo sanitize($val['name']); ?>">
          </div>
          <div class="panel-body">
            <p class="panel-title"><?php echo sanitize($val['name']); ?></span></p>
            <p class="panel-title">¥<?php echo sanitize($val['price']); ?>-</span></p>
          </div>
        </a>
    <?php
      endforeach;
    ?>
    </div>
   
 
 
</div>
<div class="one-container">  
   
    <h1>ORGANIC HERB</h1>
    <p>厳しい生産基準を満たし、生産された有機の食品のみにつけられる<br>
       有機JASマークの認証を得たものだけを扱っています。<br>
        通常、流通しているスパイスとは違い、香りが強く野性味あふれる<br>
        風味が特徴で、パンチの強い料理が作りたいときにはうってつけです。</p>
 </div>
   
    <div class="panel-list">
      <?php
        foreach($dbProductData['data'] as $key => $val):
      ?>
        <a href="productDetail.php?p_id=<?php echo $val['id']; ?>" class="panel">
          <div class="panel-head">
            <img src="<?php echo sanitize($val['pic1']); ?>" alt="<?php echo sanitize($val['name']); ?>">
          </div>
          <div class="panel-body">
            <p class="panel-title"><?php echo sanitize($val['name']); ?></span></p>
            <p class="panel-title">¥<?php echo sanitize($val['price']); ?>-</span></p>
          </div>
        </a>
    <?php
      endforeach;
    ?>
    </div>
    
 
 
</div>
 </div>  

    <!-- footer -->
    <?php
      require('footer.php'); 
    ?>
