<?php
require_once("header.php");
include_once("UserCrud.php");
include_once("MatchCrud.php");

$crud = new UserCrud();
$matchCrud = new MatchCrud();
$settingCrud = new SettingCrud();

$data = $crud->actionUserDataById($_SESSION["userid"]);
$allMatchData = $matchCrud->actionRead();
?>



<div class="blog_section layout_padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="blog_taital">Pronostiek invullen</h1>
      </div>

      <div class="alert alert-dark" role="alert">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="flexSwitchQuickPick" <?= $data["quickpicker"] == "true" || $data["quickpicker"] == "on" ? "checked" : ""; ?> name="quickpick">
          <label class="form-check-label" for="flexSwitchQuickPick">QuickPick&trade; inschakelen.</label><strong> <a href="quickpick.php">Lees hier meer over de nieuwe QuickPick&trade; feature!</a> </strong>
        </div>
      </div>

    </div>
    <div class="blog_section_2">

      <div>
      <form method="post" action="action_main_save.php">

        <?php $round = "";
        $rounddesc = ""; ?>
        <?php foreach ($allMatchData as $id => $data) :
          if (strcmp($round, $data["round"]) != 0) :
            if ($round != "") : ?>
              </tbody>
              </table>
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
            <h2><?= $rounddesc; ?></h2>
            <table class="table table-hover w-100">
              <thead>
             
              </thead>
              <tbody>
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
                <td><input type="number" width="20px" class="form-control input-score" name="matches[<?= $id; ?>][home]" value="" ?></td>
                <td> - </td>
                <td><input type="number" width="20px" class="form-control input-score" name="matches[<?= $id; ?>][away]" value="" ?></td>
                <td><?= $data["away_score"]; ?></td>
                <td><?= $data["away"] ?><img src=".\\vlaggen\\<?= $data["away"]; ?>.png" class="flag"></td>
              </tr>

            <?php endforeach; ?>
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