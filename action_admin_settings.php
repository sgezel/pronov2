<?php
session_start();
include_once("SettingCrud.php");
include_once("config.php");

CheckAdminAccess();

$settingsCrud = new SettingCrud();

if(isset($_POST))
{
    $settingsCrud->actionSave();
}

