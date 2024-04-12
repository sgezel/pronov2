<?php
require_once("header.php");
include_once("UserCrud.php");
include_once("MatchCrud.php");
include_once("QuestionCrud.php");
$crud = new UserCrud();
$matchCrud = new MatchCrud();
$questionCrud = new QuestionCrud();
$settingCrud = new SettingCrud();

CheckAccess(); 

$userData = $crud->actionUserDataById($_SESSION["userid"]);
$allMatchData = $matchCrud->actionRead();
$allQuestionData = $questionCrud->actionRead();
?>


<div class="blog_section layout_padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="blog_taital">Pronostiek invullen</h1>
      </div>

      <div class="alert alert-dark" role="alert">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="flexSwitchQuickPick" <?= $userData["quickpicker"] == "true" || $userData["quickpicker"] == "on" ? "checked" : ""; ?> name="quickpick">
          <label class="form-check-label" for="flexSwitchQuickPick">QuickPick&trade; inschakelen.</label><strong> <a href="quickpick.php">Lees hier meer over de nieuwe QuickPick&trade; feature!</a> </strong>
        </div>
      </div>

    </div>
    <div class="blog_section_2">
      
      <div>
      <form method="post" action="action_main_save.php">
      <h2>Vragen</h2>
                        <table class="table table-hover">
                                    <thead>
                                    </thead>
                        <?php foreach ($allQuestionData as $id => $data) :?>
                            <tr>
                                        <td><?= $id ?></td>
                                        <td><?= $data["question"]; ?></td>
                                        <td><input type="text" class="form-control" <?= $data["locked"] ? "readonly disabled" : "" ?> name="questions[<?= $id; ?>][answer]" value="<?= isset($userData["questions"][$id]["answer"]) ?  $userData["questions"][$id]["answer"] : "" ?>" /></td>
                                        <td><?= isset($userData['questions'][$id]['points']) ? $userData["questions"][$id]["points"] . "p" : "" ?></td>
                                    </tr>
                        <?php endforeach; ?>
                        </table>  
      <h2>Wedstrijden</h2>
        <?php $round = "";
        $rounddesc = ""; ?>        
        <table class="table table-hover w-100">
              <thead>
             
              </thead>
              <tbody>
        <?php foreach ($allMatchData as $id => $data) :
          if (strcmp($round, $data["round"]) != 0) :
            if ($round != "") : ?>
              
            <?php endif;

            $round = $data["round"];
            if ($round == "1") {
              if ($settingCrud->actionGetSetting("round1") == true) {
                $rounddesc = "Groepsfase";
              } else {
                break;
              }
            }
            if ($round == "2") {
              if ($settingCrud->actionGetSetting("round2") == true) {
                $rounddesc = "Achtste finale";
              } else {
                break;
              }
            }
            if ($round == "3") {
              if ($settingCrud->actionGetSetting("round3") == true) {
                $rounddesc = "Kwartfinale";
              } else {
                break;
              }
            }
            if ($round == "4") {
              if ($settingCrud->actionGetSetting("round4") == true) {
                $rounddesc = "Halve finale";
              } else {
                break;
              }
            }
            if ($round == "5") {
              if ($settingCrud->actionGetSetting("round5") == true) {
                $rounddesc = "Finale";
              } else {
                break;
              }
            } ?>
            <tr class="table-light gridHeaderTitle"><td colspan="9"><h2><?= $rounddesc; ?></h2></td></tr>
            
              <?php endif; ?>

              <tr class="daterow">
                <td colspan="9"><nobr><?= date_format(date_create($data["date"]), 'd/m'); ?> <?= $data["time"]; ?></nobr></td>
              </tr>
              <tr>
                <td class="datefield">
                    <?= date_format(date_create($data["date"]), 'd/m'); ?> <?= $data["time"]; ?>
                </td>
                
                <td>
                  <img src=".\\vlaggen\\<?= $data["home"]; ?>.png" class="flag"><?= $data["home"]; ?>
                </td>
                <td><?= $data["home_score"]; ?></td>
                <td><input type="number" width="20px" class="form-control input-score" <?= $data["locked"] ? "readonly disabled" : "" ?> name="matches[<?= $id; ?>][home]" value="<?=  isset($userData["matches"][$id]["home"]) ?  $userData["matches"][$id]["home"] : "" ?>" ?></td>
                <td> - </td>
                <td><input type="number" width="20px" class="form-control input-score" <?= $data["locked"] ? "readonly disabled" : "" ?> name="matches[<?= $id; ?>][away]" value="<?=  isset($userData["matches"][$id]["away"]) ?  $userData["matches"][$id]["away"] : ""?>" ?></td>
                <td><?= $data["away_score"]; ?></td>
                <td><?= $data["away"] ?><img src=".\\vlaggen\\<?= $data["away"]; ?>.png" class="flag"></td>
                <td><?= isset($userData['matches'][$id]['points']) ? $userData["matches"][$id]["points"] . "p" : "" ?></td>
              </tr>

            <?php endforeach; ?>
            </tbody>
              </table>
            <tr>
              <td colspan="9">
                <input type="submit" value="Opslaan" class="btn btn-primary w-100" />
              </td>
            </tr>
              </tbody>
            </table>
      </form>
      </div>

    </div>
  </div>
</div>

<script>
  var checkbox = document.getElementById('flexSwitchQuickPick');
  checkbox.addEventListener("change", functionname, false);

  function functionname() {
    var isChecked = checkbox.checked;

    var http = new XMLHttpRequest();
    var url = 'action_user_quickpick.php';
    var params = 'quickpick=' + isChecked;
    http.open('POST', url, true);

    //Send the proper header information along with the request
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() { //Call a function when the state changes.
      if (http.readyState == 4 && http.status == 200) {

      }
    }
    http.send(params);
  }
</script>

<?php
require_once("footer.php");
?>