<?php
session_start();
?>
<html>
	<head>
		<link rel="shortcut icon" href="images/mainicon.ico">
		<link rel="stylesheet" href="style/main.css">
		<title>Movie Database</title>
		<script type="text/javascript">
		</script>
	<head>
	<body bgcolor="white">
<?php
	function find_in_array($searchword, $array){
		$found = array();
		foreach ($array as $key => $value) {
			if(startsWith($value,$searchword)){
				$found[] = $value;
			}
		}
		return $found;
	}
	function startsWith($haystack, $needle)
	{
		$needle = ucfirst($needle);
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}
	$dir = "/shares/nedladdat";
	$page = 1;
	$resultsPerPage = 25;
	$origFiles = array();
	if(!isset($_SESSION["files"]) || (isset($_GET['s']) && $_GET['s'])=='' || (!isset($_GET['p']) && !isset($_GET['s']))){
	$files = array();
		if (is_dir($dir)){
			if ($dh = opendir($dir)){
				while (($file = readdir($dh)) !== false){
					if (strpos($file, '.') !== false){
						$temp = substr($file,0,-4);
						if(strlen($temp)!=0){
							$files[] = $temp;
						}
					}
				}
			}
		}
		$_SESSION["files"] = $files;
	}
	else if(isset($_GET['s'])){
		$fileCopy = $_SESSION["files"];
		$files = find_in_array($_GET['s'],$fileCopy);
	}
	else{
		$files = $_SESSION["files"];
	}
	if(isset($_GET['p'])) {
		$page = $_GET['p'];
		$_SESSION["page"] = $_GET['p']; 
	}
	$limit = $page * $resultsPerPage;
	($limit > count($files)) ? $limit = count($files) : $limit = $limit;
?>
<span style="float:right"><a href="index.php"><img src="images/detail.png"/></a></span>
<?php 
	for($i = ($limit - $resultsPerPage); $i < $limit; $i++) {
		if(strlen($files[$i])!=0){
			$fileEncode = urlencode($files[$i]);
			$fileEncode = str_replace("_",":",$fileEncode);
			$json=file_get_contents("http://www.omdbapi.com/?t=$fileEncode");
			$info=json_decode($json);
			if(strlen($info->Title)!=0){
?>
			<div><a href="index.php?s=<?php echo $files[$i]?>"><img src="<?php echo $info->Poster ?>" height="150" width="100" class="listImage"/></a></div>
<?php					
			}
				
		}
		if($i == $limit-1){
			$newPage = $page+1;
?>
			<a class="title" style="float:right;margin-right:2em;margin-top:2em" href="asList.php?p=<?php echo $newPage?>"><img src="images/arrow.jpg" border="0"></a>
<?php				
		}
	}
?>
	</body>
</html>