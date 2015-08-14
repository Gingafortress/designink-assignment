 </body>
 <footer id="footer" >
   	<div class="row">
      	<div class="columns">
        	<ul class="small-block-grid-5 medium-offset-3 medium-6 columns text-center ">
          		<li><p><a href="category.html"><img src="img/svg/facebook.svg" alt="" class="pink-social-icons"></a></p></li>
          		<li><p><a href="category.html"><img src="img/svg/googleplus.svg" alt="" class="pink-social-icons"></a></p></li>
          		<li><p><a href="category.html"><img src="img/svg/instagram.svg" alt="" class="pink-social-icons"></a></p></li>
          		<li><p><a href="category.html"><img src="img/svg/pinterest.svg" alt="" class="pink-social-icons"></a></p></li>
          		<li><p><a href="category.html"><img src="img/svg/twitter.svg" alt="" class="pink-social-icons"></a></p></li>
        	</ul>
       	</div>
    </div>    
    
    <div class="row">
      <div class="columns">
        <ul class="no-bullet small-block-grid-2 medium-block-grid-3">
          <li><strong>Site Navigation</strong>
            <ul>
              <li><a href="index.php?page=home">Home</a></li>
              <li><a href="index.php?page=about">About</a></li>
              <li><a href="index.php?page=contact">Contact</a></li>
            </ul>
          </li>
          <li><strong>Accounts</strong>
            <ul>
              <?php
                    //if user is not logged in
                    if( !isset($_SESSION['username'] ) ) : ?>
                        <li><a href="index.php?page=sign-up">signup</a></li> 
                        <li><a href="index.php?page=login">login</a></li>
                <?php else: ?>
                        <li><a href="index.php?page=account"><?php echo $_SESSION['username']?></a></li> 
                        <li><a href="index.php?page=logout">logout</a></li>
                <?php endif; ?>

            </ul>
          </li>
          <li><strong>Addition links</strong>
            <ul>
              <li><a href="sitemap.html">Sitemap</a></li>
              <li><a href="privacy-policy.html">Privacy Policy</a></li>
              <li><a href="index.html">Terms &amp; Conditions</a></li>
             
            </ul>
          </li>
          
        </ul>
      </div>
    </div>
  </footer>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/js/vendor/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/js/foundation.min.js"></script>
  <script>
    // Initialize foundation
    $(document).foundation();

    </script>
</body>
</html>
