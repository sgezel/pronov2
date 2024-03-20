<pre>


<?php
          $files = scandir('data/user/');
          $vragen = [];

          $nognietingevuld = [];

          $bonusvragenjuist = [];

          $contestants = "";

          foreach($files as $file) {
           if ($file !== "." && $file !== ".."  && $file !== ".gitignore" && file_exists("data/user/" . $file))
           {
            $filename = "data/user/" . $file;
            $userdata =  json_decode(file_get_contents($filename), true);

	     if(!array_key_exists("vragen", $userdata))
	     {
		$nognietingevuld[] = $userdata["username"] . ": " . "Geen enkele vraag ingevuld";
             }	

	
            if(array_key_exists("vragen", $userdata))
            {
		foreach ($userdata["vragen"] as $vraag => $antwoord)
		{
			if(empty($antwoord))
			{

				$nognietingevuld[]  = $userdata["username"].  ": Niet alle vragen ingevuld";
				break;
			}	
			
		}

           }
        }
}

var_dump($nognietingevuld);  


 
?>
</pre>