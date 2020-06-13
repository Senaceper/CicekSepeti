<?php
session_start();
include 'DB_Baglan.php';
?>
<script>
    function sepete_ekle(B_ID)
    {
        window.location.href="./main.php?spte="+B_ID;

    }
</script>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
include "ust_bar.html";
if(isset($_GET['spte'])) {
    if (isset($_SESSION["BASKET_ID"])) {
        $sql3 = "INSERT INTO basket ( BASKET_ID ,BUKET_ID, USER_ID, PIECE) 
            VALUES (".$_SESSION["BASKET_ID"]." ," . $_GET['spte'] . "," . $_SESSION['USER_ID'] . ",1)";
        $result3 = $mysql->query($sql3);
    }
    else{
        $sql3 = "INSERT INTO basket (BUKET_ID, USER_ID, PIECE) 
            VALUES (" . $_GET['spte'] . "," . $_SESSION['USER_ID'] . ",1)";
        $result3 = $mysql->query($sql3);
        $_SESSION["BASKET_ID"]=mysqli_insert_id($mysql);
    }
}
$sql=" select * from store st INNER JOIN storeitem s ON st.STORE_ID = s.STORE_ID";
$result=$mysql->query($sql);
$i=0;

echo "<table><tr>";
while($i<3) {
    while ($row = $result->fetch_assoc()) {
        echo "<td>";
        echo "<table>";
        echo "<tr><th>" . $row['NAME'] . "</th></tr>";

        $sql2 = " SELECT * FROM buket b INNER JOIN flower f ON b.FLOWER_ID = f.FLOWER_ID
  WHERE BUKET_ID = " . $row['BUKET_ID'] . " ";

        $result2 = $mysql->query($sql2);
        echo "<tr> <td><h4>Çiçek</h4> </td> <td><h4>Adedi</h4> </td> </tr>";
        while ($row2 = $result2->fetch_assoc()) {
            echo "<tr><td> " . $row2['NAME'] . " </td>
                <td> " . $row2['PIECE'] . " </td></tr>";
        }
        echo "<tr><td>" . $row["PRICE"] . " TL </td>
            <td>Indirimi  : % " . $row["DISCOUNT"] . "</td>
            <td><button name='s_ekle' onclick='sepete_ekle(" . $row['BUKET_ID'] . ")'>Sepete Ekle</button></td></tr>";

        echo "</table> </td>";
    }
    echo "</tr></table>";
    $i++;
}
?>

</body>
</html>

