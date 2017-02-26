<html>
	<head>
		<link rel="shortcut icon" href="images/mainicon.ico">
		<link rel="stylesheet" href="style/main.css">
		<link rel="stylesheet" href="style/w3.css">
		<title>Movie Database</title>
		<script type="text/javascript">
		</script>
	<head>
	<body>
<?php
	$dir = "../../../shares/nedladdat";
	if (is_dir($dir)){
		$cnt = 0;
  		if ($dh = opendir($dir)){
    	while (($file = readdir($dh)) !== false && $cnt < 20){
			if (strpos($file, '.') !== false){ 
				$fileFix = substr($file,0,-4);
				if(strlen($fileFix)!=0){
					$fileEncode = urlencode($fileFix);
					$json=file_get_contents("http://www.omdbapi.com/?t=$fileEncode");
					$info=json_decode($json);
					if(strlen($info->Title)!=0){
?>
				<div class="w3-container">
 					<div class="w3-card-4" style="width:70%">
    					<div class="w3-container">
      						<img src="<?php echo $info->Poster ?>" height="300" width="200" class="w3-left w3-circle w3-margin-right"/>
     						<span class="title"><?php echo $info->Title ?></span><br/><br/>
     						<span class="main">
     						<?php echo $info->Runtime ?><br/><br/>
							<?php echo $info->Plot ?><br/><br/>
							<?php echo $info->Actors ?><br/><br/>
							IMDB grade:<?php echo $info->imdbRating ?>&nbsp;&nbsp;&nbsp;<a href="http://www.imdb.com/title/<?php echo $info->imdbID ?>" target="_blank"><img src="images/imdb.png" border="0"/></a><br/>
							
							</span>
    						</div>
    						<button class="w3-button w3-block w3-dark-grey">PLAY ></button>
  					</div>
  				</div>
<?php					
					$cnt++;
					}
					else{
?>
				<div class="w3-container">
 					<div class="w3-card-4" style="width:70%">
    					<div class="w3-container">
      						<span class="title"><?php echo $fileFix ?></span>
      						<button class="w3-button w3-block w3-dark-grey">PLAY ></button>
      					</div>
  					</div>
  				</div>
<?php						
					}
				}
			}
    	}
    	closedir($dh);
  	}
	}
?>
	</body>
</html>