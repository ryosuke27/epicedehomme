


<footer id="footer">
        <div class="footer">
          <nav id="footer-nav">
            <ul>
                  <li>HOME</li>
                  <li>お問い合わせ</li>
                  <li>キャンセルポリシー</li>
                  <li>FAQ</li>
            </ul>
          </nav>
          <h1><a href="index.php">ÉPICE DE HOMME</a></h1>
          <p>Copyright<span> ÉPICE DE HOMME </span>All rights reserved.</p>
        </div>
      </footer>

      
      <script>
      
      //　カートへ送信
          var $cart,
              cartProductId;
          $cart = $('.js-click-cart') || null;
          cartProductId = $cart.data('productid') || null;

          if(cartProductId !== undefined && cartProductId !== null){
          $cart.on('click',function(){
            var $this = $(this);
            $.ajax({
              type:"POST",
              url: "ajaxCart.php",
              data: { productId : cartProductId}
            }).done(function( data ){
              console.log('Ajax Success');
              window.location.href = 'mycart.php';
            }).fail(function( msg ) {
              console.log('Ajax Error');
            });
          });
        }
      </script>
<script src="https://kit.fontawesome.com/e4354bcf70.js"></script>
</body>
</html>