<?php
session_start();
$mysqli = db_connect();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== '1') {
    redirect_to('?page=home');
}

?>

    <p><a href="?page=admin&view=user">Administrer les utilisateurs</a></p>
    <p><a href="?page=admin&view=cat">Administrer les categories</a></p>
    <p><a href="?page=admin&view=product">Administrer les articles</a></p>

<?php

if (isset($_GET['view'])) {
    if ($_GET['view'] === 'user') {
        ?>
        <div>
            <div class="admin_form user_form">
                <?php include ('admin_create.php'); ?>
            </div>

            <div class="admin_form user_form">
                <?php include ('admin_modif.php'); ?>
            </div>
        </div>

        <div>
            <div class="admin_form user_form">
                <?php include ('admin_sudoer.php'); ?>
            </div>

            <div class="admin_form user_form">
                <?php include ('admin_delete.php'); ?>
            </div>
        </div>
        <?php

    }

    if ($_GET['view'] === 'cat') {
        ?>
        <div>
            <div class="admin_form user_form">
                <?php include('modules/admin_add_category.php'); ?>
            </div>
            <div class="admin_form user_form">
                <?php include('modules/admin_modif_category.php'); ?>
            </div>
        </div>


        <div>
            <div class="admin_form user_form">
                <?php include('modules/admin_delete_category.php'); ?>
            </div>
        </div>
        <?php
    }

    if ($_GET['view'] === 'product') {
        ?>
        <div>
            <div class="admin_form user_form">
                <?php include ('admin_add_article.php'); ?>
            </div>

            <div class="admin_form user_form">
                <?php include ('admin_del_prod.php'); ?>
            </div>
        </div>
        <?php
    }
}
?>