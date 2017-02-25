<html>
	<head>
		<link rel="shortcut icon" href="images/mainicon.ico">
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
    	while (($file = readdir($dh)) !== false){
			if (strpos($file, '.') !== false){ 
				$fileFix = substr($file,0,-4);
				if(strlen($fileFix)!=0 && $cnt < 10){
					$json=file_get_contents("http://www.omdbapi.com/?t=$fileFix");
					$info=json_decode($json);
?>
					<img src="<?php echo $info->Poster ?>" height="300" width="200"/><br/>
					<?php echo $info->Title ?>
<?php					
					$cnt++;
				}
			}
    	}
    	closedir($dh);
  	}
	}
?>
	</body>
</html>