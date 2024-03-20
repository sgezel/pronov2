<?php include("header.php"); ?>

<div class=container>
            <div class=row>
            <section class="map_wrapper clearfix" style="padding: 150px 0 0 0;">
        <div class=container>
            <div class=row>
                <div class=contact_form><h2 class=heading>regi<span>streren</span></h2>

                   <form method="post" action="saveregister.php" data-parsley-validate="" name=register class="formcontact clearfix">
                        <div class="form-group" style="width:100%; padding-left:0px; padding-right:0px;"><input type="text" class="form-control" style="width:100%;" name="username" placeholder="Email" required="" data-parsley-required-message=""></div>
                        <div class="form-group" style="width:100%; padding-left:0px; padding-right:0px;"><input type="text" class="form-control" style="width:100%;" name="name" placeholder="Naam" required="" data-parsley-required-message=""></div>
                        <div class="form-group" style="width:100%; padding-left:0px; padding-right:0px;"><input type="password" class="form-control"  style="width:100%;" name="password" placeholder="Wachtwoord" required="" data-parsley-required-message=""></div> 
                        
                        <input type=submit class="btn btn-red" value="Registreren!" />
                        <div class=form-message></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
            </div>
        </div>



    <?php include("footer.php"); ?>