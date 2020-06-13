<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Sena
 * Date: 1.01.2018
 * Time: 19:11
 */
include 'DB_Baglan.php';
$sql="insert into user (NAME, SURNAME, EMAIL, PASSWORD) 
VALUES ('".$_POST["isim"]."','".$_POST["soyisim"]."','".$_POST["email"]."','".$_POST["password"]."')";

$result=$mysql->query($sql);

if($result)
{
    $sorgu="select * from user where EMAIL='".$_POST["email"]."' and PASSWORD = '".$_POST["password"]."'";
    $result1=$mysql->query($sorgu);

    if($result1->num_rows==1)
    {
        $row=$result1->fetch_assoc();
        $_SESSION["USER_ID"]=$row["USER_ID"];
        header("Location: ./main.php");
    }else
        header("Location: ./index.php");

}
else
    header("Location: ./index.php");





?>