<?php

function sql_select_from_array($link, $arr, $what, $from, $where, $type) {
    $in = join(',', array_fill(0, count($arr), '?'));
    $sql = 'SELECT ' . $what . ' FROM ' . $from . ' WHERE ' . $where .'  IN (' . $in . ')';
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, str_repeat($type, count($arr)), ...$arr);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}