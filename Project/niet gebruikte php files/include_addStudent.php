<script type="text/javascript" >
		$("#submitFile").on('click', function(){
					alert('clicked');
							
			$("#actions").css("visibility","hidden");
			$("#results").css("visibility","visible");
			$("#actions").css("display","none");
			$("#results").css("display","block");
	});
</script>
<h2>Voeg studenten toe:</h2>
	
<label for="inputFile" >Kies een bestand: </label>    
<div class="fileupload fileupload-new" data-provides="fileupload">
	<div class="input-append">
		<div class="uneditable-input span3">
			<i class="icon-file fileupload-exists"></i>
            <span class="fileupload-preview"></span><!--hier wordt de filename geviewd -->
        </div>
        <form style="float:right" action="homescreen.php#addStudent" 
        	method="post" enctype="multipart/form-data">
            <span class="btn btn-file" style="vertical-align: bottom;">
                <span class="fileupload-new">Select file</span>
                <span class="fileupload-exists">Change</span>
                <input name="e" id="inputFile" type="file" />
            </span>
    
            <a style="vertical-align: bottom;" href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a></br>
            <input class="btn" type="submit" name="submit" value="Submit" id="submitFile">
		</form>
	</div>
</div>

<?php

function getTextBetweenTags($string, $tagname) {
    $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
    preg_match($pattern, $string, $matches);
    return $matches[1];
}

if(isset($_POST['submit']))
{
	echo "filename: " . $_FILES['e']['name'] . "</br>";
	echo $_SERVER["HTTP_REFERER"]. "</br>";
	$ref = $_SERVER["HTTP_REFERER"];
	$l = strlen($ref);
	$z = strlen("homescreen.php");
	$start = $l - $z;
	$e = substr($ref,$start);
	echo $e;
}


	//if(isset($fileName) && !empty($fileName))
	//{
				// files uitlezen, lijn per lijn
				if(file_exists("Book1.csv") && pathinfo("Book1.csv", PATHINFO_EXTENSION) == "csv"){
					$f = fopen("Book1.csv","r");
					$fCount = count($f);
				//	echo $fCount;
					while(!feof($f)){ // file end of file = feof
						$line = fgets($f); // filegetstring = fgets
						$pieces = explode(";", $line);
						{
							//echo $line .  "</br>";
							for($c=0; $c<count($pieces);$c++)
							{
								echo $pieces[$c] . "    ";
							}
						}
						echo "</br>";
					}
					fclose($f);
				}
//	}
?>
