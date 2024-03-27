<?php

class MatchCrud
{
    private $homePath;
    private $regPath;
    private $loginPath;
    private $adminPath;
    private $filePath;
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
            $this->listName = "matches";
            $this->attributesList = ["date", "hour", "home", "away", "home_score", "away_score","round","id"];
        } else {
            throw new Exception("No file found", 1);
        }
    }

    public function actionAdd()
    {
        $listName = $this->listName;
        $data = $this->data;

        $matchdata = [];

        $matchdata["date"] = $_POST["date"];
        $matchdata["hour"] = $_POST["hour"];
        $matchdata["home"] = $_POST["home"];
        $matchdata["away"] = $_POST["away"];
        $matchdata["home_score"] = "";
        $matchdata["away_score"] = "";
        $matchdata["round"] = $_POST["round"];
        $matchdata["id"] = $_POST["id"];

        if($this->actionMatchData($matchdata["id"]) == null)
        {
            array_push($data[$listName], $matchdata);
            file_put_contents($this->filePath, json_encode($data));
            $_SESSION["success_message"] = "Match werd succesvol toegevoegd.";
        }
        else
        {
            $_SESSION["error_message"] = "Deze wedstrijd werd reeds toegevoegd.";
        }

       
        header("Location: " . $this->adminPath);
    }


    public function actionMatchDataById($id = null)
    {
        $listName = $this->listName;
        $data = $this->data;

        $itemData = $data[$listName][$id];

        if ($itemData) {
            return $itemData;
        }

        return null;
    }

    public function actionMatchData($id = null)
    {
        $listName = $this->listName;
        $data = $this->data;

        foreach ($data[$listName] as $id => $matchdata) {
            if ($matchdata["id"] == $id) {
                return $matchdata;
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
                    $post[$value] = isset($_POST[$value]) ? $_POST[$value] : "";
                }

            if ($itemData) {
                unset($data[$listName][$id]);
                $data[$listName][$id] = $post;
                file_put_contents($this->filePath, json_encode($data));
            }
            header("Location: " . $this->adminPath);
        }
    }
}
