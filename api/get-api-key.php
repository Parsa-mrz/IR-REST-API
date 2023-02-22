<!-- Access for admins -->
<div style="width:50%;margin:50px auto;line-height:36px;zoom:2">
<form action="" method="post">
    <input type="email" name="email" placeholder="email">
    <input type="submit" name="submit" value="Generate Token">
</form>

<?php 
include_once("../loader.php");
if($_SERVER['REQUEST_METHOD'] !== "POST"){
    die();
}
$email = $_POST['email'];
$user = getUserByEmail($email);
if(is_null($user)){
    die('User Not Exist!!');
}
$jwt = createApiToken($user);
echo "jwt token for $user->name : <br><textarea style='width:100%'> $jwt </textarea>"
?>
</div>