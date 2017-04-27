<?php

session_start();

if (isset($_POST['ref_create']) || isset($_POST['name_create']) || isset($_POST['price_create']) || isset($_POST['stock_create']) || isset($_POST['active_create']) || isset($_POST['promo_rate_create'])) {
	$link = db_connect();
	$error = '';

	if (empty($_POST['ref_create']) || empty($_POST['name_create'])) {
		$error = 'Les champs Ref. et Intitule sont obligatoires.';
	}

	if (empty($error)) {
		$ref = mysqli_real_escape_string($link, $_POST['ref_create']);
		$name = mysqli_real_escape_string($link, $_POST['name_create']);
		$price = floatval($_POST['price_create']);
		$stock = intval($_POST['stock_create']);
		$promo_rate = floatval($_POST['promo_rate_create']);
		$query = "INSERT INTO products (ref, name, price, stock, active, promo_rate) VALUES('".$ref."', '".$name."', '".$price."', '".$stock."', '".$_POST['active_create']."', '".$promo_rate."');";
		if (!mysqli_query($link, $query)) {
			$error = mysqli_error($link);
		}
	}
	if (empty($error)) {
		echo '<p class="success">L\'article a bien ete ajout&eacute;</p>';
	} else {
		echo '<p class="error">' . $error . '</p>';
	}
}
?>

<h4>Ajout d'un article</h4>
<form action="?page=admin&view=product" method="post" autocomplete="off">
	<p>
		<label>Reference de l'article</label><input type="text" name="ref_create" placeholder="Ref."/>
	</p>
	<p>
		<label>Intitul&eacute; de l'article</label><input type="text" name="name_create" placeholder="Article name"/>
	</p>
	<p>
		<label>Prix de l'article</label><input type="text" name="price_create" placeholder="Price" />
	</p>
	<p>
		<label>Nb en stock</label><input type="text" name="stock_create" placeholder="Stock nb" />
	</p>
	<p>
		<label>Actif ?</label><input type="checkbox" name="active_create" checked="checked" value="1" />
	</p>
	<p>
		<label>Promo rate (%)</label><input type="text" name="promo_rate_create" placeholder="Promo rate %" value="0" />
	</p>
	<button type="submit">Ajouter l'article</button>
</form>
