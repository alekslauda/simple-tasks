<!DOCTYPE html 
      PUBLIC "-//W3C//DTD HTML 4.01//EN"
      "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en-US">
    <head profile="http://www.w3.org/2005/10/profile">
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="http://example.com/myicon.png">
        <link href="<?=ASSETS_ROOT?>/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="<?=ASSETS_ROOT?>/css/style.css" rel="stylesheet">
        <link href="<?=ASSETS_ROOT?>/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="<?=ASSETS_ROOT?>/js/html5.js"></script>
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <div class="nav-collapse">
                        <ul class="nav">
                            <?php if($this->view->isUserLogged) : ?>
                            <li class="active"><a href="<?=PROJECT_URL; ?>Index">Home</a></li>
                            <li class="active"><a href="<?=PROJECT_URL; ?>Authentication/Logout">Logout</a></li>
                            <?php else: ?>
                            <li class="active"><a href="<?=PROJECT_URL; ?>Authentication/Login">Login</a></li>
                            <li class="active"><a href="<?=PROJECT_URL; ?>Authentication/Register">Register</a></li>
                            <?php endif; ?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container">
            <?php echo $this->renderTemplate($this->view->template); ?>
            <hr>
            <footer>
                
            </footer>
        </div> <!-- /container -->
    </body>
</html>
