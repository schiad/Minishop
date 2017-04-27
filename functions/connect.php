<?php

function db_connect() {
    $mysqli = mysqli_connect('localhost', 'root', 'PASSWORD', 'ft_minishop', 3306);
    if (mysqli_connect_errno()) {
        die('Failed to connect to MySQL: (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
    return $mysqli;
}
