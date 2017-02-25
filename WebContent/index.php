<html>
	<head>
		<link rel="shortcut icon" href="images/mainicon.ico">
		<link rel="stylesheet" href="style/main.css">
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
					<p class="title"><?php echo $info->Title ?></p><br/>
					<p class="main"><?php echo $info->Runtime ?><br/>
					<?php echo $info->Plot ?><br/>
					<?php echo $info->Actors ?><br/>
					<?php echo $info->imdbRating ?><br/></p>
					<a href="http://www.imdb.com/title/<?php echo $info->imdbID ?>" target="_blank">IMDB</a><br/>
					<img src="<?php echo $info->Poster ?>" height="300" width="200"/><br/>
<?php					
					$cnt++;
					}
					else{
						echo "<p class='main'>Hittade ingen info för ".$fileFix."</p><br>";
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