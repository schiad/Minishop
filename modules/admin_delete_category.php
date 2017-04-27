<?php

session_start();

if (isset($_POST['name_category_delete'])) {
	$link = db_connect();
	$error = '';

	if (empty($_POST['name_category_delete'])) {
		$error = 'Le nom de la categorie est obligatoire.';
	}

	if (empty($error)) {
		$name = mysqli_real_escape_string($link, $_POST['name_category_delete']);
		$query = "DELETE FROM categories WHERE name='".$name."';";
		if (!mysqli_query($link, $query)) {
			$error = mysqli_error($link);
		} else if (mysqli_affected_rows($link) === 0) {
			$error = 'La cat&eacute;gorie n\'a pas &eacute;t&eacute; trouv&eacute;e.';
		}
	}
	if (empty($error)) {
		echo '<p class="success">La cat&eacute;gorie a &eacute;t&eacute; supprim&eacute;e</p>';
	} else {
		echo '<p class="error">' . $error . '</p>';
	}
}
?>

<h4>Suppression d'une cat&eacute;gorie</h4>
<form action="?page=admin&view=cat" method="post" autocomplete="off">
	<p>
		<label>Nom de la catégorie</label><input type="text" name="name_category_delete" placeholder="Category name"/>
	</p>
	<button type="submit">Supprimer la cat&eacute;gorie</button>
</form>
