<?php

include("db.connect.php");
include("structure/header.php");
include("structure/navbar.php");

$sql = 'DELETE FROM category WHERE `category`.`category_id` = ' . $_GET['category_id'];
$result = mysqli_query($conn, $sql);

if ($_SESSION['role'] == '2') {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo "<script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'ทำรายการสำเร็จ',
            showConfirmButton: false,
            timer: 2000 })
            </script>";
    header("Refresh:2; url=category_admin.php");
} 
?>
