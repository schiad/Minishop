<?PHP

session_start();
$mysqli = db_connect();



$error = '';

if (!empty($_POST["submit_sudoer"]) || !empty($_POST["admin_sudoer"]) || !empty($_POST["login_sudoer"]))
{
	if ($_POST["login_sudoer"] === "root")
	{

		$error = "Interdiction de changer les droits du compte racine (root) c'est pas bien!";

	}
	if (empty($_POST["login_sudoer"]))
		$error = "Champ utilisateur vide !";

	if (empty($error))
	{
		$sql = "SELECT * FROM `users` WHERE login='" . $_POST["login_sudoer"] . "'";

		$res = mysqli_query($mysqli, $sql) or die("Error : " . mysqli_error($mysqli));
		$i = 0;
		while ($result[$i++] = mysqli_fetch_array($res)) {
		}
		if ($result[0][login] !== $_POST["login_sudoer"])
		{
			$error = "L'utilisateur entr&eacute; ne correspond pas &agrave; un utilisateur connu.";
		}
	}

	if (empty($error))
	{
		$admin = 0;
		if ($_POST["admin"] === "1")
			$admin = 1;
		$query = "UPDATE users SET admin='" . $admin . "' WHERE login='" . $_POST["login_sudoer"] . "'";
		if (!mysqli_query($mysqli, $query)) {
			echo("Error : " . mysqli_error($mysqli));
		}
		?>
		<p class="success">Nouveau statut enregistr&eacute.</p>
		<?php
		mysqli_close($mysqli);
	}
	else 
	{
		echo '<p class="error">' . $error . '</p>';
	}
}
?>


<p>Bonjour pour modifier les droits d'aministrateur d'un utilisateur remplisez les champs:</p>
<form action="?page=admin&view=user" method="post">
	<p>Utilisateur</p><input type="text" name="login_sudoer" />
	<br />
	<p style="display:inline">Adminitrateur ?</p><input type="checkbox" name="admin_sudoer" value="1"/>
	<br />
	<input type="submit" name="submit_sudoer" value="OK" />
</form>
