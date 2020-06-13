<?php
session_start();
?>
<script>
    function cicek_ekle(STORE_ID) {
        window.location.href='./cicek_ekle.php?STORE_ID='+STORE_ID;
    }
    function urun_goruntu(STORE_ID) {
        window.location.href='./urun_goruntu.php?STORE_ID='+STORE_ID;
    }

</script>



<?php

include "DB_Baglan.php";
include "ust_bar.html";
$array=array();


$sorgu=" select * from userstore us
 inner join store s ON us.STORE_ID = s.STORE_ID 
 where USER_ID =".$_SESSION["USER_ID"]." ";
$result=$mysql->query($sorgu);

echo "<table>
 <tr>
            <th>Dükkan Adı</th>
            <th>Bulunduğu Şehir</th>
            </tr>";
while($row = $result->fetch_assoc())
{
    echo "<tr>
            <td>".$row["STORE_NAME"]."</td>
            <td>".$row["STORE_CITY"]."</td>
            <td><button onclick='cicek_ekle(".$row["STORE_ID"].")' >Çiçek Ekle</button></td>
            <td><button onclick='urun_goruntu(".$row["STORE_ID"].")' >Urün Görüntüle</button></td>
           
            </tr>";

}
   echo " </table>";




?>