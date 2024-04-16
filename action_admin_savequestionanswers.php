<?php
include_once("config.php");
include_once("UserCrud.php");

CheckAdminAccess();

$userCrud = new UserCrud();

?>

<pre>
    <?php
    if(isset($_POST))
        $userCrud->actionSaveQuestions();
    ?>
</pre>