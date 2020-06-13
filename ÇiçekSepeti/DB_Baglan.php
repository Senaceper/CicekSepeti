<?php
    $mysql= new mysqli("localhost","root","","ciceksepeti");
    if($mysql->connect_errno)
    {
         die("Connect Error : ".$mysql->connect_errno);
    }
?>