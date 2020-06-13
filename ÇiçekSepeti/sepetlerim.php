<?php session_start() ?>
<script>
    function s_onayla() {

        window.location.href='./sepetlerim.php?basket_onay='+'<?php echo $_SESSION["BASKET_ID"]; ?>' ;
    }
    function s_temizle() {
        window.location.href='./sepetlerim.php?basket_temizle='+'<?php echo $_SESSION["BASKET_ID"]; ?>';

    }
</script>

<?php
include "DB_Baglan.php";
include "ust_bar.html";


if(isset($_GET['basket_onay']))
{
    $sql2=" select * from basket b 
              INNER JOIN storeitem si ON b.BUKET_ID=si.BUKET_ID 
              where b.BASKET_ID = ".$_GET['basket_onay']." ";
    $result2=$mysql->query($sql2);
    $toplam=0;
    while ($t_fiyat=$result2->fetch_assoc()){
        $toplam += $t_fiyat["PIECE"]*($t_fiyat["PRICE"]-($t_fiyat["PRICE"]*($t_fiyat["DISCOUNT"]/100)));
    }

    $sql=" insert into islemler (BASKET_ID, ISLEM_TARIHI,T_PRICE)
            VALUES ( ".$_GET['basket_onay'].", CURDATE(),".$toplam." )";

    $result=$mysql->query($sql);
    header("Location: ./main.php");
}

if(isset($_GET['basket_temizle']))
{
    $sql=" delete from basket where BASKET_ID = ".$_GET["basket_temizle"];
    $result=$mysql->query($sql);
    header("Location: ./main.php");
}


$sql=" select * from basket b INNER JOIN storeitem si 
        ON si.BUKET_ID=b.BUKET_ID  where USER_ID = ".$_SESSION['USER_ID']." order by BASKET_ID ";
$result=$mysql->query($sql);



echo "<table> <tr><th>Buket Adı</th><th>Adedi</th></tr>";
 while($row=$result->fetch_assoc())
 {
     echo "<tr><td>".$row["NAME"]."</td>
                <td><input type='text' value=".$row["PIECE"]."></td></tr>";
     $_SESSION["BASKET_ID"]=$row["BASKET_ID"];
 }

echo "<tr><td><button onclick='s_onayla()'>Sepeti Onayla</button></td>
          <td><button onclick='s_temizle()'>Sepeti Temizle</button></td></tr>";
echo "</table>";



?>





