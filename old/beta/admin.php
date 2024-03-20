<?php
session_set_cookie_params(604800);
session_start();
if(!isset($_SESSION["data"]["admin"]) && $_SESSION["data"]["admin"]!=true)
	header("location: /");
?>

<?php include("header.php"); ?>

<?php if ($logged_in): ?>
  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="mt-5">Pr(emed)onostiek Admin</h1>
        <form method="post" action="saveadmin.php">
          <table border=1 id="pronostiek">

            <?php 
            $data = file_get_contents("data/data.json");
            $json = json_decode($data, true);
            ?>  

            <?php foreach($json as $group): ?>
              <tr>
                <td colspan="6" class="header"><?= $group["naam"]; ?></td>
              </tr>
              <tr>
                <td class="subheader">datum + tijd</td>
                <td class="subheader" colspan=5>Score</td>
              </tr>
              <?php foreach($group["matches"] as $match): ?>
                <?php 
                $thuis = $group["naam"].'_'.str_replace(" ",  "_",$match['thuis']).'_' . str_replace(" ",  "_",$match['uit']).'_t';
                $uit = $group["naam"].'_'.str_replace(" ",  "_",$match['thuis']).'_' . str_replace(" ",  "_",$match['uit']).'_u';  

                $vlag_thuis = file_exists("vlaggen/" . $match["thuis"] . ".png") ? "vlaggen/" . $match["thuis"] . ".png" : "vlaggen/default.png";
                $vlag_uit =  file_exists("vlaggen/" . $match["uit"] . ".png") ? "vlaggen/" . $match["uit"] . ".png" : "vlaggen/default.png";

                ?>
                <tr class="vraag">

                  <td> <?= $match["datum"]; ?></td>
                  <td class="nowrap"><?= $match["thuis"]; ?></td>
                  <td> <img class="" src="<?= $vlag_thuis; ?>"/></td>
                  <td class="nowrap">
                    <input type="number" name="<?= $thuis ?>" value="<?= $match["thuis_goals"]; ?>"/> 
                    - 
                    <input type="number" name="<?= $uit ?>" value="<?= $match["uit_goals"]; ?>"/>
                  </td>
                  <td> <img class="" src="<?= $vlag_uit; ?>"/></td>
                  <td class="nowrap"><?= $match["uit"]; ?> </td>
                </tr>


              <?php endforeach; ?>
            <?php endforeach; ?>
            <tr>
              <td colspan="6"><input type="submit" value="Opslaan" class="btn btn-success" /></td>
            </tr>
          </table>

          <?php
          $files = scandir('data/user/');
          $vragen = [];

          $bonusvragenjuist = [];

          $contestants = "";

          foreach($files as $file) {
           if ($file !== "." && $file !== ".."  && file_exists("data/user/" . $file))
           {
            $filename = "data/user/" . $file;
            $userdata =  json_decode(file_get_contents($filename), true);

            $contestants .= str_replace(".json", ";",$file);

            if(array_key_exists("vragen", $userdata))
            {
             $vragen[$userdata["name"]]["username"] = $userdata["username"];
             foreach ($userdata["vragen"] as $vraag => $antwoord) {
               $vragen[$userdata["name"]]["vragen"][$vraag] = $antwoord;
             }
           }	

           if(array_key_exists("bonus", $userdata))
           {
             foreach($userdata["bonus"] as $id => $punten)
             {
              $bonusvragenjuist[$userdata["username"]][$id] = true; 
            }

          }



        }
      }

      $data = file_get_contents("data/vragen.json");
      $vraagdata = json_decode($data, true);

      $vraagzinnen = [];

      foreach($vraagdata as $vraaggroep)
      {
       foreach($vraaggroep["vragen"] as $vrdata)
       {
        $vraagzinnen["vraag_" .$vrdata["id"]] = $vrdata["Vraag"];
      }
    }               				

	ksort($vragen);
    ?>

    <table border=1>
     
     <?php foreach($vragen as $user => $data): ?>
      <tr>
         <td class="header" colspan="3"><?= $user; ?></td>
      </tr>
      <tr>
       <td class="subheader">Vraag</td>
       <td class="subheader">Antwoord</td>
       <td class="subheader">Correct?</td>
     </tr>
      <?php foreach($data["vragen"] as $vraagid => $antwoord): ?>
        <tr>
          <td><?= $vraagzinnen[$vraagid]; ?></td>
          <td><?= $antwoord; ?></td>
          <td><input type="checkbox" name="antwoorden[<?= $data["username"]; ?>][<?= $vraagid; ?>]" <?=  isset($bonusvragenjuist[$data["username"]][$vraagid]) ? "checked" : "" ?> /></td>
        </tr>
      <?php endforeach; ?>

    </tr>
  <?php endforeach; ?>
</table>

</form>
</div>



</div>

<div class="row">
  <div class="col-lg-12 text-center">
  	<p class="wit">
   	<a href="mailto:<?= $contestants;  ?>?subject=Pr(emed)onostiek Update" class="btn btn-warning">Alle deelnemers mailen</a>
   </p>
	</div>
</div>

<div class="row">
  <div class="col-lg-12 text-center">
    <form method="post" action="saveadmin.php">
      <p class="wit">
      <input type="submit" onclick="function(){ var ver = document.getElementById('verification'); return ver.value.toLowerCase() === "reset";}" value="Reset ALLE speler data" class="btn btn-danger" name="reset_all_data" /> 
      Typ "reset" in het volgende vak: <input type="text" id="verification" name="verification" required />
    </p>
    </form>
	</div>
</div>





</div>



</div>
<?php endif; ?>
<?php include("footer.php"); ?>