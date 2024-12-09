<?php


session_start();
if ($_SESSION['id_user']) {
    if($_SESSION['level'] === "Admin"){
        echo "admin";
    }else if($_SESSION['level'] === "Ketua"){
        echo "ketua";
    }else if($_SESSION['level'] === "Mahasiswa"){
        echo "mahasiswa";
    }
    else{
        echo "gagal";
    }
}else{
    echo "gagal";
    return;
}
?>
