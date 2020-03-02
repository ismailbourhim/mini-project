<?php 
include_once("database.php");

session_start();
$iduser = $_SESSION["id"];
$result = mysqli_query($mysqli, "SELECT * FROM contribution where id_user=$iduser ORDER BY id ASC");


if (!isset($_SESSION["autoriser"]))
{
	header('Location:login.php');
}

if(isset($_POST['Submit']))
{ 
	$filepath = "images/" . time() . $_FILES["image"]["name"];
	$image = time().$_FILES['image']['name'];
	move_uploaded_file($_FILES["image"]["tmp_name"], $filepath);

	
	$name = mysqli_real_escape_string($mysqli, $_POST['name']);
	$location = mysqli_real_escape_string($mysqli, $_POST['location']);
	$description = mysqli_real_escape_string($mysqli, $_POST['description']);
	$price = mysqli_real_escape_string($mysqli, $_POST['price']);
	$nbrcopie = mysqli_real_escape_string($mysqli, $_POST['nbrcopie']);

	$mysqli->query("INSERT INTO contribution(id_user,nom,location,description,image,prix,nbr_copie) VALUES('$iduser','$name','$location','$description','$image','$price','$nbrcopie')");

	header('Location:contribution.php');
}

if(isset($_POST['modifier']))
{
	$id = mysqli_real_escape_string($mysqli, $_POST['idd']);

	$filepath = "images/" . time() . $_FILES["upd-imgs"]["name"];
	$upd_image = time().$_FILES['upd-imgs']['name'];
	move_uploaded_file($_FILES["upd-imgs"]["tmp_name"], $filepath);

	
	$upd_name = mysqli_real_escape_string($mysqli, $_POST['upd-name']);
	$upd_location = mysqli_real_escape_string($mysqli, $_POST['upd-location']);
	$upd_description = mysqli_real_escape_string($mysqli, $_POST['upd-description']);
	$upd_price = mysqli_real_escape_string($mysqli, $_POST['upd-price']);
	$upd_nbrcopie = mysqli_real_escape_string($mysqli, $_POST['upd-nbrcopie']);

	$mysqli->query("UPDATE contribution SET nom='$upd_name',location='$upd_location',description='$upd_description',image='$upd_image',prix='$upd_price',nbr_copie='$upd_nbrcopie' WHERE id=$id");

	header('Location:contribution.php');
}
if(isset($_POST['delete']))
{	

	$id = mysqli_real_escape_string($mysqli, $_POST['idd']);

	$result = mysqli_query($mysqli, "DELETE FROM contribution WHERE id=$id");

	header('Location:contribution.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Contribution</title>
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
			    	<a id="btn-add" href="#" class="add-img">
			    	<form style="visibility: hidden;" id="show" class="form-cont" action="contribution.php" enctype="multipart/form-data" method="post">
			    		<input class="frst-from" type="text" name="name" placeholder="name here" required><br/>
			    		<input class="frst-from" type="text" name="location" placeholder="location" required><br/>
			    		<textarea class="frst-from" name="description" rows="6" placeholder="description here" required></textarea><br/>
			    		<input style="margin-left: 1rem;" type="file" name="image" required><br/>
			    		<div style="display: flex;flex-direction: row;justify-content: space-around;">
				    			<input style="width: unset;" class="frst-from" type="text" name="price" placeholder="price" required><br/>
			    				<input style="width: unset;" class="frst-from" type="text" name="nbrcopie" placeholder="number of copies" required><br/>
				    	</div>
						<input class="sub-impt" type="submit" value="" name="Submit"> <br/>
			    	</form>
			    	</a>
			    </div>	

		    	<?php $count = 1; ?>
			    <?php while($res = mysqli_fetch_assoc($result)) { ?>

			    <div id='sp-empty' class='col-sm-4'>
			    	<div class='info' style="background-image: url(images/<?php echo $res['image']; ?>);background-position: center;background-repeat: no-repeat;background-size: cover;">
			    		<form action="contribution.php" enctype="multipart/form-data" method="post">
				    		<div class="info-block" id="information-<?php echo $count; ?>">
					    		<p><?php echo $res['nom']; ?></p>
					    		<p><?php echo $res['location']; ?></p>
					    		<p style="height: 132px;"><?php echo $res['description']; ?></p>
					    		<p><?php echo $res['image']; ?></p>
					    		<div style="display: flex;flex-direction: row;justify-content: space-around;">
					    			<p><?php echo $res['prix']." $"; ?></p>
					    			<p><?php echo $res['nbr_copie']." copies"; ?></p>
					    		</div>
					    		<input type="hidden" name="idd" value=<?php echo $res['id']; ?>>
					    		<input id="upt-icon" name="update" value="" onclick="uptForm('<?php echo $count; ?>')"></td>
								<input id="dlt-icon" type="submit" name="delete" value="" onClick="return confirm('Are you sure you want to delete?')">
				    		</div>
			    		</form>
			    		
			    		<form style="display: none;" id="frm-<?php echo $count; ?>" class="image-form" action="contribution.php" enctype="multipart/form-data" method="post">
			    			<input class="" type="text" name="upd-name" value=<?php echo $res['nom']; ?>><br/>
				    		<input class="" type="text" name="upd-location" value=<?php echo $res['location']; ?>><br/>
				    		<textarea class="" rows="4" name="upd-description"><?php echo $res['description']; ?></textarea><br/>
				    		<input type="file" name="upd-imgs" value=<?php echo $res['image']; ?>><br/>
				    		<input class="" type="number" name="upd-price" value=<?php echo $res['prix']; ?>><br/>
				    		<input class="" type="number" name="upd-nbrcopie" value=<?php echo $res['nbr_copie']; ?>><br/>
				    		<input type="hidden" name="idd" value=<?php echo $res['id']; ?>>
							<input class="sub-impt" type="submit" value="" name="modifier"> <br/>
			    		</form>
			    	</div>
			    </div>
			<?php 
			$count++;
		} ?>
			  </div>
			</div>
		</div>
	</div>
</body>
</html>

<script src="js/script.js"></script>