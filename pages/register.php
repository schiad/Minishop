<?php
session_start();

if (!empty($_SESSION['loggued_on_user'])) {
	redirect_to('?page=home');
}

if (isset($_POST["login"]) || isset($_POST["passwd"]) || isset($_POST["passwd2"])) {
	$error = '';
	$login = $_POST["login"];
	$passwd = $_POST["passwd"];
	$passwd2 = $_POST["passwd2"];
	if (empty($login) || empty($passwd) || empty($passwd2)) {
		$error = 'Tous les champs sont obligatoires.';
	}
	else if ($passwd !== $passwd2) {
		$error = 'Les deux mots de passe ne correspondent pas.';
	}
	else if (!preg_match('/^[A-Za-z0-9]+$/', $login)) {
		$error = 'Votre nom d\'utilisateur ne peut contenir que des chiffres et des lettres.';
	}
	if (empty($error)) {
		$mysqli = db_connect();
		$login = mysqli_real_escape_string($mysqli, $_POST["login"]);
		$hash_pwd = hash('whirlpool', $_POST["passwd"]);

		$sql = "SELECT * FROM users WHERE login='" . $login . "' LIMIT 1";
		$res = mysqli_query($mysqli, $sql) or die("Error : " . mysqli_error($mysqli));
		if (mysqli_num_rows($res) > 0) {
			$error = 'Nom d\'utilisateur déjà existant';
		} else {
			$sql = "INSERT INTO users (login, passwd) VALUES ( '" . $login . "', '" . $hash_pwd . "');";
			$res = mysqli_query($mysqli, $sql) or die("Error : " . mysqli_error($mysqli));
			mysqli_close($mysqli);
			$_SESSION["loggued_on_user"] = $login;
			redirect_to('?page=home');
		}
	}
}

if (!empty($error)) {
	echo '<div class="error">' . $error . '</div><br/>';
}
?>

<h4>Création de votre compte</h4>
<form action="?page=register" method="post" id="register_form" class="user_form" autocomplete="off">
	<p>
		<label for="login_field" class="right_space" >Nom d'utilisateur*</label>
		<input type="text" name="login" id="login_field" placeholder="Votre nom d'utilisateur" value="<?php echo $_POST['login'] ? $_POST['login'] : '' ?>" />
	</p>
	<p>
		<label for="passwd_field" class="right_space">Mot de passe*</label>
		<input type="password" name="passwd" id="passwd_field" placeholder="Votre mot de passe" />
	</p>
	<p>
		<label for="passwd_field" class="right_space">Confirmez le mot de passe*</label>
		<input type="password" name="passwd2" id="passwd_field" placeholder="Confirmation de votre mot de passe" />
	</p>
	<p>
		<button type="submit" name="submit">S'enregistrer</button>
	</p>
</form>

<p>
	<a href="?page=login">Déjà enregistré ? Connectez-vous ici.</a>
</p>

<script type="text/javascript">
	document.getElementById('login_field').focus();
</script>