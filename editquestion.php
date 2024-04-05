<?php
require_once("header.php");
include_once("QuestionCrud.php");

CheckAdminAccess();

$questionCrud = new QuestionCrud();
$id  = $_GET["id"];

$questionData = $questionCrud->actionQuestionDataById($id);

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
                            <input type="text" class="mail_text" placeholder="Email" name="question" value="<?= $questionData["question"]; ?>"  />
                        </div>

                    </div>
                    <div class="mail_section_1">
                       
                        <input type="submit" class="btn btn-primary" value="Opslaan" />
                    </div>

                </div>
            </div>

        </div>
    </div>
    </div>
</form>

<?php
require_once("footer.php");
?>