<?php
session_start();

if (empty($_SESSION['loggued_on_user'])) {
    redirect_to('?page=home');
}

if (isset($_POST["passwd"]) || isset($_POST["passwd2"])) {
    $error = '';
    $passwd = $_POST["passwd"];
    $passwd2 = $_POST["passwd2"];

    if (empty($passwd) || empty($passwd2)) {
        $error = 'Tous les champs sont obligatoires.';
    }

    if (empty($error)) {
        $mysqli = db_connect();
        $hash_pwd = hash('whirlpool', $_POST["passwd"]);
        $hash_pwd2 = hash('whirlpool', $_POST["passwd2"]);

        $sql = "SELECT user_id FROM users WHERE login='" . $_SESSION['loggued_on_user'] . "' AND passwd='" . $hash_pwd . "' LIMIT 1";
        $res = mysqli_query($mysqli, $sql) or die("Error : " . mysqli_error($mysqli));
        if (mysqli_num_rows($res) === 0) {
            $error = 'Mot de passe incorrect.';
        } else {
            $sql = "UPDATE users SET passwd='" . $hash_pwd2 . "' WHERE login='" . $_SESSION['loggued_on_user'] . "'";
            $res = mysqli_query($mysqli, $sql) or die("Error : " . mysqli_error($mysqli));
            mysqli_close($mysqli);
            echo '<div class="success">Mot de passe modifié avec succès.</div><br/>';
        }
    }

    if (!empty($error)) {
        echo '<div class="error">' . $error . '</div><br/>';
    }
}
?>

<h4>Modifier votre mot de passe</h4>
<form action="?page=profile" method="post" class="user_form profile_form" autocomplete="off">
    <p>
        <label for="passwd_field">Mot de passe actuel</label>
        <input type="password" name="passwd" id="passwd_field" placeholder="Mot de passe actuel" />
    </p>
    <p>
        <label for="passwd_field">Nouveau mot de passe</label>
        <input type="password" name="passwd2" id="passwd_field" placeholder="Nouveau mot de passe" />
    </p>
    <p>
        <button type="submit" name="submit">Modifier</button>
    </p>
</form>

<br/>

<?php
if (isset($_POST['action']) && $_POST['action'] === 'del') {
    $co = db_connect();

    $hash_pwd = hash('whirlpool', $_POST['del_passwd']);

    $query = 'DELETE FROM users WHERE login = "' . $_SESSION['loggued_on_user'] . '" AND passwd = "' . $hash_pwd . '"';

    $result = mysqli_query($co, $query) or die("Error : " . mysqli_error($co));
    if (mysqli_affected_rows($co) > 0) {
        mysqli_close($co);
        logout();
        redirect_to('?page=home');
    } else {
        $error = 'Mot de passe incorrect.';
    }
    mysqli_close($co);

    if (!empty($error)) {
        echo '<div class="error">' . $error . '</div><br/>';
    }
}
?>

<h4>Supprimer votre compte</h4>
<form action="?page=profile" method="post" class="user_form profile_form" >
    <p>
        <label for="del_passwd" class="right_space">Mot de passe actuel</label>
        <input type="password" name="del_passwd" id="del_passwd" placeholder="Votre mot de passe actuel" />
    </p>
    <input type="hidden" name="action" value="del" />
    <button type="submit" id="del_account_btn" name="delete">Supprimer mon compte</button>
</form>

<script type="text/javascript">
    document.getElementById('passwd_field').focus();
</script>