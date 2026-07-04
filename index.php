<html>
 <head>
 <title>Encrypted Storage</title>
 </head> 
 <body style="background-image: url('main_wall_3.png');
			  background-repeat: no-repeat;
			  background-size: cover;
 " >
 <div style="
			margin: auto;
 			height: 80vh;
			text-align: center;
    		display: flex;
    		justify-content: center;
    		align-items: center;
			background-color:#ffffff;
			width:60%;
			border-radius:25px;
			">
 <div style="padding: 10px;">
 <form action="upload.php" method="post" enctype="multipart/form-data" name="formFileUpload" id="formFileUpload"> 
 <table border="0"> 
 <tr>
 <td>Select a file </td>
 <td><input name="fileToUpload" type="file" id="fileToUpload">
 </td> 
</tr> 
 <tr> <td>&nbsp;</td>
 <td> <input name="btnUploadFile" type="submit" id="btnUploadFile" value="Upload"> 
 </td> 
 </tr>
 </table> 
 </form>
</div>
<br><br>
<div>
	<form action="delete.php" method="post" name="deleteall" id="deleteall" >
	<input type="submit" value="Delete All">
 </form>
<div style="padding: 10px;">
  <h3>Stored Files</h3>
  <?php
  require_once __DIR__ . '/config.php';
  $files = is_dir("upload") ? scandir("upload") : [];

 for($a = 2; $a < count($files); $a++) {
	if (substr($files[$a], -5) !== '.data') {
		continue;
	}
	$storedName = $files[$a];
	$displayName = originalFileName($storedName);
	$safeStoredName = htmlspecialchars($storedName, ENT_QUOTES, 'UTF-8');
	$safeDisplayName = htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8');
	?>
	 	<p>
		<?php echo $safeDisplayName; ?>
		<a href="download.php?file=<?php echo urlencode($storedName); ?>">Download</a>
		</p>
		<?php
	}?>
</div>
</div>

 </div>
 </body>  
 </html>
