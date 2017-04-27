<?php

session_start();

if (($_SESSION["loggued_on_user"]))
{
	if ($_POST["submit"] !== "DELETE")
	{
		?>
		<html><body>
		<p>Pour supprimer votre compte remplisez les champs suivants:</p>
		<form action="?page=delete" method="post">
			<p>Nom d'utilisateur</p><input type="text" name="login" />
			<br />
			<p>Mot de passe</p><input type="password" name="passwd" />
			<br />
			<p>Repeter le mot de passe</p><input type="password" name="passwd2" />
			<input type="submit" name="submit" value="DELETE" />
		</form>
	</body></html>
	<?php
}
else 
{
	$error = 0;
	if ($_SESSION["loggued_on_user"] === "root")
	{
		$error = 1;
		?>
		<p>Il est interdit de supprimer le compte racine (root) c'est pas bien!</p>
		<?php
	}
	if ($_SESSION["loggued_on_user"] !== $_POST["login"])
	{
		$error = 1;
		?>
		<p>Nom d'utilisateur pas valide.</p>
		<?php
	}
	if ($_POST["passwd"] !== $_POST["passwd2"])
	{
		$error = 1;
		?>
		<p>Les deux champs de mots de passe ne corespondent pas!</p>
		<?php
	}
	if (!$error)
	{
		include ("../functions/connect.php");
		$mysqli = db_connect();

		$sql = "SELECT * FROM `users` WHERE login='" . $_SESSION["loggued_on_user"] . "'";


		if (!$res = mysqli_query($mysqli, $sql)) {
			echo("Error : " . mysqli_error($mysqli));
		}	
		$i = 0;
		while ($result[$i++] = mysqli_fetch_array($res)) {
		}
		if ($result[0][passwd] !== hash(whirlpool, $_POST["passwd"]))
		{
			$error = 1;
			?>
			<p>Erreur votre mot de passe ne correspond pas.</p>
			<?php
		}
	}
	if (!$error)
	{
		$query = "DELETE FROM `users` WHERE login='" . $_SESSION["loggued_on_user"] . "'";

		if (!mysqli_query($mysqli, $query))
		{
			echo("Error : " . mysqli_error($mysqli));
		}
		include ("../functions/logout.php");
		logout();
		?>
		<p>Compte de l'utilisateur <?php echo $_SESSION["loggued_on_user"]; ?> supprim&eacute.</p>
		<?php
	}
	else
	{
		?>
		<html><body>
		<p>Pour supprimer votre compte remplisez les champs suivants:</p>
		<form action="?page=delete" method="post">
			<p>Nom d'utilisateur</p><input type="text" name="login" />
			<br />
			<p>Mot de passe</p><input type="password" name="passwd" />
			<br />
			<p>Repeter le mot de passe</p><input type="password" name="passwd2" />
			<input type="submit" name="submit" value="DELETE" />
		</form>
	</body></html>
	<?php
}

}
}
else
{
	?>
	<p>Suppression de compte impossible si vous n'&ecirctes pas identifi&eacute.</p>
	<?php
}
?>
