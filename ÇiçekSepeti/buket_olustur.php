<?php
session_start(); ?>
<script>
    function olustur() {
        document.getElementById("buket_olustur_form").submit();
    }
    function cicek_cikar(F_ID,B_ID) {
        window.location.href="./buket_olustur.php?sil="+F_ID+"&bid="+B_ID;
    }
    
</script>


<?php
    include "DB_Baglan.php";
    include "ust_bar.html";

    if(isset($_GET["flower_select"]))
    {
        if(isset($_SESSION["BUKET_ID"])) {

            $sql2 = " insert into buket (BUKET_ID, FLOWER_ID, PIECE) 
            VALUES (" . $_SESSION["BUKET_ID"] . "," . $_GET['flower_select'] . "," . $_GET['adet'] . ")";
            $result2 = $mysql->query($sql2);
        }
        else{

            $sql2 = " insert into buket (FLOWER_ID, PIECE) 
            VALUES (" . $_GET['flower_select'] . "," . $_GET['adet'] . ")";
            $result2 = $mysql->query($sql2);
            $_SESSION["BUKET_ID"]=mysqli_insert_id($mysql);

        }
    }
    if(isset($_GET["sil"]))
    {


        $sql5="delete from buket where BUKET_ID = ".$_GET["bid"]." 
            and  FLOWER_ID = ".$_GET["sil"]." ";
        $result5=$mysql->query($sql5);

    }


    $store_sql="select * from store";
    $store_result=$mysql->query($store_sql);
    echo "<form action='buket_olustur.php' method='get' id='buket_olustur_form'> ";
    echo "<br><br>";
        $flower_sql="select * from flower";
        $flower_result=$mysql->query($flower_sql);
       echo"Çiçek Seçimi : "; echo "<select id='flower_select' name='flower_select'>";
            while($row=$flower_result->fetch_assoc())
                {
                 echo "<option value=".$row["FLOWER_ID"].">".$row["NAME"]."</option>";
                }
                 echo"</select>";
    echo"<br><br>";
    echo"Adet Seçimi"; echo "<input type='number' max='100' name='adet'>";
    echo"<br>"; echo "<input type='button' name='ekle' value='EKLE' onclick='olustur()'>";
    echo "<br><br>";


if(isset($_SESSION["BUKET_ID"]))
{
    $sql4=" select *,b.FLOWER_ID as BFLOWERID from buket b INNER JOIN flower f ON b.FLOWER_ID = f.FLOWER_ID
            where b.BUKET_ID = ".$_SESSION["BUKET_ID"]." ";
    $result4=$mysql->query($sql4);
    echo "<table><tr><th>Çiçek Adi</th>
                <th>Adedi</th></tr>";
    while($row=$result4->fetch_assoc()){
        echo "<tr><td>".$row["NAME"]."</td>";
        echo "<td>".$row["PIECE"]."</td>";
        echo "<td><button name='cikar' onclick='cicek_cikar(".$row["BFLOWERID"].",".$row["BUKET_ID"].")'>Çıkar</button> </td></tr>";
    }
    echo "</table>";


}
    echo "Hangi dükkana istek yollansın? : "; echo "<select id='store_select' name='store_select'>";
        while($row=$store_result->fetch_assoc())
        {
          echo "<option value=".$row["STORE_ID"].">".$row["STORE_NAME"]."</option>";
        }
    echo"</select>";
    echo "<br><br>";
echo "</form>";




    ?>


