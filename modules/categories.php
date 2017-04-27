<?php

$mysqli = db_connect();

$res = mysqli_query($mysqli, 'SELECT * FROM categories ORDER BY name') or die("Error : " . mysqli_error($mysqli));
echo '<ul>';
while ($cat = mysqli_fetch_array($res)) {
    echo '<li class="category_link">    <a href="?page=products&cat=' . $cat['category_id'] . '&cat_name=' . urlencode($cat['name']) . '"> ' . $cat['name'] . '</a>   </li>';
}
echo '<li class="category_link">    <a href="?page=products">Tous les produits</a>   </li>';
echo '</ul>';

mysqli_close($mysqli);