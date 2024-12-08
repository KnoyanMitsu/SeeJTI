<?php


session_start();
if ($_SESSION['id_user']) {
    echo "berhasil";
    if($_SESSION['level'] === "admin"){
        echo "admin";
        return;
    }else{
        return;
    }
}else{
    echo "gagal";
    return;
}
?>
