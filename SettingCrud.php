<?php

class SettingCrud
{
    private $adminPath;
    private $filePath;
    private $fileContent;
    public $data;
    public $listName;
    public $attributesList;

    public function __construct($filePath = 'data.json')
    {
        $filePath = $_SESSION["datafile"];
        $this->adminPath = $_SESSION["install_path"] . "/admin.php";

        if (file_exists($filePath)) {
            $this->filePath = $filePath;
            $this->fileContent = file_get_contents($filePath);
            $this->data = json_decode($this->fileContent, true);
            $this->listName = "settings";
            $this->attributesList = ["registrations"];
        } else {
            throw new Exception("No file found", 1);
        }
    }

    public function actionSave()
    {     
            $id = 0;
            $listName = $this->listName;
            $data = $this->data;
            $itemData = $data[$listName][$id];

            foreach ($this->attributesList as $value) {

                if($value == "registrations")
                {
                    $post[$value] = isset($_POST[$value]) ? true : false;
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
            header("Location: " . $this->adminPath);
        
    }

    public function actionGetSetting($name)
    {   
        $id = 0;
        $listName = $this->listName;
        $data = $this->data;

        $setting = $data[$listName][$id][$name];

        return $setting;
    }

    public function actionGetAllSettings()
    {   
        $id = 0;
        $listName = $this->listName;
        $data = $this->data;

        $settings = $data[$listName][$id];

        return $settings;
    }
    
}