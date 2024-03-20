<?php
session_start();
if (!isset($_SESSION["data"]) && !isset($_SESSION["user"]))
    header("location: /");
?>
<?php include("config.php"); ?>

<?php include("header.php"); ?>

<?php 

    $userdata = [];

    $files = scandir('data/user/');
	foreach($files as $file) {
        if ($file !== "." &&  $file !== ".gitignore" && $file !== ".."  && file_exists("data/user/" . $file))
		{
			$filename = "data/user/" . $file;
			$udata =  json_decode(file_get_contents($filename), true);

            $userdata[$udata["name"]]["scores"] = $udata["scores"];
            $userdata[$udata["name"]]["point"] = $udata["points"];
            if(array_key_exists("extra", $udata))
	   	 $userdata[$udata["name"]]["extra"] = $udata["extra"];
       }
    }

    $data = file_get_contents("data/data.json");
    $json = json_decode($data, true);	
    $json = array_reverse($json);	
    
    $display_data = [];

    foreach($json as $group){
       

        foreach(array_reverse($group["matches"]) as $match){
            $pronolocked = (DateTime::createFromFormat('d/m/Y H:i', $match["datum"]) < (new DateTime('NOW'))->add(new DateInterval('PT'. $config["close_answer_before_match"] . 'H')));

            if($pronolocked || isset($_GET["all"]))
            {
               $display_data[$group["naam"]][] = $match;
            }
        }
    }


?>

<div class=container>
            <div class=row>
          <section class="innerpage_all_wrap bg-white" style="margin-top:150px;">
        <div class=container>
            <div class=row><h2 class=heading>over<span>zicht</span></h2>


            <?php foreach($display_data as $group => $data): ?>
                <h2><?= $group ?></h2>
            
                <?php foreach($data as $match): ?>

                    <?php

                    $matchname = str_replace(" ", "_", $group);
                    $matchname .= "_" .  str_replace(" ", "_", $match["thuis"]);
                    $matchname .= "_" .  str_replace(" ", "_", $match["uit"]);

                    ?>

                    <h3>
                        <?= $match["thuis"] ?> - <?= $match["uit"] ?>
                        <?php if($match["thuis_goals"] != ""): ?>

                            (<?= $match["thuis_goals"]?> - <?= $match["uit_goals"] ?>  )

                        <?php endif; ?>
                    </h3>

                    <table class="matchoverzicht">
                        <tr>
                            <th>
                                Naam
                            </th>
                            <th>
                                Thuis
                            </th>
                            <th>
                                Uit
                            </th>
                            <th>
                                Punten
                            </th>
                        </tr>

                        <?php foreach($userdata as $username => $data): ?>

<?php
			$isadmin = (isset($_SESSION["data"]["admin"]) && $_SESSION["data"]["admin"] == true);
                        $isextra = (isset($_SESSION["data"]["extra"]) && $_SESSION["data"]["extra"] == true);
                        if(array_key_exists("extra", $data) && !($isadmin || $isextra))
                                continue;                        
?>
                            <tr>
                                <td>
                                    <?= $username ?>
                                </td>
                                <td>
                                    <?= $userdata[$username]["scores"][$matchname .  "_t"] ?>
                                </td>
                                <td>
                                <?= $userdata[$username]["scores"][$matchname .  "_u"] ?>
                                </td>
                                <td>
                                <?= $userdata[$username]["point"][$matchname] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </table>
                    
                <?php endforeach; ?>

            <?php endforeach; ?>

           </section>
    </div>
</div>

<?php include("footer.php"); ?>
