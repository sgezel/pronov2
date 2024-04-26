<?php

class ScoreboardCrud
{
    private $filePath;
    private $adminPath;
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
            $this->listName = "scoreboard";
            $this->attributesList = [];
        } else {
            throw new Exception("No file found", 1);
        }
    }

    public function IsAnyMatchLive()
    {
        
        $matches = $this->data["matches"];

       
        $now = new DateTime();

        foreach($matches as $mid => $match)
        {            

            if($match["date"] !== $now->format("Y-m-d"))
                continue;

            if($match["time"] < date("H:i") && ($match["finished"] === false || $match["finished"] === "false"))
            {
                return true;
            }

        }
        return false;

    }

    
}
