<?php
require_once("config.php");
require_once("SettingCrud.php");
require_once("PHPMailer/PHPMailer.php");
require_once("PHPMailer/SMTP.php");
require_once("PHPMailer/Exception.php");
include_once("MatchCrud.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class UserCrud
{
    private $homePath;
    private $regPath;
    private $loginPath;
    private $adminPath;
    public $filePath;
    private $fileContent;
    public $data;
    public $listName;
    public $attributesList;

    public function __construct($filePath = 'data.json')
    {
        $filePath = $_SESSION["datafile"];
        $this->regPath = $_SESSION["install_path"] . "/register.php";
        $this->homePath = $_SESSION["install_path"] . "/main.php";
        $this->loginPath = $_SESSION["install_path"] . "/login.php";
        $this->adminPath = $_SESSION["install_path"] . "/admin.php";

        if (file_exists($filePath)) {
            $this->filePath = $filePath;
            $this->fileContent = file_get_contents($filePath);
            $this->data = json_decode($this->fileContent, true);
            $this->listName = "users";
            $this->attributesList = ["username", "name", "password", "admin", "visible", "paid","lastloggedin","totallogins","group","quickpicker","devicekey", "questions", "matches", "badges"];
        } else {
            throw new Exception("No file found", 1);
        }
    }

    public function actionAdd()
    {
        if($_POST["password"] !== $_POST["password2"])
        {
            $_SESSION["error_message"] = "Wachtwoorden komen niet overeen.";
            header("Location: " . $this->regPath);
            die();
        }

        $listName = $this->listName;
        $data = $this->data;

        $userdata = [];

        $userdata["username"] = $_POST["username"];
        $userdata["name"] = $_POST["name"];
        $userdata["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $userdata["admin"] = false;
        $userdata["visible"] = true;
        $userdata["paid"] = false;
        $userdata["lastloggedin"] = "";
        $userdata["totallogins"] = 0;
        $userdata["group"] = isset($_SESSION["registergroup"]) ? $_SESSION["registergroup"] : "PremedRegister";
        $userdata["quickpicker"] = false;
        $userdata["devicekey"] = "";
        $userdata["questions"] = [];
        $userdata["matches"] = [];


        if($this->actionUserData($userdata["username"]) == null)
        {
            array_push($data[$listName], $userdata);
            file_put_contents($this->filePath, json_encode($data));
            $_SESSION["success_message"] = "U bent geregistreerd en kan nu inloggen.";
        }
        else
        {
            $_SESSION["error_message"] = "Deze gebruiker bestaat reeds.";
        }

        header("Location: " . $this->loginPath);
    }


    public function actionUserDataById($id = null)
    {
        $listName = $this->listName;
        $data = $this->data;

        $itemData = $data[$listName][$id];

        if ($itemData) {
            return $itemData;
        }

        return null;
    }

    public function actionUserData($username = null)
    {
        $listName = $this->listName;
        $data = $this->data;

        foreach ($data[$listName] as $id => $userdata) {
            if ($userdata["username"] == $username) {
                return $userdata;
            }
        }

        return null;
    }

    public function actionRead()
    {
        return $this->data[$this->listName];
    }

    public function actionEdit()
    {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $listName = $this->listName;
            $data = $this->data;
            $itemData = $data[$listName][$id];

            foreach ($this->attributesList as $value) {

                if($value == "password")
                {
                    if(!empty($_POST[$value]))
                        $post[$value] = password_hash($_POST[$value], PASSWORD_DEFAULT);
                    else
                        $post[$value] = $itemData[$value];
                }
                else if ($value == "matches")
                {
                    $post[$value] = isset($itemData["matches"]) ? $itemData["matches"] : [];
                }
                else if ($value == "questions")
                {
                    $post[$value] = isset($itemData["questions"]) ? $itemData["questions"] : [];
                }
                else if ($value == "badges")
                {
                    $post[$value] = isset($itemData["badges"]) ? $itemData["badges"] : [];
                }
                else
                {
                    $post[$value] = isset($_POST[$value]) ? $_POST[$value] : "";
                }

            }

            if ($itemData) {
                unset($data[$listName][$id]);
                $data[$listName][$id] = $post;
                file_put_contents($this->filePath, json_encode($data));
            }
            header("Location: " . $this->adminPath . "?tab=users");
        }
    }

    public function actionLogin()
    {
        if (isset($_POST["username"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $listName = $this->listName;
            $data = $this->data;

            foreach ($data[$listName] as $id => $userdata) {
                if (strtolower($userdata["username"]) == strtolower($username)) {

                    if(password_verify($password, $userdata["password"])){
                        $_SESSION["loggedin"] = true;
                        $_SESSION["admin"] = $userdata["admin"];
                        $_SESSION["superadmin"] = $userdata["superadmin"];
                        $_SESSION["userid"] = $id;
                        $_SESSION["visible"] = (($userdata["visible"] === true) || ($userdata["visible"] == "on"));
                        $_SESSION["group"] = $userdata["group"];
                        
                        $data[$listName][$id]["lastloggedin"] = date("Y-m-d H:i:s");
                        $data[$listName][$id]["totallogins"] = isset($userdata["totallogins"]) && $userdata["totallogins"] != "" ? $userdata["totallogins"] + 1 : 1;

                        $itemData = $data[$listName][$id];
                        unset($data[$listName][$id]);
                        $data[$listName][$id] = $itemData;
                        file_put_contents($this->filePath, json_encode($data));

                        header("Location: " . $this->homePath);
                        die("test");
                    }                   
                    break;
                }
            }
           
            $_SESSION["error_message"] = "Deze gebruiker bestaat niet of het wachtwoord is verkeerd";
            header("Location: " . $this->loginPath);
        }
    }

    public function actionReset()
    {
        if (isset($_POST["username"])) {
            $username = $_POST["username"];

            $listName = $this->listName;
            $data = $this->data;

            $settingCrud = new SettingCrud();

            foreach ($data[$listName] as $id => $userdata) {
                if (strtolower($userdata["username"]) == strtolower($username)) {
                    $mail = new PHPMailer();
                    $mail->isSMTP();   
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $mail->Host = $settingCrud->actionGetSetting("smtp_host");
                    $mail->Port = $settingCrud->actionGetSetting("smtp_port");;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->SMTPAuth = true;
                    $mail->Username = $settingCrud->actionGetSetting("smtp_user");
                    $mail->Password = $settingCrud->actionGetSetting("smtp_password");

                    $mail->setFrom($settingCrud->actionGetSetting("smtp_user"));
       
                    $mail->addAddress($username);

                    $mail->Subject = 'Pr(emed)onostiek: wachtwoord opnieuwe instellen';
                    $mail->msgHTML(file_get_contents((empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]/$_SESSION[install_path]/resettemplate.php?id=$id"));


                    if (!$mail->send()) {
                        $_SESSION["error_message"] = "Deze gebruiker bestaat niet.";
                       
                    } else {
                        $_SESSION["success_message"] = "Er is een mail opgestuurd met een link om uw wachtwoord opnieuw in te stellen.";
                    }
                }
            }
            header("Location: " . $this->loginPath);
           
        }
    }

    public function actionSetMatchScoreQP($id, $matchid, $quickpickdata)
    {
        $listName = $this->listName;
        $data = $this->data;
        $itemData = $data[$listName][$id];

        $itemData["matches"][$matchid] = $quickpickdata;

        unset($data[$listName][$id]);
        $data[$listName][$id] = $itemData;
        file_put_contents($this->filePath, json_encode($data));
    }

    public function actionSaveQuickPick(){       

        $id = $_SESSION["userid"];
        $listName = $this->listName;
        $data = $this->data;
        $itemData = $data[$listName][$id];

        $quickpick = $_POST["quickpick"];
        $itemData["quickpicker"] = $quickpick;

        unset($data[$listName][$id]);
        $data[$listName][$id] = $itemData;
        file_put_contents($this->filePath, json_encode($data));
    }

    public function actionSaveDeviceKey(){       

        $id = $_SESSION["userid"];
        $listName = $this->listName;
        $data = $this->data;
        $itemData = $data[$listName][$id];

        $devicekey = $_POST["devicekey"];
        $itemData["devicekey"] = $devicekey;

        unset($data[$listName][$id]);
        $data[$listName][$id] = $itemData;
        file_put_contents($this->filePath, json_encode($data));
    }

    public function actionSaveData(){
       
        $id = $_SESSION["userid"];
        $listName = $this->listName;
        $data = $this->data;
        $itemData = $data[$listName][$id];
      
        $matchCrud = new MatchCrud();
        $allMatchData = $matchCrud->actionRead();

        foreach($_POST["matches"] as $match => $udata)
        {
            $itemData["matches"][$match] = $udata;

            if(isActive($allMatchData[$match]["locked"]))
            {
                $itemData["matches"][$match]["cheated"] = (new DateTime("now"))->format("d-m-Y H:i:s");
            }

        }
        
        if(isset($_POST["questions"]))
            $itemData["questions"] = $_POST["questions"];
       
        unset($data[$listName][$id]);
        $data[$listName][$id] = $itemData;
        file_put_contents($this->filePath, json_encode($data));

        $_SESSION["success_message"] = "De pronostiek is goed opgeslagen.";
        header("Location: " . $this->homePath);
    }


    public function actionUpdateMatchScore($userid, $userdata)
    {
        
        $listName = $this->listName;
        $data = $this->data;
        $itemData = $data[$listName][$userid];

        $itemData = $userdata;

        unset($data[$listName][$userid]);
        $data[$listName][$userid] = $itemData;
        file_put_contents($this->filePath, json_encode($data));
        
    }

    public function actionSaveQuestions(){
        $listName = $this->listName;
        $data = $this->data;
        $itemData = $data[$listName];
        
        $qid = $_POST["qid"];


        foreach($itemData as $uid => $udata)
        {
            if(!isset($udata["questions"]))
            {
                $itemData[$uid]["questions"] = [];
            }    

            if(isset($_POST["question"][$uid]))
            {
                $itemData[$uid]["questions"][$qid]["correct"] = true;
            }
            else
            {
                $itemData[$uid]["questions"][$qid]["correct"] = false;
            }
        }
     
        unset($data[$listName]);
        $data[$listName] = $itemData;
        file_put_contents($this->filePath, json_encode($data));
        header("location: " . $this->adminPath . "?tab=questions");
    }

    public function actionNewPassword(){
        $id = $_POST["uid"];
        $password = $_POST["password"];

        $id = urldecode($id);

        $listName = $this->listName;
        $data = $this->data;
        $itemData = $data[$listName];

        $foundid = 0;

        foreach($itemData as $uid => $udata)
        {
            if(password_verify($uid, $id))
            {
                $foundid = $uid;
                break;
            }
        }

        $itemData = $data[$listName][$foundid];
        
        $itemData["password"] = password_hash($password, PASSWORD_DEFAULT);

        if ($itemData) {
            unset($data[$listName][$foundid]);
            $data[$listName][$foundid] = $itemData;
            file_put_contents($this->filePath, json_encode($data));
        }
        
       

        header("Location: " . $this->loginPath);
    }
}
