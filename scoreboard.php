<?php
require_once ("header.php");
require_once ("ScoreboardCrud.php");

$crud = new ScoreboardCrud();

$data = $crud->data;

$place_counter = 0;
?>

<div class="blog_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="blog_taital">Scorebord</h1>

                <table class="table table-hover">
                    <thead>
                        <tr>

                            <th>#</th>
                            <th>Naam</th>
                            <th>Score</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($data["scoreboard"] as $score): ?>
                            <?php
                            ++$place_counter;
                            ?>

                            <tr>
                                <td>
                                    <?php if($place_counter < 4): ?>
                                        <img src="images/scoreboard/<?= $place_counter; ?>.png" style="width:40px;" />
                                    <?php else: ?>
                                        <?= $place_counter; ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= $score["name"]; ?></td>
                                <td><?= $score["score"]; ?></td>

                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
require_once ("footer.php");
?>