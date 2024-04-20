<?php
require_once("header.php");
require_once("ScoreboardCrud.php");

CheckAccess();

$crud = new ScoreboardCrud();

$data = $crud->data;

$place_counter = 0;
?>

<div class="blog_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="blog_taital">Scorebord</h1>
                <br/><br/><br/>
                <div class="alert alert-dark" role="alert">
                       <strong> <a href="badges.php">Lees hier meer over al de badges die je kan verzamelen!</a> </strong>
                </div>
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
                            ++$place_counter;
                            ?>

                            <tr>
                                <td>
                                    <?php if ($place_counter < 4) : ?>
                                        <img src="images/scoreboard/<?= $place_counter; ?>.png" style="width:40px;" />
                                    <?php else : ?>
                                        <?= $place_counter; ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= $score["name"]; ?></td>
                                <td class="text-center"><?= $score["score"]; ?></td>
                                <td class="text-center"><?= $score["correct"]; ?></td>
                                <td class="text-center"><?= $score["questions"];  ?></td>
                                <td class="scoreboardbadges" >
                                    <div class="badges">
                                    <?php foreach($data["users"][$score["uid"]]["badges"] as $title => $badge): ?>
                                        
                                        <div class="hover-badge">
                                            <img src="badges/<?= $badge; ?>.png"  width="32" />
                                            <span class="description"><?=$title;?></span>
                                        </div>
                                    <?php endforeach; ?>
                                    </div>
                                </td>
                                    </tr> 
                                    <tr class="scoreboardbadgesresp">
                                        <td>
                                            &nbsp;
                                        </td>
                                        <td colspan="4">
                                        <div class="badges">
                                    <?php foreach($data["users"][$score["uid"]]["badges"] as $title => $badge): ?>
                                        
                                        <div class="hover-badge">
                                            <img src="badges/<?= $badge; ?>.png"  width="32" />
                                            <span class="description"><?=$title;?></span>
                                        </div>
                                    <?php endforeach; ?>
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