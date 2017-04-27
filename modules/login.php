<?php
session_start();

if (!empty($_SESSION["loggued_on_user"]))
{
?>

<div id="account_buttons">
    <span class="right_space">Bienvenue, <?php echo $_SESSION["loggued_on_user"]; ?> !</span>
    <a href="?page=profile" class="right_space">Mon compte</a>
    <?php
    if ($_SESSION['is_admin']) {
        ?>
        <a href="?page=admin" class="right_space">Panneau admin</a>
        <?php
    }
    ?>
    <a href="?page=logout">Se deconnecter</a>
</div>

<?php } else { ?>

<div id="account_buttons">
    <a href="?page=login" class="right_space">Se connecter</a>
    <a href="?page=register">S'enregistrer</a>
</div>

<?php } ?>