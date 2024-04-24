      <p>
         &nbsp;
      </p>

      <!-- footer section start -->
      <div class="footer_section layout_padding">

         <div class="container">
            <div class="row">
               <div class="col-lg-3 col-sm-6">
                  <div class="footer_logo"><img src="images/logo.png"></div>
                  <p class="footer_text">&nbsp;</p>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <h1 class="useful_text">Trotse sponsor</h1>
                  <div class="location_text">

                     <a href="https://www.premed.be"><img class="sponsor" src="images/sponsors/premed.png" /></a>

                  </div>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <h1 class="useful_text">Contacteer ons!</h1>
                  <div class="location_text">
                     <ul>
                        <li>
                           <a href="#">
                              <i class="fa fa-envelope" aria-hidden="true"></i><span class="padding_left_10"><a href="mailto:info@pronostiek.codepage.be">info@pronostiek.codepage.be</a></span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>

               <div class="col-lg-3 col-sm-6">
                  <h1 class="useful_text">Statistieken</h1>
                  <div class="location_text">
                     <?php
                     $footerdata = GetFooterData();
                     ?>
                     <ul>
                        <li>
                           Aantal commits: <?= $footerdata->commits; ?>
                        </li>

                        <li>
                           Aantal bestanden: <?= $footerdata->files; ?>
                        </li>

                        <li>
                           Lijnen code: <?= $footerdata->linesOfCode; ?>
                        </li>
                     </ul>
                  </div>
               </div>

               <div class="social_icon">
                  <ul>
                     <li><a href="https://github.com/sgezel/pronov2"><i class="fa fa-github" aria-hidden="true"></i></a></li>
                  </ul>
               </div>
            </div>
         </div>
         <!-- footer section end -->
         <!-- copyright section start -->
         <div class="copyright_section">
            <div class="container">
               <p class="copyright_text">2024 - Sandor en Dieter</p>
            </div>
            <!-- copyright section end -->
            <!-- Javascript files-->
            <script src="js/jquery.min.js"></script>
            <script src="js/popper.min.js"></script>
            <script src="js/bootstrap.bundle.min.js"></script>
            <script src="js/jquery-3.0.0.min.js"></script>
            <script src="js/plugin.js"></script>
            <!-- sidebar -->
            <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
            <script src="js/custom.js"></script>
            </body>

            </html>