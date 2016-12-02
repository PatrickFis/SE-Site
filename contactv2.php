<div class="container">
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="10000">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <?php
        $selectQuery = "SELECT * FROM contact";
        $res = mysql_query($selectQuery);
        $dirname = "adminScripts/";
        $flag = 1;
        while($row = mysql_fetch_array($result)) {
          echo '<div class="item' .($flag?' active':''). '">'.PHP_EOL."\t\t";
          echo '<img src="'.$dirname.$row['imgPath'].'" alt=""></div>'.PHP_EOL."\t";
          echo '<div class="carousel-caption">.'PHP_EOL."\t";
          echo '<h3>.'PHP_EOL."\t";
          echo '<p>.'PHP_EOL."\t";
          echo '<p>.'PHP_EOL."\t";
          echo '<p></p>';
          echo '<p></p>';
          echo '</div>';
          $flag = 0;
        }
      ?>
      <?php
        // This code pulls a list of images for the img directory and then
        // generates code
        // $dirname = "img/";
        // $images = glob($dirname."*.jpg");
        // $flag = 1; // Make the first item active
        // foreach($images as $image) {
          // echo '<div class="item' .($flag?' active':''). '">'.PHP_EOL."\t\t";
          // echo '<img src="'.$image.'" alt=""></div>'.PHP_EOL."\t";
          // $flag = 0;
        }
       ?>
      <!-- <div class="item active">
        <img src="img/swagger_duder.jpg" alt="dude" width="460" height="345">
      </div>

      <div class="item">
        <img src="img/true_manliness.jpg" alt="manliness" width="460" height="345">
      </div>

      <div class="item">
        <img src="img/leadership_shirt.jpg" alt="shirt" width="460" height="345">
      </div> -->
    </div>

  </div>
</div>
