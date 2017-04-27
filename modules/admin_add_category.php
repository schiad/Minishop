<?php

session_start();

if (isset($_POST['name_category_create'])) {
	$link = db_connect();
	$error = '';

	if (empty($_POST['name_category_create'])) {
		$error = 'Le nom de la categorie est obligatoire.';
	}

	if (empty($error)) {
		$name = ucfirst(mysqli_real_escape_string($link, $_POST['name_category_create']));
		$query = "INSERT INTO categories (name) VALUES('".$name."');";
		if (!mysqli_query($link, $query)) {
			$error = mysqli_error($link);
		}
	}
	if (empty($error)) {
		echo '<p class="success">La cat&eacute;gorie a bien ete ajout&eacute;</p>';
	} else {
		echo '<p class="error">' . $error . '</p>';
	}
}
?>

<h4>Ajout d'une cat&eacute;gorie</h4>
<form action="?page=admin&view=cat" method="post" autocomplete="off">
	<p>
		<label>Nom de la catégorie</label><input type="text" name="name_category_create" placeholder="Category name"/>
	</p>
	<button type="submit">Ajouter la cat&eacute;gorie</button>
</form>
