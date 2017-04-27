<?php

session_start();

if (isset($_POST["login_admin_del"]) || isset($_POST["submit_admin_del"])){
	$error = "";
	if ($_POST["login_admin_del"] === "")
		$error = "Champ utilisateur vide.";
	if ($_POST["login_admin_del"] === "root")
		$error = "Il est interdit de supprimer le compte racine (root) c'est pas bien!";
	if (empty($error))
	{
		$mysqli = db_connect();
		$sql = "SELECT * FROM `users` WHERE login='" . $_POST["login_admin_del"] . "'";


		if (!$res = mysqli_query($mysqli, $sql)) {
			echo("Error : " . mysqli_error($mysqli));
		}	
		$i = 0;
		while ($result[$i++] = mysqli_fetch_array($res)) {
		}
		if ($result[0][login] !== $_POST["login_admin_del"])
			$error = "L'utilisateur ne correspond pas a un utilisateur connu.";

		if (!$error)
		{
			$query = "DELETE FROM `users` WHERE login='" . $_POST["login_admin_del"] . "'";

			if (!mysqli_query($mysqli, $query))
			{
				echo("Error : " . mysqli_error($mysqli));
			}
			?>
			<p class="success">Le compte de l'utilisateur <?php echo $_POST["login_admin_del"]; ?> supprim&eacute.</p>
			<?php
		}
	}

	if (!empty($error))
		echo '<p class="error">' . $error . '</p>';
}
?>


<p>Pour supprimer un compte remplisez les champs suivants:</p>
<form action="?page=admin&view=user" method="post">
	<p>Nom d'utilisateur</p><input type="text" name="login_admin_del" />
	<br />
	<input type="submit" name="submit_admin_del" value="DELETE" />
</form>
