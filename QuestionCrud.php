<?php

class QuestionCrud
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
            $this->listName = "questions";
            $this->attributesList = ["question", "locked"];
        } else {
            throw new Exception("No file found", 1);
        }
    }

    public function actionAdd()
    {
        $listName = $this->listName;
        $data = $this->data;

        $questiondata = [];

        $questiondata["question"] = $_POST["question"];
        $questiondata["locked"] = false;

        if($this->actionQuestionData($questiondata["question"]) == null)
        {
            array_push($data[$listName], $questiondata);
            file_put_contents($this->filePath, json_encode($data));
            $_SESSION["success_message"] = "Vraag werd succesvol aangemaakt.";
        }
        else
        {
            $_SESSION["error_message"] = "Deze vraag bestaat reeds.";
        }


        header("Location: " . $this->adminPath . "?tab=questions");
    }


    public function actionQuestionDataById($id = null)
    {
        $listName = $this->listName;
        $data = $this->data;

        $itemData = $data[$listName][$id];

        if ($itemData) {
            return $itemData;
        }

        return null;
    }

    public function actionQuestionData($question = null)
    {
        $listName = $this->listName;
        $data = $this->data;

        foreach ($data[$listName] as $id => $questiondata) {
            if ($questiondata["question"] == $question) {
                return $questiondata;
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
            header("Location: " . $this->adminPath. "?tab=questions");
        }
    }
}
