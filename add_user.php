<?php 
include_once("database.php"); 

$result = mysqli_query($mysqli, "SELECT * FROM users WHERE id!=57 ORDER BY id ASC");
$counter = mysqli_query($mysqli, "SELECT id_user,count(id_user) as nbr_cont FROM contribution group by id_user");

session_start();

if (!isset($_SESSION["admin"]))
{
	header('Location:login.php');
}

if(isset($_POST['Submit']))
{ 
	$filepath = "images/" . $_FILES["imgs"]["name"];
	$image = $_FILES['imgs']['name'];
	move_uploaded_file($_FILES["imgs"]["tmp_name"], $filepath);

	$nom = mysqli_real_escape_string($mysqli, $_POST['nom']);
	$email = mysqli_real_escape_string($mysqli, $_POST['email']);
	$pass = mysqli_real_escape_string($mysqli, $_POST['pass']);

	$mysqli->query("INSERT INTO users(image,nom,email,password) VALUES('$image','$nom','$email','$pass')");
	header("Location: add_user.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashbord</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/wrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="contain">
		<div class="bloc">
			<div><a href=""><i class="fa fa-sliders" aria-hidden="true"></i></a></div>
			<div><a href=""><i class="fa fa-users" aria-hidden="true"></i></a></div>
			<div><a href=""><i class="fa fa-info-circle" aria-hidden="true"></i></a></div>
			<div><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a></div>
		</div>
		<div class="content">
			<p id="msg-welcome">Bienvenue <?php echo $_SESSION["nomPrenom"];?></p>
			<div class="wid-div">
			  <div class="row">
			    <div id="sp-empty" class="col-sm-4">
			    	<div class="cadre">
			    	<form class="form-user" action="add_user.php" enctype="multipart/form-data" method="post">
			    		<!-- <input id="file-upt" type="file" name="imgs" required><br/> -->
			    		<input style="display: none;" id="fileUpload" type="file" name="imgs" id="inpFile" onchange="file(this)" required><br/>
			    		<div class="image-preview" id="imgpreview">
			    			<img id="previmage" src="images/add-icon.png" class="cl-img" onclick="triggerClick()">
			    		</div>
			    		<input class="stl-imput" type="text" name="nom" required><br/>
			    		<input class="stl-imput" type="email" name="email" required><br/>
			    		<input class="stl-imput" type="password" name="pass" required><br/>
						<input class="user-sub" type="submit" value="Ajouter" name="Submit"> <br/>
			    	</form>
			    	</div>
			    </div>	
			    
			    <?php while($res = mysqli_fetch_assoc($result)) { ?>
			    	
			    	<div id='sp-empty' class='col-sm-4'>
			    		<div class='cadre'>
			    			<img class=img-stl src="images/<?php echo $res['image'] ?>">
					    	<p><b><?php echo $res['nom'] ?></b></p>
					    	<p><?php echo $res['email'] ?></p>
					    	<?php  
						    	while($cont = mysqli_fetch_assoc($counter)) { 
						    		if($cont['id_user'] == $res['id']){ 
						    	?>
						    			<p style='color: #7f7c7c;'><?php echo $cont['nbr_cont'] ?> contributions</p>
						    	<?php 
						    		}else{ 
						    	?>
						    			<p style='color: #7f7c7c;'>0 contributions</p>
						    	<?php
						    		}
						    	break;
						    	}
					    	?> 
					    </div>
			    	</div>
			   <?php } ?> 
			   
			   
			  </div>
			</div>
		</div>
	</div>

</body>
</html>

<script src="js/script.js"></script>