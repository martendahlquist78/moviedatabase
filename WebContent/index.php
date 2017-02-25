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
  		if ($dh = opendir($dir)){
    	while (($file = readdir($dh)) !== false){
      		echo "filename:" . $file . "<br>";
    	}
    	closedir($dh);
  	}
	}
?>
	</body>
</html>