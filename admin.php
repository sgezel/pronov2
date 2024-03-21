<?php
require_once("header.php");
include_once("UserCrud.php");
include_once("SettingCrud.php");

$userCrud = new UserCrud();
$settingsCrud = new SettingCrud();

$settings = $settingsCrud->actionGetAllSettings();
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
                    <br />
                    <h2>Matchen toevoegen/aanpassen</h2>
                </div>

                <div class="tab-pane " id="users-tab-pane" role="tabpanel" aria-labelledby="users-tab" tabindex="0">
                    <br />
                    <h2>Gebruikers aanpassen</h2>
                </div>

                <div class="tab-pane " id="settings-tab-pane" role="tabpanel" aria-labelledby="settings-tab" tabindex="0">
                    <br />
                    <h2>Instellingen aanpassen</h2>

                    <form method="post" action="action_admin_settings.php">
                        <label for="registrations">Gebruikers mogen registreren:</label>
                        <input type="checkbox" name="registrations" <?= $settings["registrations"] ? "checked=checked" : "" ?> />

                        <br/>
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