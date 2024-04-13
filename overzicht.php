<?php
require_once ("header.php");
require_once ("UserCrud.php");
require_once ("MatchCrud.php");

CheckAccess();

$matchCrud = new MatchCrud();
$matches = array_reverse($matchCrud->actionRead(true), true);

$userCrud = new UserCrud();
$users = $userCrud->actionRead();

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
   if($match["locked"])
        $matchdata[$match["date"]][$id] = $match["home"] . "-" . $match["away"];
}
?>


<div class="blog_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="blog_taital">Match overzicht</h1>
            </div>

            <div class="d-flex align-items-start">
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                    <?php $first = true; ?>
                    <?php foreach ($matchdata as $date => $matchesdata): ?>
                        <button class="nav-link <?= $first ? "active":  "" ?>" id="v-pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-<?= $date; ?>" type="button" role="tab"
                            aria-controls="v-pills-<?= $date; ?>"
                            aria-selected="true"><?= date("d/m/Y", strtotime($date)); ?></button>

                            <?php $first = false; ?>
                    <?php endforeach; ?>

                </div>
                <div class="tab-content w-100" id="v-pills-tabContent">

                <?php $first = true; ?>

                    <?php foreach ($matchdata as $date => $matchesdata): ?>

                        <div class="tab-pane fade show <?= $first ? "active":  "" ?>" id="v-pills-<?= $date; ?>" role="tabpanel"
                            aria-labelledby="v-pills-<?= $date; ?>-tab">

                            <?php foreach ($matchesdata as $matchid => $matchoverview): ?>

                                <?php
                                $currentmatch = $matches[$matchid];
                                ?>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="text-center"> 
                                                
                                                <span class="score"><?= $currentmatch["home_score"]; ?></span>  
                                                <img src="vlaggen/<?=  $currentmatch["home"]; ?>.png" />
                                                <?= $currentmatch["home"]; ?> -  <?= $currentmatch["away"]; ?> 
                                                <img src="vlaggen/<?=  $currentmatch["away"]; ?>.png" />
                                                    <span class="score"><?= $currentmatch["away_score"]; ?></span>
                                        
                                            </th>
                                        </tr>

                                        <tr>
                                            <th>Naam</th>
                                            <th>Thuis</th>
                                            <th>Uit</th>
                                            <th>Punten</th>
                                    </thead>

                                    <tbody>

                                        <?php foreach ($users as $userid => $user): ?>

                                            <?php $usermatch = $user["matches"][$matchid]; ?>
                                            <tr class="<?= (isset($usermatch["points"]) && $usermatch["points"] == 4) ? "table-success" : ""; ?>">
                                                <td><?= $user["name"]; ?></td>
                                                <td><?= isset($usermatch["home"]) ? $usermatch["home"] : ""; ?></td>
                                                <td><?= isset($usermatch["away"]) ? $usermatch["away"] : ""; ?></td>
                                                <td><?= isset($usermatch["points"]) ? $usermatch["points"] : ""; ?></td>
                                            </tr>

                                        <?php endforeach; ?>

                                    </tbody>
                                </table>

                                <?php $first = false; ?>         
                            <?php endforeach; ?>


                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once ("footer.php");
?>