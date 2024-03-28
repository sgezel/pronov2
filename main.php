
<?php
require_once("header.php");
include_once("UserCrud.php");
include_once("MatchCrud.php");

$crud = new UserCrud();
$matchCrud = new MatchCrud();

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
              $rounddesc = "Groepsfase";
            }
            if ($round == "2") {
              $rounddesc = "Achtste finale";
            }
            if ($round == "3") {
              $rounddesc = "Kwartfinale";
            }
            if ($round == "4") {
              $rounddesc = "Halve finale";
            }
            if ($round == "5") {
              $rounddesc = "Finale";
            } ?>
            <h2><?= $rounddesc; ?></h2>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">date</th>
                  <th scope="col">time</th>
                  <th scope="col">home</th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                  <th scope="col">away</th>
                </tr>
              </thead>
              <tbody>
              <?php endif; ?>
            
              <tr>
                <td><?= $id ?></td>
                <td><?= date_format(date_create($data["date"]), 'd/m/Y'); ?></td>
                <td><?= $data["time"]; ?></td>
                <td><img src=".\\vlaggen\\<?=$data["home"]; ?>.png"><?= $data["home"]; ?></td>
                <td><input type="number" width="20px" class="form-control" name="<?= $data["home_score"]; ?>"  value="<?= $data["home_score"]; ?>"  ?></td>
                <td> - </td>
                <td><input type="number" width="20px" class="form-control" name="<?= $data["away_score"]; ?>"  value="<?= $data["away_score"]; ?>"  ?></td>
                <td><?= $data["away"] ?><img src=".\\vlaggen\\<?=$data["away"]; ?>.png"></td>
              </tr>

            <?php endforeach; ?>

              </tbody>
            </table>
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