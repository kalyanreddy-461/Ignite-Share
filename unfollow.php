<?php
require_once "pdo.php";
if (isset($_POST['username'])){
   $sql = "delete from follower where username='".$_POST['username']."' and followername='".$_SESSION['name']."'";
   $stmt = $pdo->prepare($sql);
   $stmt->execute();
   $d="profiles.php?name=".$_POST['username'];
    header("Location:$d");}


if (isset($_GET['name'])){
   $sql = "delete from follower where username='".$_GET['name']."' and followername='".$_SESSION['name']."'";
   $stmt = $pdo->prepare($sql);
   $stmt->execute();
   $d="following.php";
    header("Location:$d");

}

?>
