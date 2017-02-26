<?php
session_start();
?>
<html>
	<head>
		<link rel="shortcut icon" href="images/mainicon.ico">
		<link rel="stylesheet" href="style/main.css">
		<link rel="stylesheet" href="style/w3.css">
		<title>Movie Database</title>
		<script type="text/javascript">
		</script>
	<head>
	<body bgcolor="white">
<?php
	$dir = "../../../shares/nedladdat";
	$page = 1;
	$resultsPerPage = 10;
	if(!isset($_SESSION["files"]) || !isset($_GET['p'])){
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
	else{
		$files = $_SESSION["files"];
	}
	if(isset($_GET['p'])) {
		$page = $_GET['p'];
		$_SESSION["page"] = $_GET['p']; 
	}
	$limit = $page * $resultsPerPage;
	($limit > count($files)) ? $limit = count($files) : $limit = $limit;
	for($i = ($limit - $resultsPerPage); $i < $limit; $i++) {
		if(strlen($files[$i])!=0){
			$fileEncode = urlencode($files[$i]);
			$json=file_get_contents("http://www.omdbapi.com/?t=$fileEncode");
			$info=json_decode($json);
			if(strlen($info->Title)!=0){
?>
				<div class="w3-container">
 					<div class="w3-card-4" style="width:80%">
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
    						<a href="<?php echo $dir.'/'.$file?>"><button class="w3-button w3-block w3-dark-grey">PLAY ></button></a>
  					</div>
  				</div>
<?php					
			}
			else{
?>
				<div class="w3-container">
 					<div class="w3-card-4" style="width:70%">
    					<div class="w3-container">
      						<span class="title"><?php echo $files[$i] ?></span>
      						<button class="w3-button w3-block w3-dark-grey">PLAY ></button>
      					</div>
  					</div>
  				</div>
<?php						
			}
		}
		if($i == $limit-1){
			$newPage = $page+1;
?>
			<a class="title" style="float:right;margin-right:2em" href="index.php?p=<?php echo $newPage?>">MORE >></a>
<?php				
		}
	}
?>
	</body>
</html>