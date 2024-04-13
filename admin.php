<?php
require_once("header.php");
include_once("UserCrud.php");
include_once("MatchCrud.php");
include_once("QuestionCrud.php");
include_once("SettingCrud.php");
require_once("cron.php");

$functions =  get_defined_functions()["user"];

$starts_with = "cron_";
$cron_actions =  array_filter($functions, function ($var) use ($starts_with) {
    return (substr($var, 0, 5) == $starts_with);
});



CheckAdminAccess();

$userCrud = new UserCrud();
$matchCrud = new MatchCrud();
$questionCrud = new QuestionCrud();
$settingsCrud = new SettingCrud();

$settings = $settingsCrud->actionGetAllSettings();

$allUserData = $userCrud->actionRead();
$allMatchData = $matchCrud->actionRead();
$allQuestionData = $questionCrud->actionRead();
?>


<div class="blog_section layout_padding">
    <div class="container">
        <div class="row">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="matches-tab" data-bs-toggle="tab" data-bs-target="#matches-tab-pane" type="button" role="tab" aria-controls="matches-tab-pane" aria-selected="true">Matches</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="questions-tab" data-bs-toggle="tab" data-bs-target="#questions-tab-pane" type="button" role="tab" aria-controls="questions-tab-pane" aria-selected="false">Questions</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users-tab-pane" type="button" role="tab" aria-controls="users-tab-pane" aria-selected="false">Users</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings-tab-pane" type="button" role="tab" aria-controls="settings-tab-pane" aria-selected="false">Instellingen</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data-tab-pane" type="button" role="tab" aria-controls="data-tab-pane" aria-selected="false">Data</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cron-tab" data-bs-toggle="tab" data-bs-target="#cron-tab-pane" type="button" role="tab" aria-controls="cron-tab-pane" aria-selected="false">Cron</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane show active" id="matches-tab-pane" role="tabpanel" aria-labelledby="matches-tab" tabindex="0">
                    <div>
                        <br />
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
                    <hr class="solid">
                    <div>
                        <br />
                        <h2>Overzicht</h2>
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
                                <h3><?= $rounddesc; ?></h3>
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
                </div>

                <div class="tab-pane" id="questions-tab-pane" role="tabpanel" aria-labelledby="questions-tab" tabindex="1">
                    <div>

                        <br />
                        <h2>Vragen toevoegen</h2>
                        <form method="post" action="action_admin_addquestion.php">
                            <div class="form">
                                <label for="question">Vraag:</label>
                                <input class="mail_text" type="text" name="question" />
                                <br />
                                <br />
                                <input type="submit" class="btn btn-primary" value="Vraag opslaan" />
                            </div>
                        </form>
                    </div>

                    <hr class="solid">
                    <div>
                        <br />
                        <h2>Overzicht</h2>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">question</th>
                                    <th scope="col">Edit</th>
                                </tr>
                            </thead>
                            <?php foreach ($allQuestionData as $id => $data) : ?>
                                <tr>
                                    <td><?= $id ?></td>
                                    <td><?= $data["question"]; ?></td>
                                    <td><a href="editQuestion.php?id=<?= $id; ?>" class="btn btn-primary">Edit</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>

                <div class="tab-pane" id="users-tab-pane" role="tabpanel" aria-labelledby="users-tab" tabindex="2">
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

                <div class="tab-pane" id="settings-tab-pane" role="tabpanel" aria-labelledby="settings-tab" tabindex="3">
                    <br />
                    <h2>Instellingen aanpassen</h2>

                    <form method="post" action="action_admin_settings.php">
                        <label for="baseurl">Baseurl:</label>
                        <input type="text" class="form-control" name="baseurl" value="<?= $settings["baseurl"] ?>" />
                        <br/>
                        <br/>
                        <label for="apikey">API Key:</label>
                        <input type="text" class="form-control" name="apikey" value="<?= $settings["apikey"] ?>" />
                        <br/>
                        <br/>

                        <label for="registrations">Gebruikers mogen registreren:</label>
                        <input type="checkbox" name="registrations" <?= $settings["registrations"] ? "checked=checked" : "" ?> />
                        <br />
                        <br />
                        <label for="questionvalue">Waarde van 1 vraag:</label>
                        <input type="number" width="20px" class="form-control input-score" name="questionvalue" value="<?= $settings["questionvalue"] ?>" />
                        <br />
                        <br />  
                        <label for="questionslocked">Vragen afsluiten?</label>
                        <input type="checkbox" name="questionslocked" <?= $settings["questionslocked"] ? "checked=checked" : "" ?> />
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
                <div class="tab-pane" id="data-tab-pane" role="tabpanel" aria-labelledby="data-tab" tabindex="3">
                <br />
                    <h2>Data file aanpassen</h2>

                    <form method="post" action="action_admin_data.php">
                        <textarea class="form-control textas vh-60" name="datafile">
                            <?= json_encode($userCrud->data, JSON_PRETTY_PRINT); ?>
                        </textarea>
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Data Opslaan" />
                    </form>

                </div>

                <div class="tab-pane" id="cron-tab-pane" role="tabpanel" aria-labelledby="cron-tab" tabindex="3">
                <br />
                    <h2>Cron functies aanroepen</h2>

                    <div class="list-group">
                 
                        <?php foreach ($cron_actions as $action) : ?>
                            <a href="cron.php?func=<?= str_replace("cron_", "", $action); ?>" class="list-group-item list-group-item-action" target="_blank"><?= str_replace("cron_", "",$action); ?></a>
                        <?php endforeach; ?>
                    
                    </div>

                    
                </div>
            </div>

        </div>
    </div>
</div>


<?php
require_once("footer.php");
?>

<script>
    const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
    });

    let tabvalue = params.tab.toLowerCase();

    console.log(tabvalue);

    if (tabvalue !== undefined) {
        document.getElementById(tabvalue + "-tab").click();

    }
</script>