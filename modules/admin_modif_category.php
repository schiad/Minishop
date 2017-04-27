<?php

session_start();

if (isset($_POST['name_category_modif']) || isset($_POST['new_name_category_modif'])) {
	$link = db_connect();
	$error = '';

	if (empty($_POST['name_category_modif']) || empty($_POST['new_name_category_modif'])) {
		$error = 'Tous les champs sont obligatoires.';
	}

	if (empty($error)) {
		$name = mysqli_real_escape_string($link, $_POST['name_category_modif']);
		$new_name = ucfirst(mysqli_real_escape_string($link, $_POST['new_name_category_modif']));
		$query = "UPDATE categories SET name='".$new_name."' WHERE name='".$name."';";
		if (!mysqli_query($link, $query)) {
			$error = mysqli_error($link);
		} else if (mysqli_affected_rows($link) === 0) {
			$error = 'La cat&eacute;gorie n\'a pas &eacute;t&eacute; trouv&eacute;e.';
		}
	}
	if (empty($error)) {
		echo '<p class="success">La cat&eacute;gorie a &eacute;t&eacute; modifi&eacute;e</p>';
	} else {
		echo '<p class="error">' . $error . '</p>';
	}
}
?>

<h4>Modification d'une cat&eacute;gorie</h4>
<form action="?page=admin&view=cat" method="post" autocomplete="off">
	<p>
		<label>Nom de la catégorie</label><input type="text" name="name_category_modif" placeholder="Category name"/>
	</p>
	<p>
		<label>Nouveau nom</label><input type="text" name="new_name_category_modif" placeholder="New category name"/>
	</p>
	<button type="submit">Modifier la cat&eacute;gorie</button>
</form>
