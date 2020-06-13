<?php
session_start();
?>
<script>
    function bukete_ekle() {
        document.getElementById('cicek_ekle_form').submit();
    }
    function store_ekle() {
        document.getElementById('store_ekle_form').submit();
    }
    function store_guncel(B_ID) {
        var name = document.getElementsByName('s_name').item(0).value;
        var price= document.getElementsByName('s_price').item(0).value;
        var stock= document.getElementsByName('s_stock').item(0).value;
        var discount=document.getElementsByName('s_discount').item(0).value;
        window.location.href="./cicek_ekle.php?guncelle="+B_ID
            +"&name="+name+"&price="+price+"&stock="+stock+"&discount="+discount;
    }
    function cicek_sil(F_ID,B_ID)
    {
        window.location.href="./cicek_ekle.php?sil="+F_ID+"&bid="+B_ID;
    }
    function vazgec() {
        window.location.href="./urun_goruntu.php";
    }
</script>


<?php
include "ust_bar.html";
include "DB_Baglan.php";

if(isset($_GET["guncelle"]))
{
    $u_sql="update storeitem set NAME='".$_GET["name"]."', PRICE =".$_GET["price"].
            ", STOCK=".$_GET["stock"].", DISCOUNT =".$_GET["discount"]."  
            where BUKET_ID = ".$_GET["guncelle"]." ";
    $u_result=$mysql->query($u_sql);
    header("Location: ./urun_goruntu.php");
}

if(isset($_GET["degistir"]))
{
    $_SESSION["BUKET_ID"]=$_GET["degistir"];
}

if(isset($_GET["sil"]))
{
    $sql8="select * from storeitem WHERE BUKET_ID=".$_GET["bid"]." ";
    $result8=$mysql->query($sql8);
    $row8=$result8->fetch_assoc();

    $sql6="delete from storeitem where BUKET_ID = ".$_GET["bid"]." ";
    $result6=$mysql->query($sql6);

    $sql5="delete from buket where BUKET_ID = ".$_GET["bid"]." 
            and  FLOWER_ID = ".$_GET["sil"]." ";
    $result5=$mysql->query($sql5);

    $sql7="insert into storeitem (STORE_ID, BUKET_ID, NAME, PRICE, STOCK, DISCOUNT) 
            VALUES (".$row8["STORE_ID"].",".$row8["BUKET_ID"].",'".$row8["NAME"]."',
                    ".$row8["PRICE"]." , ".$row8["STOCK"].",".$row8["DISCOUNT"]." )";
    $result7=$mysql->query($sql7);

}
if(isset($_GET['f_select']))
{
    if(isset($_SESSION["BUKET_ID"])) {
        $sql2 = " insert into buket (BUKET_ID, FLOWER_ID, PIECE) 
            VALUES (" . $_SESSION["BUKET_ID"] . "," . $_GET['f_select'] . "," . $_GET['adet'] . ")";
        $result2 = $mysql->query($sql2);
    }
    else{
        $sql2 = " insert into buket (FLOWER_ID, PIECE) 
            VALUES (" . $_GET['f_select'] . "," . $_GET['adet'] . ")";
        $result2 = $mysql->query($sql2);
        $_SESSION["BUKET_ID"]=mysqli_insert_id($mysql);

    }
    //todo ekleni eklenmediğini kontrol et
}
else if (isset($_GET['s_name']))
{
    $sql3=" insert into storeitem (STORE_ID ,BUKET_ID, NAME, PRICE, STOCK, DISCOUNT)
            VALUES (".$_SESSION["CE_STORE_ID"].",".$_SESSION["BUKET_ID"].",'".$_GET['s_name']."',
             ".$_GET['s_price'].",".$_GET['s_stock'].",".$_GET['s_discount'].")";
    $result3=$mysql->query($sql3);
    header("Location: ./dukkan_goruntu.php");
}




if (isset($_GET["STORE_ID"]))
$_SESSION["CE_STORE_ID"]= $_GET["STORE_ID"];

$sql=" select * from flower ";
$result = $mysql->query($sql);

echo "<form action='cicek_ekle.php' method='get' id='cicek_ekle_form'> ";
    echo "<select id='flower_select' name='f_select'>";
while($row=$result->fetch_assoc())
{
            echo "<option value=".$row["FLOWER_ID"].">".$row["NAME"]."</option>";

}
echo"</select>";

echo "<input type='number' max='100' name='adet'>";
echo"<br><button name='ekle' onclick='bukete_ekle()' >Ekle</button>";
echo"<br><input type='button' name='vazgec' value='Vazgeç' onclick='vazgec()' >";



echo "</form>";

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
        echo "<td><button name='sil' onclick='cicek_sil(".$row["BFLOWERID"].",".$row["BUKET_ID"].")'>Sil</button> </td></tr>";
    }
    echo "</table>";


}

echo "<form action='cicek_ekle.php' method='get' id='store_ekle_form'> ";
echo  "Buket Adı : <input type='text' name='s_name'><br>";
echo  "Fiyatı    : <input type='number' name='s_price'><br>";
echo  "Stok sayısı : <input type='number' name='s_stock'><br>";
echo  "Indirim   : <input type='number' name='s_discount'>";


if(isset($_SESSION["BUKET_ID"]))
{
    $guncelle=" select * from storeitem WHERE BUKET_ID = ".$_SESSION["BUKET_ID"]." ";
    $r_guncelle=$mysql->query($guncelle);

    $row=$r_guncelle->fetch_assoc();
    echo "<script>  
                document.getElementsByName('s_name').item(0).value='".$row["NAME"]."';
                document.getElementsByName('s_price').item(0).value='".$row["PRICE"]."';
                document.getElementsByName('s_stock').item(0).value='".$row["STOCK"]."';
                document.getElementsByName('s_discount').item(0).value='".$row["DISCOUNT"]."';
                    </script>";

}

if(isset($_SESSION["BUKET_ID"]))
    echo"<br><input type='button' name='kaydet' onclick='store_ekle()' value='Kaydet'>";
else
    echo"<br><input type='button' name='guncelle' onclick='store_guncel(".$_SESSION["BUKET_ID"].")' value='Guncelle'>";

echo"<br><input type='button' name='vazgec' value='Vazgeç' onclick='vazgec()'>";
echo "</form>";







?>