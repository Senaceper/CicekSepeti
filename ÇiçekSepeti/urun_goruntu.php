<?php
session_start();
?>
<script>
    function degistir(B_ID) {
        window.location.href="./cicek_ekle.php?degistir="+B_ID;
    }
    function sil(B_ID) {
        window.location.href="./urun_goruntu.php?sil="+B_ID;
    }


</script>

<?php

include "ust_bar.html";
include "DB_Baglan.php";

if(isset($_GET["STORE_ID"]))
    $_SESSION["STR_ID"]=$_GET["STORE_ID"];

if(isset($_GET["sil"]))
{
    $sql1="delete from storeitem where BUKET_ID = ".$_GET["sil"]." ";
    $result1=$mysql->query($sql1);
}

$sql=" select * from store st INNER JOIN storeitem s ON st.STORE_ID = s.STORE_ID 
        WHERE st.STORE_ID = ".$_SESSION["STR_ID"]." ";
$result=$mysql->query($sql);


echo "<table><tr><th>Buket Adi</th>
                <th>Fiyati</th>
                <th>Stok Sayisi</th>
                <th>İndirimi</th></tr>";
while($row=$result->fetch_assoc()){
    echo "<tr><td>".$row["NAME"]."</td>";
    echo "<td>".$row["PRICE"]."</td>";
    echo "<td>".$row["STOCK"]."</td>";
    echo "<td>".$row["DISCOUNT"]."</td>";
    echo "<td><button name='degistir' onclick='degistir(".$row["BUKET_ID"].")'>Güncelle</button> </td>";
    echo "<td><button name='sil' onclick='sil(".$row["BUKET_ID"].")'>Sil</button> </td></tr>";
}
echo "</table>";


?>