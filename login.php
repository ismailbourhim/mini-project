<?php
	include_once("database.php"); 
	$show=false;
session_start();

	if (isset($_SESSION["autoriser"]))
{
	header('Location:contribution.php');
}elseif (isset($_SESSION["admin"])) {
	header('Location:add_user.php');
}
	$result = mysqli_query($mysqli, "SELECT id,nom,email,password,role FROM users");

	
	@$email=$_POST["email"];
	@$pass=$_POST["pass"];
	@$login=$_POST["login"];
	$existe=0;
	if(isset($login)){
		while($res = mysqli_fetch_assoc($result)) {
			$id = $res['id'];
			$nom = $res['nom'];
			$e = $res['email'];
			$p = $res['password'];
			$r = $res['role'];

			if($email==$e && $p==$pass){
				if(is_null($r)){
					$existe=1;
					break;
				}
				elseif($r=="admin"){
					$existe=2;
					break;
				}
				
			}
		}
		if($existe==1){
			$_SESSION["autoriser"]="oui";
			$_SESSION["nomPrenom"]= $nom;
			$_SESSION["id"]= $id;
			header("location:contribution.php");
		}
		if($existe==2){
			$_SESSION["admin"]="oui";
			$_SESSION["nomPrenom"]= $nom;
			header("location:add_user.php");
		}
		else{
			$erreur="Mauvais login ou mot de passe!";
			$show=true;
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/wrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</head>
<body class="page-id-11">
	<div class="login-page">
  <div class="form">
   <div class="alert alert-danger alert-dismissible fade <?php if($show){echo"show";}else{echo"hide";}?>">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong><?php echo @$erreur?></strong>
  </div>
    <form class="login-form" method="post" action="login.php">
      <i style="font-size: 40px;color: #60AE61;text-align: center;width: 100%;" class="fa fa-sliders" aria-hidden="true"></i>
      <p style="font-weight: 600;font-size: 20px;color: #60AE61;text-align: center;">Monuments Catalog Login</p>
      <p style="color: #60AE61;font-weight: 600;">E-mail</p>
      <input type="text" placeholder="example@gmail.com" name="email">
      <p style="color: #60AE61;font-weight: 600;">Password</p>
      <input type="password" placeholder="Only you know it." name="pass">
      <input type="submit" name="login" value="Login">
    </form>
  </div>
</div>
</body>
</html>