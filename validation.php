<?php
include 'inc/startup.php';

$errorHandler = new errorhandler;

if(!empty($_POST)){
    $validator = new validator($errorHandler);
    
    $validation = $validator->check($_POST, [
        'username' => [
            'required' => true,
            'minlength' => 3,
            'maxlength' => 30,
            'alnum' => true,
        ],
        'email' => [
            'required' => true,
            'maxlength' => 255,
            'email' => true,
        ],
        'password' => [
            'required' => true,
            'minlength' => 6,
        ],
        'repassword' => [
            'required' => true,
            'minlength' => 6,
        ]
    ]);
    if($validation->fails()){
         echo '<pre>', print_r($validation->errors()->all()), '</pre>';
    }
    
}

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Form Validation test</title>
        <link rel="stylesheet" href="css/gumby.css"> 
	<script src="js/libs/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <div class="row">
            <div class="six columns">
                <form action="validation.php" method="post">

                    <div class="field">
                        <input class="wide input" type="email" name="email" placeholder="Email" autofocus>
                    </div>

                    <div class="field">
                        <input class="wide input" type="password" name="password" placeholder="Password">
                    </div>

                    <div class="field">
                        <input class="wide input" type="password" name="repassword" placeholder="Repeat password">
                    </div>
                    
                    <div class="append field">
                        <input class="wide input" type="text" name="username" placeholder="Username">
                        <div class="medium primary btn">
                            <input type="submit">
                        </div>
                    </div>

                    

                </form>
            </div>
        </div>
        
        <!-- Grab Google CDN's jQuery, fall back to local if offline -->
	<!-- 2.0 for modern browsers, 1.10 for .oldie -->
	<script>
	var oldieCheck = Boolean(document.getElementsByTagName('html')[0].className.match(/\soldie\s/g));
	if(!oldieCheck) {
	document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"><\/script>');
	} else {
	document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"><\/script>');
	}
	</script>
	<script>
	if(!window.jQuery) {
	if(!oldieCheck) {
	  document.write('<script src="js/libs/jquery-2.0.2.min.js"><\/script>');
	} else {
	  document.write('<script src="js/libs/jquery-1.10.1.min.js"><\/script>');
	}
	}
	</script>

	<script gumby-touch="js/libs" src="js/libs/gumby.js"></script>
	<script src="js/libs/ui/gumby.retina.js"></script>
	<script src="js/libs/ui/gumby.fixed.js"></script>
	<script src="js/libs/ui/gumby.skiplink.js"></script>
	<script src="js/libs/ui/gumby.toggleswitch.js"></script>
	<script src="js/libs/ui/gumby.checkbox.js"></script>
	<script src="js/libs/ui/gumby.radiobtn.js"></script>
	<script src="js/libs/ui/gumby.tabs.js"></script>
	<script src="js/libs/ui/gumby.navbar.js"></script>
	<script src="js/libs/ui/jquery.validation.js"></script>
	<script src="js/libs/gumby.init.js"></script>

	<script src="js/plugins.js"></script>
	<script src="js/main.js"></script>
    </body>
</html>