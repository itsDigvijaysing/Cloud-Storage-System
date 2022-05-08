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
			/* top:10%; */
 			height: 100vh;
			text-align: center;
    		display: flex;
    		justify-content: center;
    		align-items: center;
			background-color:#ffffff;
			height: 80%;
			width:60%;
			border-radius:25px;
			">
 <!-- <div style="padding: 10px;"> -->
 
<!-- </div> -->
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
	<form action="delete.php" method="delete" name="deleteall" id="deleteall" >
	<input type="submit" value="Delete All">
 </form>
<div style="padding: 10px;">
  <h3>Encrypted Files<h3>
  <?php
  $files = scandir("upload");
 
 for($a =2; $a<count($files); $a++) {
	?>
	 	<p>
		<a upload ="<?php echo $files[$a] ?>"  href="upload/<?php echo $files[$a] ?>"><?php echo $files["$a"] ?></a>
		</P>
		<?php
	}?>
</div>
<br><br>
<div style="padding: 10px;">
  <h3>Decypted files<h3>
  <?php
  $files = scandir("download");
 
 for($a =2; $a<count($files); $a++) {
	?>
	 	<p>
		<a dowload ="<?php echo $files[$a] ?>"  href="download/<?php echo $files[$a] ?>"><?php echo $files["$a"] ?></a>
		</P>
		<?php
	}?>
</div>
</div>

 </div>
 </body>  
 </html>