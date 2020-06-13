<?php
session_start();
?>
<html>
<head>
    <title>Anasayfa</title>
</head>
<body>
    <?php
        if (isset($_SESSION["USER_ID"]))
        {
            header("Location: ./main.php");
        }
    ?>

    <form name="giris_yap" method="POST"  action="Giris_Kontrol.php" >
        <fieldset>
            <legend><h2>Giriş Yap</h2></legend>
            E-posta : <input type="email" name="email">
     <br>   Şifre   : <input type="password" name="password">
     <br>   <input type="submit" name="Giris_Yap" value="Giriş Yap">
        </fieldset>
    </form>

    <br>
    <br>

   <form name="kayit_ol" method="POST" action="Kayit_Ol.php"   >
       <fieldset>
           <legend><h2>Kayıt Ol</h2></legend>
                  Isim    : <input type="text" name="isim">
           <br>   Soyisim : <input type="text" name="soyisim">
           <br>   E-posta : <input type="email" name="email">
           <br>   Şifre   : <input type="password" name="password">

           <br>   <input type="submit" name="Kayıt Ol" value="Kayıt Ol">
       </fieldset>



   </form>




</body>
</html>






