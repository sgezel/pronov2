<?php
require_once("header.php");
include_once("UserCrud.php");

CheckAdminAccess();

$userCrud = new UserCrud();
$id  = $_GET["id"];

$userData = $userCrud->actionUserDataById($id);

if ($userData == null) {
    $_SESSION["error_message"] = "Deze gebruiker bestaat niet 😟";
    header("location: admin.php");
}
?>

<form method="post" action="action_admin_edituser.php" autocomplete="off">
    <div class="contact_section layout_padding">


        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mail_section_1">
                        <h1 class="contact_taital">Gebruiker "<?= $userData["name"]; ?>" aanpassen. </h1>
                        <div class="form">
                            <input type="hidden" name="id" value="<?= $id; ?>" />
                            <input type="text" class="mail_text" placeholder="Email" name="username" value="<?= $userData["username"]; ?>" autofill="false" />
                            <input type="text" class="mail_text" placeholder="Naam" name="name" value="<?= $userData["name"]; ?>" />
                            <input type="password" class="mail_text" placeholder="Wachtwoord" name="password" />
                        </div>

                    </div>
                    <div class="mail_section_1">
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="admin" type="checkbox" id="flexSwitchAdmin" <?= $userData["admin"] ? "checked=checked" : "" ?>>
                            <label class="form-check-label" for="flexSwitchAdmin">Admin</label>
                        </div>

                        <?php if(isset($_SESSION["superadmin"]) && $_SESSION["superadmin"] == true) :?>
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="superadmin" type="checkbox" id="flexSwitchSuperAdmin" <?= $userData["superadmin"] ? "checked=checked" : "" ?>>
                            <label class="form-check-label" for="flexSwitchSuperAdmin">Superadmin</label>
                        </div>
                        <?php endif; ?>

                        <div class="form-check form-switch">
                            <input class="form-check-input" name="visible" type="checkbox" id="flexSwitchVisible" <?= $userData["visible"] ? "checked=checked" : "" ?>>
                            <label class="form-check-label" for="flexSwitchVisible">Visible</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" name="paid" type="checkbox" id="flexSwitchPaid" <?= $userData["paid"] ? "checked=checked" : "" ?>>
                            <label class="form-check-label" for="flexSwitchPaid">Paid</label>
                        </div>
                    
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="quickpicker" type="checkbox" id="flexSwitchQuickPick" <?= $userData["quickpicker"] ? "checked=checked" : "" ?>>
                            <label class="form-check-label" for="flexSwitchQuickPick">QuickPick&trade;</label>
                        </div>

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