<?php
session_start();
$error = '';

if (!empty($_SESSION['loggued_on_user'])) {
    redirect_to('?page=home');
}

if (isset($_POST["login"]) || isset($_POST["passwd"])) {
	if (empty($_POST["login"]) || empty($_POST["passwd"])) {
		$error = 'Tous les champs sont obligatoires.';
	}
	if (empty($error)) {
        $mysqli = db_connect();
        $login = mysqli_real_escape_string($mysqli, $_POST["login"]);
        $hash_pwd = hash('whirlpool', $_POST["passwd"]);

		$sql = "SELECT user_id, admin FROM users WHERE login='" . $login . "' AND passwd = '" . $hash_pwd . "' LIMIT 1";
		$res = mysqli_query($mysqli, $sql) or die("Error : " . mysqli_error($mysqli));
		if (mysqli_num_rows($res) !== 1) {
            $error = 'Mauvaise combinaison login/mot de passe.';
        } else {
            $row = mysqli_fetch_row($res);
            $_SESSION["loggued_on_user"] = $login;
            $_SESSION["user_id"] = $row[0];
            $_SESSION["is_admin"] = $row[1];
            mysqli_close($mysqli);
            redirect_to('?page=home');
        }
	}
}

if (!empty($error)) {
    echo '<div class="error">' . $error . '</div><br/>';
}
?>

<h4>Connexion</h4>
<form action="?page=login" method="post" id="login_form" class="user_form" autocomplete="off">
    <p>
        <label for="login_field" class="right_space">Nom d'utilisateur*</label>
        <input type="text" name="login" id="login_field" placeholder="Votre nom d'utilisateur" value="<?php echo $_POST['login'] ? $_POST['login'] : '' ?>" />
    </p>
    <p>
        <label for="passwd_field" class="right_space">Mot de passe*</label>
        <input type="password" name="passwd" id="passwd_field" placeholder="Votre mot de passe" />
    </p>
    <p>
        <button type="submit" name="submit">Se connecter</button>
    </p>
</form>

<p>
    <a href="?page=register">Pas encore de compte ? C'est par ici :]</a>
</p>

<script type="text/javascript">
    document.getElementById('login_field').focus();
</script>