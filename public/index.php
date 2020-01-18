<?php
require_once '../vendor/autoload.php';

use App\User;



$user = User::find(2);
//$user->update();
//$user->insert();
//$user->delete();
echo $user->getId();
echo '<br>';
echo $user->getEmail();





