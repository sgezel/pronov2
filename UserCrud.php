<?php

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
            $this->attributesList = ["username", "name", "password", "admin", "visible", "paid","quickpicker","devicekey", "questions", "matches"];
        } else {
            throw new Exception("No file found", 1);
        }
    }

    public function actionAdd()
    {
        $listName = $this->listName;
        $data = $this->data;

        $userdata = [];

        $userdata["username"] = $_POST["username"];
        $userdata["name"] = $_POST["name"];
        $userdata["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $userdata["admin"] = false;
        $userdata["visible"] = true;
        $userdata["paid"] = false;
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

        header("Location: " . $this->regPath);
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
                    $post[$value] = password_hash($_POST[$value], PASSWORD_DEFAULT);
                }
                else if ($value == "matches")
                {
                    $post[$value] = isset($itemData["matches"]) ? $itemData["matches"] : [];
                }
                else if ($value == "questions")
                {
                    $post[$value] = isset($itemData["questions"]) ? $itemData["questions"] : [];
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
                        $_SESSION["userid"] = $id;
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

            foreach ($data[$listName] as $id => $userdata) {
                if (strtolower($userdata["username"]) == strtolower($username)) {
                        //Send mail
                }
            }
           
            $_SESSION["error_message"] = "Deze gebruiker bestaat niet.";
            header("Location: " . $this->loginPath);
        }
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

       // $itemData["matches"] = $_POST["matches"];

      
        foreach($_POST["matches"] as $match => $udata)
        {
            $itemData["matches"][$match] = $udata;
        }       
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

        print_r($_POST);
        foreach($itemData as $uid => $udata)
        {
            echo "userid: $uid\n";
            if(isset($udata["questions"]))
            {
                echo "questions set\n";
                foreach($udata[$uid]["questions"] as $qid => $questiondata)
                {
                    if(isset($_POST["user"][$uid]["questions"][$qid]))
                    {
                        $itemData[$uid]["questions"][$qid]["correct"] = true; 
                    }
                    else
                    {
                        $itemData[$uid]["questions"][$qid]["correct"] = false;
                    }
                }
            }
            
        }
        
        die(print_r($itemData, true));

        unset($data[$listName]);
        $data[$listName] = $itemData;
        file_put_contents($this->filePath, json_encode($data));
    }
}
