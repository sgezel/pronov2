<?php
require_once("header.php");
include_once("UserCrud.php");
include_once("MatchCrud.php");
include_once("SettingCrud.php");

$userCrud = new UserCrud();
$matchCrud = new MatchCrud();
$settingsCrud = new SettingCrud();

$settings = $settingsCrud->actionGetAllSettings();

$allUserData = $userCrud->actionRead();
$allMatchData = $matchCrud->actionRead();
?>


<div class="blog_section layout_padding">
    <div class="container">
        <div class="row">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="matches-tab" data-bs-toggle="tab" data-bs-target="#matches-tab-pane" type="button" role="tab" aria-controls="matches-tab-pane" aria-selected="true">Matches</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users-tab-pane" type="button" role="tab" aria-controls="users-tab-pane" aria-selected="false">Users</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings-tab-pane" type="button" role="tab" aria-controls="settings-tab-pane" aria-selected="false">Instellingen</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane show active" id="matches-tab-pane" role="tabpanel" aria-labelledby="matches-tab" tabindex="0">
                    <div>
                        <h2>Matchen toevoegen</h2>

                        <form method="post" action="action_admin_addmatch.php">
                            <div class="form">
                                <label for="date">Datum:</label>
                                <input class="mail_text" type="date" name="date" />
                                <br />
                                <label for="time">Uur:</label>
                                <input class="mail_text" type="time" name="time" />
                                <br />
                                <label for="home">Thuisploeg:</label>
                                <input class="mail_text" type="text" name="home" />
                                <br />
                                <label for="away">Uitploeg:</label>
                                <input class="mail_text" type="text" name="away" />
                                <br />
                                <label for="round">Ronde:</label><br />
                                <select class="mail_text" name="round">
                                    <option selected>Kies...</option>
                                    <option value="1">Groepsfase</option>
                                    <option value="2">Achtste finales</option>
                                    <option value="3">Kwartfinales</option>
                                    <option value="4">Halve finales</option>
                                    <option value="5">Finale</option>
                                </select>
                                <br />
                                <label for="id">ID:</label>
                                <input class="mail_text" type="number" name="id" />
                                <br />
                                <br />
                                <input type="submit" class="btn btn-primary" value="Wedstrijd Opslaan" />
                            </div>
                        </form>
                    </div>
                    <div>
                            <?php $round = "";
                            $rounddesc = ""; ?>
                            <?php foreach ($allMatchData as $id => $data) :
                                if (strcmp($round, $data["round"]) != 0) :
                                    if($round != "") :?>
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
                                            <th scope="col">away</th>
                                            <th scope="col">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php endif; ?>
                                
                                        <tr>
                                            <td><?= $id ?></td>
                                            <td><?= $data["date"]; ?></td>
                                            <td><?= $data["time"]; ?></td>
                                            <td><?= $data["home"]; ?></td>
                                            <td><?= $data["away"] ?></td>
                                            <td><a href="editMatch.php?id=<?= $id; ?>" class="btn btn-primary">Edit</a></td>
                                        </tr>

                                    <?php endforeach; ?>

                                    </tbody>
                                </table>
                    </div>
                    <hr class="solid">

                </div>

                <div class="tab-pane " id="users-tab-pane" role="tabpanel" aria-labelledby="users-tab" tabindex="0">
                    <br />
                    <h2>Gebruikers aanpassen</h2>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">email</th>
                                <th scope="col">name</th>
                                <th scope="col">paid</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allUserData as $id => $data) : ?>

                                <tr>
                                    <td><?= $id ?></td>
                                    <td><?= $data["username"]; ?></td>
                                    <td><?= $data["name"]; ?></td>
                                    <td><?= $data["paid"] ?></td>
                                    <td><a href="edituser.php?id=<?= $id; ?>" class="btn btn-primary">Edit</a></td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>

                <div class="tab-pane " id="settings-tab-pane" role="tabpanel" aria-labelledby="settings-tab" tabindex="0">
                    <br />
                    <h2>Instellingen aanpassen</h2>

                    <form method="post" action="action_admin_settings.php">
                        <label for="registrations">Gebruikers mogen registreren:</label>
                        <input type="checkbox" name="registrations" <?= $settings["registrations"] ? "checked=checked" : "" ?> />
                        <br />
                        <br />
                        <h3>Zichtbaarheid wedstrijdrondes</h3>
                        <label for="round1">Groepsfase:</label>
                        <input type="checkbox" name="round1" <?= $settings["round1"] ? "checked=checked" : "" ?> />
                        <br />
                        <label for="round2">Achtste finales:</label>
                        <input type="checkbox" name="round2" <?= $settings["round2"] ? "checked=checked" : "" ?> />
                        <br />
                        <label for="round3">Kwartfinales:</label>
                        <input type="checkbox" name="round3" <?= $settings["round3"] ? "checked=checked" : "" ?> />
                        <br />
                        <label for="round4">Halve finales:</label>
                        <input type="checkbox" name="round4" <?= $settings["round4"] ? "checked=checked" : "" ?> />
                        <br />
                        <label for="round5">Finale:</label>
                        <input type="checkbox" name="round5" <?= $settings["round5"] ? "checked=checked" : "" ?> />
                        <br />
                        <input type="submit" class="btn btn-primary" value="Instellingen Opslaan" />
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

<?php
require_once("footer.php");
?>