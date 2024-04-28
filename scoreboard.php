<?php
require_once("header.php");
require_once("ScoreboardCrud.php");
require_once("UserCrud.php");
CheckAccess();

$crud = new ScoreboardCrud();
$usercrud = new UserCrud();

$data = $crud->data;

$place_counter = 0;

$onlyvisible = isset($_SESSION["visible"]) ? $_SESSION["visible"] : true;
$visiblegroup = !isset($_SESSION["visiblegroup"]) && isset($_SESSION["group"]) ? $_SESSION["group"] : null;
$livematches = $crud->IsAnyMatchLive();


?>

<div class="blog_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 ">
                <h1 class="blog_taital">Scorebord</h1>
                <br /><br /><br />

                <?php if ($_SESSION["admin"]) : ?>
                    <div class="clearfix">
                        <?php if (!$_SESSION["visible"]) : ?>
                            <small><a href="action_toggle_visible.php" class="btn btn-sm btn-outline-danger pull-right" role="button">Onzichtbare spelers zichtbaar</a></small>
                        <?php else : ?>
                            <small><a href="action_toggle_visible.php" class="btn btn-sm btn-outline-warning pull-right" role="button">Onzichtbare spelers verborgen</a></small>
                        <?php endif; ?>
                    </div>
                    <div class="clearfix">
                    <?php if (isset($_SESSION["group"])) : ?>
                        <?php if (!isset($_SESSION["visiblegroup"])) : ?>
                            <small><a href="action_toggle_group.php" class="btn btn-sm btn-outline-danger pull-right" role="button"><?= $_SESSION["group"] ?></a></small>
                        <?php else : ?>
                            <small><a href="action_toggle_group.php" class="btn btn-sm btn-outline-warning pull-right" role="button">All</a></small>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <div class="alert alert-dark clearfix" role="alert">
                    <strong> <a href="badges.php">Lees hier meer over al de badges die je kan verzamelen!</a> </strong>
                </div>

                <?php if ($livematches) : ?>
                    <div class="alert alert-info clearfix" role="alert">
                        Er is momenteel nog een match bezig. Het scorebord is dus een voorlopige tussenstand.
                    </div>
                <?php endif; ?>
                <table class="table table-hover">
                    <thead>
                        <tr>

                            <th>&nbsp;</th>
                            <th>Naam</th>
                            <th class="text-center">Score</th>
                            <th class="text-center"># juist</th>
                            <th class="text-center"># vragen</th>
                            <th class="scoreboardbadges">badges</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($data["scoreboard"] as $score) : ?>
                            <?php

                            $userdata = $usercrud->actionUserDataById($score["uid"]);
                            if (isset($visiblegroup) && (!isset($userdata["group"]) || $userdata["group"] != $visiblegroup)) {
                                continue;
                            }

                            if ($onlyvisible && !$score["visible"]) {
                                continue;
                            }

                            ++$place_counter;
                            ?>

                            <tr>
                                <td style="text-align: center;">
                                    <?php if ($place_counter < 4) : ?>
                                        <img src="images/scoreboard/<?= $place_counter; ?>.png" style="width:32px;" />
                                    <?php else : ?>
                                        <?= $place_counter; ?>
                                    <?php endif; ?>
                                </td>
                                <td> <img src="images/<?= $score["position"] ?>.png" width="13" /> <?= $score["name"]; ?></td>
                                <td class="text-center"><?= $score["score"]; ?></td>
                                <td class="text-center"><?= $score["correct"]; ?></td>
                                <td class="text-center"><?= $score["questions"]; ?></td>
                                <td class="scoreboardbadges">
                                    <div class="badges">
                                        <?php if (isset($data["users"][$score["uid"]]["badges"]["Wanbetaler"])) : ?>
                                            <div class="hover-badge">
                                                <img src="badges/<?= $data["users"][$score["uid"]]["badges"]["Wanbetaler"]["icon"]; ?>.png" width="32" />
                                                <span class="description">Wanbetaler</span>
                                            </div>
                                        <?php else : ?>
                                            <?php if (isset($data["users"][$score["uid"]]["badges"]) && is_array($data["users"][$score["uid"]]["badges"])) : ?>
                                                <?php foreach ($data["users"][$score["uid"]]["badges"] as $title => $badge) : ?>
                                                    <div class="hover-badge">
                                                        <img src="badges/<?= $badge["icon"]; ?>.png" width="32" />
                                                        <span class="description"><?= $badge["title"]; ?></span>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="scoreboardbadgesresp">
                                <td>
                                    &nbsp;
                                </td>
                                <td colspan="4">
                                    <div class="badges">
                                        <?php if (isset($data["users"][$score["uid"]]["badges"]["Wanbetaler"])) : ?>
                                            <div class="hover-badge">
                                                <img src="badges/<?= $data["users"][$score["uid"]]["badges"]["Wanbetaler"]; ?>.png" width="32" />
                                                <span class="description">Wanbetaler</span>
                                            </div>
                                        <?php else : ?>
                                            <?php foreach ($data["users"][$score["uid"]]["badges"] as $title => $badge) : ?>
                                                <div class="hover-badge">
                                                    <img src="badges/<?= $badge["icon"]; ?>.png" width="32" />
                                                    <span class="description"><?= $badge["title"]; ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
require_once("footer.php");
?>