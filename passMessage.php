<?php
    require 'functions.php';
    checksession();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" type="x-icon" href="img/IP market white round.png">
        <title>Isuru Pradeep</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="My-protfolio">
        <meta name="author" content="Isuru">
        <link rel="stylesheet" href="style2.css">
    </head>
    <body>
        <div class="container">
            <div class="item header">
                <div id="logo-div">
                    <img id="logo" src="img/IP market white round.png" alt="Logo">
                </div>
                
                <div id="header-nav">
                <nav>
                    <ul>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </nav>
                </div>
                <div id="hero-title">
                    <h1 >Igniting Imagination</h1>
                </div>
            </div>
            <!-- <div class="item left-bar">

            </div> -->
            <div class="item content">
                <div>
                  <p>Hello <b><?= htmlspecialchars($_SESSION["First_Name"]." ".$_SESSION["Last_Name"])?></b> !</p>

                    <h2>Pass your things</h2>
                    <br>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <p>Enter your meassage</p>
                        <textarea name="Message" id="message" cols="30" rows="10"></textarea>
                        <input type="text" name="URL" placeholder="Enter attachment URL">
                        <?php
                        validateMessageForm();
                        ?>
                        <button type="submit">send</button>
                    </form>

                    <?php
                    prevMessages();
                    ?>
                    
                </div>
            
            </div>

            <div class="item footer">
                <div class="row">
                    <div class="contact-left">
                        <p>pradeepisuru31@gmail.com</p>
                        <p>+9476 666 4562</p>
                    </div>
                    <div class="contact-right">
                        <div class="icon" id="footer-nav-logo">
                            <nav >
                                <ul>
                                  <li><a href="https://www.facebook.com/isuru.pradeep.370?mibextid=LQQJ4d" target="_blank"><img src="img/facebook.png" alt="facebook"></a></li>
                                  <li><a href="#instagram"><img src="img/instagram.png" alt="instagram"></a></li>
                                  <li><a href="#li"><img src="img/li.png" alt="linkdin"></a></li>
                                  <li><a href="https://wa.me/+94766664562" target="_blank"><img src="img/whatsapp.png" alt="whatsapp"></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
           
        </div>

    </body>
</html>