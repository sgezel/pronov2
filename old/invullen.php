<?php
session_start();
if(!isset($_SESSION["data"]) && !isset($_SESSION["user"]))
	header("location: /");
?>

<?php include("header.php"); ?>

<div class=container>
    <div class=row>
	<section class="innerpage_all_wrap bg-white" style="margin-top:70px;">
	
			  <form method="post" action="save.php">
<?php 
	$data = file_get_contents("data/vragen.json");
	$json = json_decode($data, true);

	$datetime1 =  DateTime::createFromFormat('Y-m-d H:i:s', $config["question_close_time"]);
	$datetime2 = new DateTime('NOW');
	$vragenlocked  = ( $datetime1 < $datetime2);
?>  

<h1>Vragen:</h1>

			 <?php foreach($json as $vragen): ?>
				<h2><?= $vragen["naam"]; ?></h2>
			
			 <div class="matchSchedule_details row">
  
                    <div class=match_versus-wrap>
                        <div class=wrap_match-innerdetails>
                            <ul class="point_table ">

							<?php foreach($vragen["vragen"] as $vraag): ?>

                                <li class=clearfix>
                                    <div class=subPoint_table>
                                        
                                        <div class="headline01 largepoint"><?= $vraag["Vraag"]; ?></div>
                                        <div class="headline01 smallpoint row row"><input type="text" class="form-control" style="float:left;" name="vraag_<?= $vraag['id']; ?>" value="<?= isset($_SESSION["data"]["vragen"]["vraag_".$vraag['id']]) ? $_SESSION["data"]["vragen"]["vraag_".$vraag['id']] : ""  ?>" <?= $vragenlocked ? "readonly" : "" ?>  class="<?= $vragenlocked ? "disabled" : "" ?>" />
                                        	<span style="float: right; color: #ccfc53;"><?= empty($_SESSION["data"]["bonus"]["vraag_".$vraag['id']]) ? "0" : $_SESSION["data"]["bonus"]["vraag_".$vraag['id']]; ?> punt(en)</span>
                                        </div>
                                    </div>
                                </li>  
							
								<?php endforeach; ?>  
                            </ul>
                        </div>
                    </div>
                </div>
			
				<?php endforeach; ?>

<?php 
  	$data = file_get_contents("data/data.json");
    $json = json_decode($data, true);				
 ?>  

<?php foreach($json as $group): ?>
	<?php $index=1; ?>

	<h1><?= $group["naam"]; ?></h1>
		  <div class="row">
                    <div class="matchSchedule_details" >
                        <div class="match_versus-wrap">
                            <ul class="home_tInfo ">
							<?php foreach($group["matches"] as $match): ?>
                                <li>
                                	<img src="images/vlaggen/<?= $match["thuis"]; ?>.jpg" class="leftflag" style="" />
                                	<img src="images/vlaggen/<?= $match["uit"]; ?>.jpg" class="rightflag" />
                            		

                                    <ul class="t_info match_info01 headline01 clearfix">
                                        <li>&nbsp;</li>
                                        <li>
										
										<?php 
											$thuis = str_replace(" ",  "_",$group["naam"]).'_'.str_replace(" ",  "_",$match['thuis']).'_' . str_replace(" ",  "_",$match['uit']).'_t';
											$uit = str_replace(" ",  "_",$group["naam"]).'_'.str_replace(" ",  "_",$match['thuis']).'_' . str_replace(" ",  "_",$match['uit']).'_u';  

											$vlag_thuis = file_exists("vlaggen/" . $match["thuis"] . ".png") ? "vlaggen/" . $match["thuis"] . ".png" : "vlaggen/default.png";
											$vlag_uit =  file_exists("vlaggen/" . $match["uit"] . ".png") ? "vlaggen/" . $match["uit"] . ".png" : "vlaggen/default.png";

											$punten =  str_replace(" ",  "_",$group["naam"]).'_'.str_replace(" ",  "_",$match['thuis']).'_' . str_replace(" ",  "_",$match['uit']);
										
                            				$pronolocked = (DateTime::createFromFormat('d/m/Y H:i', $match["datum"]) < (new DateTime('NOW'))->add(new DateInterval('PT'. $config["close_answer_before_match"] . 'H')));
                        
										?>

                                            <div class="headline01 clearfix">

													<span>	
														<div> 
														<input type="number" name="<?= $thuis ?>"  value="<?= isset($_SESSION["data"]["scores"][$thuis]) ? $_SESSION["data"]["scores"][$thuis] : ""  ?>"  <?= $pronolocked ? "readonly" : "" ?>  class="form-control <?= $pronolocked ? " disabled" : "" ?>" style="float:left; margin-right:7px;"/><?= $match["thuis"]; ?>
														</div>													
													</span>

													
													
													<span class=vs> <span style="color: #ccfc53; float:left;"> <?= $match["thuis_goals"]; ?> </span> vs <span style="color: #ccfc53; float:right;"> <?= $match["uit_goals"]; ?> </span></span> 
													
													

													<span> 
														<?= $match["uit"]; ?> <input type="number" name="<?= $uit ?>" value="<?= isset($_SESSION["data"]["scores"][$uit]) ? $_SESSION["data"]["scores"][$uit] : ""  ?>" <?= $pronolocked ? "readonly" : "" ?>  class=" form-control <?= $pronolocked ? " disabled" : "" ?>" style="float:right;"/>
													</span>
											</div>

                                            <div class="paragraph02 clearfix">
												<?php 
												$punttonen = str_replace(" ",  "_",$group["naam"]).'_'.str_replace(" ",  "_",$match['thuis']).'_' . str_replace(" ",  "_",$match['uit']);
												?>
												<span><?= $match["datum"]; ?>, <?= $match["speelstad"]; ?> <span style="float: right; color: #ccfc53;"><?= $_SESSION["data"]["points"][$punttonen]; ?> punt(en)</span> </span>
											</div>
											
                                        </li>
                                    </ul>
                                </li>
								<?php endforeach; ?>
                               
                            </ul>
                        </div>
                    </div>
                    
                </div>
                <input type="submit" value="Opslaan" class="btn btn-success" />
	
	<?php endforeach; ?>

	</div>
							</form>
							</section>
</div>



	

    <?php include("footer.php"); ?>