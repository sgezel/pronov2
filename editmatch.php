<?php
require_once("header.php");
include_once("MatchCrud.php");
CheckAdminAccess();

$matchCrud = new MatchCrud();
$id  = $_GET["id"];

$matchData = $matchCrud->actionMatchDataById($id);

if ($matchData == null) {
    $_SESSION["error_message"] = "Deze match bestaat niet 😟";
    header("location: admin.php");
}
?>

<form method="post" action="action_admin_editmatch.php" autocomplete="off">
    <div class="contact_section layout_padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mail_section_1">
                        <h1 class="contact_taital">Wedstrijd "<?= $matchData["home"]; ?> - <?= $matchData["away"]; ?>" aanpassen. </h1>
                        <div>
                            <h2>Matchen aanpassen</h2>
                            <div class="form">
                                <label for="date">Datum:</label>
                                <input class="mail_text" type="date" name="date" value="<?= $matchData["date"] ?>" />
                                <br />
                                <label for="time">Uur:</label>
                                <input class="mail_text" type="time" name="time" value="<?= $matchData["time"] ?>" />
                                <br />
                                <table class="table table-hover w-100">
                                    <thead>
                                        <tr>
                                            <td>Thuisploeg</td>
                                            <td></td>
                                            <td></td>
                                            <td>Uitploeg</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" class="form-control" name="home" value="<?= $matchData["home"] ?>" /></td>
                                            <td><input type="text" class="form-control input-score" name="home_score" value="<?= $matchData["home_score"] ?>" /></td>
                                            <td><input type="text" class="form-control input-score" name="away_score" value="<?= $matchData["away_score"] ?>" /></td>
                                            <td><input type="text" class="form-control" name="away" value="<?= $matchData["away"] ?>" /></td>
                                        </tr>

                                    </tbody>
                                </table>

                                <br />
                                <label for="round">Ronde: <?= $matchData["round"]  === "1" ? "selected" : "" ?> </label><br />
                                <select class="mail_text" name="round" value="<?= $round ?>">
                                    <option>Kies...</option>
                                    <option value="1" <?= $matchData["round"]  === "1" ? "selected" : "" ?>>Groepsfase</option>
                                    <option value="2" <?= $matchData["round"]  === "2" ? "selected" : "" ?>>Achtste finales</option>
                                    <option value="3" <?= $matchData["round"]  === "3" ? "selected" : "" ?>>Kwartfinales</option>
                                    <option value="4" <?= $matchData["round"]  === "4" ? "selected" : "" ?>>Halve finales</option>
                                    <option value="5" <?= $matchData["round"]  === "5" ? "selected" : "" ?>>Finale</option>
                                </select>
                                <br />

                                <label for="id">Uur:</label>
                                <input class="mail_text" type="id" name="id" value="<?= $id ?>" />
                                <br />

                                <br />
                                <input type="submit" class="btn btn-primary" value="Wedstrijd Opslaan" />
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
</form>

<?php
require_once("footer.php");
?>