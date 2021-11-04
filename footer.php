    <!-- Footer -->
    <footer class="clearfix">
      <div class="container-fluid bt-footer-subscribe">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6">
              <p>Subscribe to Our Newsletter and WIN!</p>
            </div>
            <div class="col-md-6">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Your email address..." aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-secondary bt-" type="button" id="button-addon2">Subscribe</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid bt-footer-main">
        <div class="container pt-4 pb-1">
          <div class="row text-center my-3">
            <div class="col-md-3">
              <?php dynamic_sidebar( 'footer-1' ); ?>
            </div>
            <div class="col-md-3">
              <?php dynamic_sidebar( 'footer-2' ); ?>
            </div>
            <div class="col-md-3">
              <?php dynamic_sidebar( 'footer-3' ); ?>
            </div>
            <div class="col-md-3">
              <?php dynamic_sidebar( 'footer-4' ); ?>
            </div>
          </div>
          <div class="row my-3">
            <div class="col-sm-6">
              <a href="#">
                <img style="max-width: 100px;" src="https://www.biketravel.co/html-template/images/BT-Logo-Design-6-Plain-Temp-wht.svg" alt="Bike Travel">
              </a>
            </div>
            <div class="col-sm-6 text-right bt-footer-social align-self-center">
              <a href="#">
                <i class="fab fa-facebook"></i>
              </a>
              <a href="#">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="#">
                <i class="fab fa-youtube"></i>
              </a>
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-12 text-center" style="font-size: 10px;">
              <p>
                &copy; Copyright 2020 Bike Travel.
                <br>
                <a href="#">Privacy Policy</a> | <a href="#">Terms & Conditions</a>
              </p>
            </div>
          </div>
          <button onclick="topFunction()" id="bt-scrolltop" title="Back to Top"><i class="fas fa-chevron-up"></i></button>
        </div>
      </div>
    </footer>

    <?php
      wp_footer();
    ?>
  
  </body>
</html>