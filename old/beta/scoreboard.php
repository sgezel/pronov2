
<?php
session_start();
if(!isset($_SESSION["data"]) && isset($_SESSION["user"]))
	header("location: /");
?>

<?php include("header.php"); ?>


<div class=container>
            <div class=row>
          <section class="innerpage_all_wrap bg-white" style="margin-top:150px;">
        <div class=container>
            <div class=row><h2 class=heading>score<span>bord</span></h2>



                	<aside class=contentinner>
                        <ul class=ticketInfo>

                        	  <?php 
                $data = file_get_contents("data/scoreboard.json");
                $json = json_decode($data, true);
              ?>  
             
            <?php 
            $index = 1; 
            
            ?>
             <?php foreach($json as $name => $score): ?>

             	<li>
                                <ul class="t_info headline01 clearfix">
                                    <li><?= $index; ?></li>
                                    <li>
                                        <div class="headline01 clearfix"><span><?= $name ?></span></div>

                                        <?php if($index < 4 ): ?>

                                            <img src="images/<?= $index; ?>.png" height="50px;" />

                                        <?php endif; ?>
                                        
                                    </li>
                                    <li>
                                        <span class=vs><?= $score["punten"] ?> punten</span><br/>
                                        <span class="paragraph02" style="font-size:8pt;line-height:10px;display:inline-block;"> 
                                            Matchen: <?= $score["score"] ?> punten<br/>
                                            Bonusvragen: <?= $score["bonus"] ?> punten <br/>
                                            Correct: <?= $score["corruitslagen"] ?> matchen<br/>
                                        </span>
                                    </li>
                                    <li>
                                        
                                    </li>
                                </ul>
                            </li>
             	<?php $index++; ?>
            <?php endforeach; ?>
                         
                        </ul>
                        
                    </aside>
                   


                </div>
            </div>
        </div>
    </section>
            </div>
        </div>



    <?php include("footer.php"); ?>