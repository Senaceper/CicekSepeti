<?php
    session_start();

    include 'DB_Baglan.php';


    $sorgu="select * from user where EMAIL='".$_POST["email"]."' and PASSWORD = '".$_POST["password"]."'";
    $result=$mysql->query($sorgu);

    if($result->num_rows==1)
    {
        $row=$result->fetch_assoc();
        $_SESSION["USER_ID"]=$row["USER_ID"];
        header("Location: ./main.php");
    }else
        header("Location: ./index.php");
?>