<?PHP

session_start();

if (isset($_POST['login_create']) || isset($_POST['passwd_create']) || isset($_POST['admin_create'])) {
	$mysqli = db_connect();
	$error = '';

	if (!preg_match('/^[A-Za-z0-9]+$/', $_POST["login_create"])) {
		$error = 'Le nom d\'utilisateur ne peut contenir que des chiffres et des lettres.' . "\n";
	}

	if (empty($_POST["login_create"]) || empty($_POST["passwd_create"])) {
		$error .= 'Tous les champs sont obligatoires.';
	}

	$login = mysqli_real_escape_string($mysqli, $_POST['login_create']);

	if (empty($error)) {
		$sql = "SELECT user_id FROM users WHERE login='" . $login . "' LIMIT 1";
		$res = mysqli_query($mysqli, $sql) or die("Error : " . mysqli_error($mysqli));
		if (mysqli_num_rows($res) > 0) {
			$error = 'Utilisateur deja existant.';
		}
	}

	if (empty($error)) {
		$login = mysqli_real_escape_string($mysqli, $_POST['login_create']);
		$admin = intval($_POST['admin_create']);
		$query = "INSERT INTO users (login, passwd, admin) VALUES ( '" . $login . "', '" . hash('whirlpool', $_POST["passwd_create"]) . "', " . $admin . ");";

		mysqli_query($mysqli, $query) or die("Error : " . mysqli_error($mysqli));

		?>
		<p class="success">Compte cr&eacute;&eacute;.</p>
		<?php
	} else {
		echo '<p class="error">' . $error . '</p>';
	}

	mysqli_close($mysqli);
}

?>

<h4>Creation d'un compte utilisateur</h4>
<form action="?page=admin&view=user" method="post" autocomplete="off">
	<p>
		<label>Nom d'utilisateur</label><input type="text" name="login_create" placeholder="Username"/>
	</p>
	<p>
		<label>Mot de passe</label><input type="password" name="passwd_create" placeholder="Password"/>
	</p>
	<p>
		<label>Administrateur ?</label><input type="checkbox" name="admin_create" value="1"/>
	</p>
	<button type="submit">Creer l'utilisateur</button>
</form>
