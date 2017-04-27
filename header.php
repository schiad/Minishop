<div id="upper_header">
    <div id="home_link">
        <a href="?page=home">Page d'accueil</a>
    </div>

    <?php include './modules/login.php'; ?>
</div>

<div id="lower_header">
    <div id="logo">
        <img height="75" src="img/logo2.png" alt="logo" />
    </div>
    <div id="header_panier">
        <?php include './modules/panier.php' ?>
    </div>
    <div id="searchbar_block">
        <input type="text" id="searchbar" placeholder="Rechercher un produit"/>
        <button type="button">Rechercher</button>
    </div>
</div>