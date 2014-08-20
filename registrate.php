<?php
/* @var $VIS display */
/* @var $settings settings */
require './inc/startup.php';

if(isset($_POST['submitted']) && $_POST['submitted'] == 1){
    $user = [];
    
    $user['email'] = $_POST['email'];
    $user['fname'] = $_POST['fname'];
    $user['lname'] = $_POST['lname'];
    $user['username'] = $_POST['username'];
    $user['password'] = $_POST['password'];
}
$VIS->addBCpath('registrate.php', 'Registration', 'This is where you can create a new user');
$VIS->activateBC();
include HTML_START;
?>
<div class="six columns">
    <form action="registrate.php" method="post">
        <div class="field">
            <input class="input" type="text" name="email" value="" placeholder="Email" /> <br>
        </div>
        <div class="field">
            <input class="input" type="text" name="fname" value="" placeholder="First Name" /> <br>
        </div>
        <div class="field">
            <input class="input" type="text" name="lname" value="" placeholder="Last Name" /> <br>
        </div>
        <div class="field">
            <input class="input" type="text" name="username" value="" placeholder="Username" /> <br>
        </div>
        <div class="field">
            <input class="input" type="password" name="password" value="" placeholder="Password" /> <br>
        </div>
        <div class="field">
            <input class="input" type="password" name="repassword" value="" placeholder="Repeat password" /> <br>
        </div>
        <div class="medium secondary btn">
            <input type="submit" value="Registrate" name="submit" />    
        </div>
        <input type="hidden" name="submitted" value="1" />
    </form>
</div>