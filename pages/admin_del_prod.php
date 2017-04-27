<?php

session_start();

if (isset($_POST["prod_admin_del"]) || isset($_POST["submitp_admin_del"])){
	$error = "";
	if ($_POST["prod_admin_del"] === "")
		$error = "Champ reference produit est vide.";
	if (empty($error))
	{
		$mysqli = db_connect();
		$sql = "SELECT * FROM `products` WHERE ref='" . $_POST["prod_admin_del"] . "'";


		if (!$res = mysqli_query($mysqli, $sql)) {
			echo("Error : " . mysqli_error($mysqli));
		}	
		$i = 0;
		while ($result[$i++] = mysqli_fetch_array($res)) {
		}
		if ($result[0][ref] != $_POST["prod_admin_del"])
			$error = "La reference produit ne correspond pas a une ref connue.";

		if (!$error)
		{
			$query = "DELETE FROM `products` WHERE ref='" . $_POST["prod_admin_del"] . "'";

			if (!mysqli_query($mysqli, $query))
			{
				echo("Error : " . mysqli_error($mysqli));
			}
			?>
			<p class="success">La reference produit <?php echo $_POST["prod_admin_del"]; ?> supprim&eacute.</p>
			<?php
		}
	}

	if (!empty($error))
		echo '<p class="error">' . $error . '</p>';
}
?>




<p>Pour supprimer un article remplisez les champs suivants:</p>
<form action="?page=admin&view=product" method="post">
	<p>Reference produit</p><input type="text" name="prod_admin_del" />
	<br />
	<input type="submit" name="submitp_admin_del" value="DELETE" />
</form>
