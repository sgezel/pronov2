<?php

class UserCrud
{
    private $homePath;
    private $filePath;
    private $fileContent;
    public $data;
    public $listName;
    public $attributesList;

    public function __construct($filePath = 'data.json')
    {
        $this->homePath = "/pronov2/register.php";
        if (file_exists($filePath)) {
            $this->filePath = $filePath;
            $this->fileContent = file_get_contents($filePath);
            $this->data = json_decode($this->fileContent, true);
            $this->listName = "users";
            $this->attributesList = ["username", "name", "password", "admin", "visible"];
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
        $userdata["password"] = password_hash($_POST["password"],PASSWORD_DEFAULT);
        $userdata["admin"] = false;
        $userdata["visible"] = true;

        array_push($data[$listName], $userdata);
        file_put_contents($this->filePath, json_encode($data));
        header("Location: ".$this->homePath);
    }

    public function actionRead()
    {
        return $this->data;
    }

    public function actionEdit()
    {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $listName = $this->listName;
            $data = $this->data;
            $itemData = $data[$listName][$id];

            foreach ($this->attributesList as $value) {
                $post[$value] = isset($_POST[$value]) ? $_POST[$value] : "";
            }

            if ($itemData) {
                unset($data[$listName][$id]);
                $data[$listName][$id] = $post;
                file_put_contents($this->filePath, json_encode($data));
            }
            header("Location: /".$this->homePath);
        }
    }
    
    public function actionLogin()
    {
        if(isset($_POST["username"]))
        {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $listName = $this->listName;
            $data = $this->data;
            
            foreach($data as $id)
            {
                if($data[$listName][$id]["username"] == $username)
                {
                    if(password_verify($password, $data[$listName][$id]["password"]))
                        die("login ok");

                        die("password not valid");
                        break;
                }

                die("user not found");
            }
        }
    }
}
