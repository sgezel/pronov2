<?php
session_start();
include_once("SettingCrud.php");
$settingsCrud = new SettingCrud();

if(isset($_POST))
{
    $settingsCrud->actionSave();
}

