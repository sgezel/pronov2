<?php
require_once("header.php");
include_once("QuestionCrud.php");
include_once("UserCrud.php");

CheckAdminAccess();

$questionCrud = new QuestionCrud();
$userCrud = new UserCrud();
$id  = $_GET["id"];

$questionData = $questionCrud->actionQuestionDataById($id);
$allUserData = $userCrud->actionRead();

if ($questionData == null) {
    $_SESSION["error_message"] = "Deze gebruiker bestaat niet 😟";
    header("location: admin.php");
}
?>

<form method="post" action="action_admin_editquestion.php" autocomplete="off">
    <div class="contact_section layout_padding">



        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mail_section_1">
                        <h1 class="contact_taital">Vraag "<?= $id; ?>" aanpassen. </h1>
                        <div class="form">
                            <div><input type="hidden" name="id" value="<?= $id; ?>" />
                                <label class="form-check-label" for="question">Vraag:</label>
                                <input type="text" class="mail_text" placeholder="Email" name="question" value="<?= $questionData["question"]; ?>" />
                            </div>
                        </div>
                        <br />


                    </div>
                    <div class="mail_section_1">
                    <br/>
                    </div>
                    <div class="mail_section_1">
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="solved" type="checkbox" id="flexSwitchSolved" <?= isset($questionData["solved"]) && $questionData["solved"]!= "" ? "checked=checked" : "" ?>>
                            <label class="form-check-label" for="flexSwitchSolved">Opgelost?</label>
                        </div>
                    </div>
                    <div class="mail_section_1">
                    <br/>
                    </div>
                    <div class="mail_section_1">
                        <input type="submit" class="btn btn-primary" value="Opslaan" />
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
<br /><br /><br />
<div class="mail_section_1">
    <h2>Antwoorden van Spelers</h2>

    <form method="post" action="action_admin_savequestionanswers.php">

        <input type="hidden" name="qid" value="<?= $id ?>" />

        <table class="table table-hover">
            <thead>
                <tr>
                    <td hidden>id</td>
                    <td>User</td>
                    <td>Answer</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allUserData as $uid => $userdata) : ?>
                    <tr>
                        <td hidden><?= $uid ?></td>
                        <td><?= $userdata["name"] ?></td>
                        <td><?= isset($userdata["questions"][$id]["answer"]) ? $userdata["questions"][$id]["answer"] : ""; ?></td>
                        <td><input type="checkbox" name="question[<?= $uid; ?>]" value="<?= $uid; ?>" <?= isset($userdata["questions"][$id]["correct"]) && $userdata["questions"][$id]["correct"] == true ?  "checked=checked" : "" ?>" /></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="mail_section_1">
            <input type="submit" class="btn btn-primary" value="Opslaan" />
        </div>

    </form>
</div>



<?php
require_once("footer.php");
?>