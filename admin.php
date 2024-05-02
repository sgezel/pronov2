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


$backup_files = [];
$backup_files["current"] = ["data.json"];


$dir = new DirectoryIterator("backup");

foreach ($dir as $fileinfo) {
    if ($fileinfo->isDir() && !$fileinfo->isDot()) {
        $backup_files[$fileinfo->getFilename()] = [];

        $files = new DirectoryIterator("backup/" . $dir);
        foreach ($files as $file) {
            if ($file->isFile() && !$file->isDot()) {
                $backup_files[$fileinfo->getFilename()][] = $file->getFilename();
            }
        }
    }
}

CheckAdminAccess();

$userCrud = new UserCrud();
$matchCrud = new MatchCrud();
$questionCrud = new QuestionCrud();
$settingsCrud = new SettingCrud();

$settings = $settingsCrud->actionGetAllSettings();

$allUserData = $userCrud->actionRead();
$allMatchData = $matchCrud->actionRead();
$allQuestionData = $questionCrud->actionRead();

$allUserMailString = "";
?>


<div class="blog_section layout_padding">
    <div class="container">
        <div class="row">

            <ul class="nav nav-tabs" id="myTab" role="tablist">

                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="matches-tab" data-bs-toggle="tab" data-bs-target="#matches-tab-pane" type="button" role="tab" aria-controls="matches-tab-pane" aria-selected="true">Matches</button>
                </li>
                <?php if (isset($_SESSION["superadmin"]) && $_SESSION["superadmin"] == true) : ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="questions-tab" data-bs-toggle="tab" data-bs-target="#questions-tab-pane" type="button" role="tab" aria-controls="questions-tab-pane" aria-selected="false">Questions</button>
                    </li>
                <?php endif; ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users-tab-pane" type="button" role="tab" aria-controls="users-tab-pane" aria-selected="false">Users</button>
                </li>

                <?php if (isset($_SESSION["superadmin"]) && $_SESSION["superadmin"] == true) : ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings-tab-pane" type="button" role="tab" aria-controls="settings-tab-pane" aria-selected="false">Instellingen</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data-tab-pane" type="button" role="tab" aria-controls="data-tab-pane" aria-selected="false">Data</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="cron-tab" data-bs-toggle="tab" data-bs-target="#cron-tab-pane" type="button" role="tab" aria-controls="cron-tab-pane" aria-selected="false">Cron</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="notification-tab" data-bs-toggle="tab" data-bs-target="#notification-tab-pane" type="button" role="tab" aria-controls="notification-tab-pane" aria-selected="false">Notifications</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="quickpickfix-tab" data-bs-toggle="tab" data-bs-target="#quickpickfix-tab-pane" type="button" role="tab" aria-controls="quickpickfix-tab-pane" aria-selected="false">QuickPickFix&reg;</button>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane show active" id="matches-tab-pane" role="tabpanel" aria-labelledby="matches-tab" tabindex="0">
                    <?php include_once("admin_matches.php"); ?>
                </div>

                <div class="tab-pane" id="questions-tab-pane" role="tabpanel" aria-labelledby="questions-tab" tabindex="1">
                    <?php include_once("admin_questions.php"); ?>
                </div>

                <div class="tab-pane" id="users-tab-pane" role="tabpanel" aria-labelledby="users-tab" tabindex="2">
                    <?php include_once("admin_users.php"); ?>
                </div>

                <div class="tab-pane" id="settings-tab-pane" role="tabpanel" aria-labelledby="settings-tab" tabindex="3">
                    <?php include_once("admin_settings.php"); ?>
                </div>

                <div class="tab-pane" id="data-tab-pane" role="tabpanel" aria-labelledby="data-tab" tabindex="3">
                    <?php include_once("admin_data.php"); ?>
                </div>

                <div class="tab-pane" id="cron-tab-pane" role="tabpanel" aria-labelledby="cron-tab" tabindex="3">
                    <?php include_once("admin_cron.php"); ?>
                </div>

                <div class="tab-pane" id="notification-tab-pane" role="tabpanel" aria-labelledby="notification-tab" tabindex="3">
                    <?php include_once("admin_notification.php"); ?>
                </div>

                <div class="tab-pane" id="quickpickfix-tab-pane" role="tabpanel" aria-labelledby="quickpickfix-tab" tabindex="3">
                    <?php include_once("admin_quickpickfix.php"); ?>
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