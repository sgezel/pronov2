<?php
require_once("header.php");
require_once("UserCrud.php");
require_once("MatchCrud.php");

CheckAccess();

$matchCrud = new MatchCrud();
$matches = array_reverse($matchCrud->actionRead(true), true);

$userCrud = new UserCrud();
$users = $userCrud->actionRead();

$onlyvisible = isset($_SESSION["visible"]) ? $_SESSION["visible"] : true;

uasort($users, function ($a, $b) {
    // First compare by round
    $roundComparison = strcmp($a['name'], $b['name']);
    if ($roundComparison !== 0) {
        return $roundComparison;
    }
});


$matchdata = [];

$previousdate = null;
foreach ($matches as $id => $match) {
    if ($match["locked"])
        $matchdata[$match["date"]][$id] = $match["home"] . "-" . $match["away"];
}
?>


<div class="blog_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="blog_taital">Voorspellingen</h1>
            </div>

            <?php if ($_SESSION["admin"]) : ?>
                <div class="clearfix">
                    <?php if (!$_SESSION["visible"]) : ?>
                        <small><a href="action_toggle_visible.php?p=overzicht" class="btn btn-sm btn-outline-danger pull-right" role="button">Onzichtbare spelers zichtbaar</a></small>
                    <?php else : ?>
                        <small><a href="action_toggle_visible.php?p=overzicht" class="btn btn-sm btn-outline-warning pull-right" role="button">Onzichtbare spelers verborgen</a></small>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="d-flex align-items-start">
                <div class="nav flex-column nav-pills sm-2 me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                    <?php
                    $first = true;
                    $display = false;
                    ?>

                    <?php foreach ($matchdata as $date => $matchesdata) : ?>
                        <?php $display = true; ?>
                        <button class="nav-link <?= $first ? "active" :  "" ?>" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?= $date; ?>" type="button" role="tab" aria-controls="v-pills-<?= $date; ?>" aria-selected="true"><?= date("d/m ", strtotime($date)); ?></button>

                        <?php $first = false; ?>
                    <?php endforeach; ?>

                </div>
                <div class="tab-content w-100" id="v-pills-tabContent">

                    <?php $first = true; ?>

                    <?php if (!$display) : ?>
                        <p>De voorspellingen zullen zichtbaar zijn op het moment dat de pronostiek van de eerste match wordt afgesloten.</p>
                    <?php else : ?>


                        <?php foreach ($matchdata as $date => $matchesdata) : ?>

                            <div class="tab-pane fade show <?= $first ? "active" :  "" ?>" id="v-pills-<?= $date; ?>" role="tabpanel" aria-labelledby="v-pills-<?= $date; ?>-tab">

                                <?php foreach ($matchesdata as $matchid => $matchoverview) : ?>

                                    <?php
                                    $currentmatch = $matches[$matchid];
                                    ?>

                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="4" class="text-center">
                                                    <img src="vlaggen/<?= $currentmatch["home"]; ?>.png" />
                                                    <?= $currentmatch["home"] ?> - <?= $currentmatch["away"]; ?>
                                                    <img src="vlaggen/<?= $currentmatch["away"]; ?>.png" />

                                                    <?php
                                                    if (
                                                        $currentmatch["time"] < date("H:i") &&
                                                        ($currentmatch["finished"] === false || $currentmatch["finished"] === "false")
                                                    ) { ?>
                                                        <span class="badge bg-warning text-dark">Live</span>
                                                    <?php } ?>

                                                    <br />
                                                    <span class="score"><?= $currentmatch["home_score"]; ?></span> - <span class="score"><?= $currentmatch["away_score"]; ?></span>

                                                </th>
                                            </tr>

                                            <tr>
                                                <th>Naam</th>
                                                <th class="text-center">Prono</th>
                                                <th class="text-center">ptn</th>
                                                <th class="text-center">QP</th>
                                        </thead>

                                        <tbody>

                                            <?php foreach ($users as $userid => $user) : ?>
                                                <?php
                                                if ($onlyvisible && !(($user["visible"] === true) || ($user["visible"] == "on"))) {
                                                    continue;
                                                }
                                                ?>
                                                <?php $usermatch = $user["matches"][$matchid]; ?>
                                                <tr class="<?= (isset($usermatch["points"]) && $usermatch["points"] == 4) ? "table-success" : ""; ?>">
                                                    <td><?= $user["name"]; ?></td>
                                                    <td class="text-center">
                                                        <?php if ((isset($usermatch["home"]) && trim($usermatch["home"]) !== "" && isset($usermatch["away"]))) : ?>
                                                            <?= isset($usermatch["home"]) ? $usermatch["home"] : ""; ?> - <?= isset($usermatch["away"]) ? $usermatch["away"] : ""; ?>
                                                        <?php else : ?>
                                                            Niet ingevuld
                                                        <?php endif; ?>
                                                    </td>
                                                    
                                                    <td class="text-center"><?= isset($usermatch["points"]) ? $usermatch["points"] : "0"; ?></td>
                                                    <td class="text-center"><img src="images/<?php echo isset($usermatch['quickpicked']) && $usermatch['quickpicked'] ? 'qp' : 'noqp'; ?>.png" width="32px"></td>
                                                </tr>

                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>

                                    <?php $first = false; ?>
                                <?php endforeach; ?>


                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once("footer.php");
?>