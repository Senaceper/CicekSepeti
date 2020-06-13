<?php session_start(); ?>
<?php

include 'DB_Baglan.php';
include "ust_bar.html";
if(isset($_POST["name"])) {
    $sql = "INSERT INTO store (STORE_NAME, STORE_CITY) VALUES ('" . $_POST["name"] . "', '" . $_POST["city"] . "')";
    $result = $mysql->query($sql);

    if ($result) {
        $_SESSION["STORE_ID"] = mysqli_insert_id($mysql);
        $sorgu2 = "INSERT INTO userstore (USER_ID, STORE_ID) VALUES ('" . $_SESSION["USER_ID"] . "','" . $_SESSION["STORE_ID"] . "')";
        $result2 = $mysql->query($sorgu2);
        header("Location: ./main.php");
    }
}
?>
<html>
<head>
    <title>Dükkan Ekle</title>
</head>
<body>

<form action="dukkan_ekle.php" method="post">
    Dükkan ismini giriniz               : <input type="text" name="name" ><br>
    Dükkanınız hangi şehirde bulunuyor? : <input type="text" name="city" ><br>
    <input type="submit" name="Dükkanımı_Olustur" value="Dükkanımı Oluştur" >



</form>

</body>

</html>

