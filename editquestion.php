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
                            <input type="hidden" name="id" value="<?= $id; ?>" />
                            <label class="form-check-label" for="question">Vraag:</label>
                            <input type="text" class="mail_text" placeholder="Email" name="question" value="<?= $questionData["question"]; ?>" />
                        </div>

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
                    <td hidden><?= $uid?></td>
                    <td><?= $userdata["name"] ?></td>
                    <td><?= isset($userdata["questions"][$id]["answer"]) ? $userdata["questions"][$id]["answer"] : ""; ?></td>
                    <td><input type="checkbox" name="user[<?= $uid; ?>][questions][<?= $id; ?>][correct]" value="<?= isset($userData["questions"][$id]["correct"]) ?  $userData["questions"][$id]["correct"] : "" ?>" /></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="mail_section_1">

                        <input type="submit" class="btn btn-primary" value="Opslaan" />
                    </div>

</div>



<?php
require_once("footer.php");
?>