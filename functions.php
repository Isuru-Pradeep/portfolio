<?php
    function registerFormDataVakidationAndPassData(){
    // Initialize variables to store form data and error messages
    $fname =$mname =$lname = $email =$pword = "";
    $fnameErr =$mnameErr =$lnameErr = $emailErr =$pwordErr = "";
    $flage1 = $flage2 = $flage3 =$flage4 = $flage5 = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Function to sanitize input data
        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Validate and sanitize name
            if (empty($_POST["FirstName"])) {
                $fnameErr = "First Name is required";
            } else {
                $fname = sanitize_input($_POST["FirstName"]);
                if (!preg_match("/^[a-zA-Z ]*$/", $fname)) {
                    $fnameErr = "Only letters and spaces are allowed for First name";
                }
                else{
                    $flage1 = 1;
                }
            }
        

            if (empty($_POST["LastName"])) {
                $lnameErr = "Last Name is required";
            } else {
                $lname = sanitize_input($_POST["LastName"]);
                if (!preg_match("/^[a-zA-Z ]*$/", $lname)) {
                    $lnameErr = "Only letters and spaces are allowed for Last name";
                }
                else{
                    $flage2 = 1;
                }
            }


            if (empty($_POST["MiddleName"])) {
                $mnameErr = "Middle Name is required";
            } else {
                $mname = sanitize_input($_POST["MiddleName"]);
                if (!preg_match("/^[a-zA-Z ]*$/", $mname)) {
                    $mnameErr = "Only letters and spaces are allowed for Middle name";
                }
                else{
                    $flage3 = 1;
                }
            }


        // Validate and sanitize email
        if (empty($_POST["Email"])) {
            $emailErr = "Email is required";
        } else {
            $email = sanitize_input($_POST["Email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
            else{

                $host = "localhost";
                $dbname = "portfolio";
                $username ="root";
                $password = "";

                $conn = mysqli_connect($host,$username,$password,$dbname);

                if (mysqli_connect_errno()) {
                    echo "Connection unsuccessful";
                    die("Connection error:".mysqli_connect_error());
                }

                $sql = "SELECT * FROM users WHERE Email ='$email';";

                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($result);

                if (mysqli_num_rows($result)>0) {

                $emailErr = "Email already taken";

                }else{
                $flage4 = 1;

                }
            }
        }

        
        // Validate password
        if (empty($_POST["PassWord"])) {
            $pwordErr = "Password is required";
        } else {
            $pword = sanitize_input($_POST["PassWord"]);
            $hashedPwd = password_hash( $pword,PASSWORD_DEFAULT);
            $flage5 = 1;

            // echo password_verify($pword,$hashedPwd);
        }

    }
    if($flage1 == 1 &&$flage2 == 1 &&$flage3 == 1&&$flage4 == 1 &&$flage5 == 1){

        $host = "localhost";
        $dbname = "portfolio";
        $username ="root";
        $password = "";

        $conn = mysqli_connect($host,$username,$password,$dbname);

        if (mysqli_connect_errno()) {
            echo "Connection unsuccessful";
            die("Connection error:".mysqli_connect_error());
        }

        $sql = "INSERT INTO `users` (`Email`,`First_Name`, `Last_Name`,`Middle_Name`,`Password`) VALUES ('$email', '$fname','$lname', '$mname', '$hashedPwd');";
        $result = mysqli_query($conn,$sql);

        // echo "<h1>done</h1>";
        header('Location: index.html');
        exit();
    }
    else{
    echo "<h2 style='color : red;'>$fnameErr <br>$mnameErr <br>$lnameErr<br>$emailErr <br>$pwordErr<h2>";
    }   

}

function loginFormDataValidationAndPassData(){
        // Initialize variables to store form data and error messages
        $email =$pword = "";
        $emailErr =$pwordErr = "";
        $flage1 = $flage2 = 0;
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Function to sanitize input data
            function sanitize_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
    
            
            // Validate and sanitize email
            if (empty($_POST["Email"])) {
                $emailErr = "Email is required";
            } else {
                $email = sanitize_input($_POST["Email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                }
                else{
                    $flage1 = 1;
                }
            }
    
            
            // Validate password
            if (empty($_POST["PassWord"])) {
                $pwordErr = "Password is required";
            } else {
                $pword = sanitize_input($_POST["PassWord"]);
                $flage2 = 1;
    
            }
    
        }


        if($flage1 == 1 &&$flage2 == 1){
    
            $host = "localhost";
            $dbname = "portfolio";
            $username ="root";
            $password = "";
    
            $conn = mysqli_connect($host,$username,$password,$dbname);

            if (mysqli_connect_errno()) {
                echo "Connection unsuccessful";
                die("Connection error:".mysqli_connect_error());
            }

            $sql = "SELECT * FROM users WHERE Email='$email';";

            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);

            if(password_verify($pword,$row['Password'])){
                session_start();
                $_SESSION=$row;
                // echo "<p>matched</p>";
                header('Location: passMessage.php');
                exit();
            }else{
                 echo "wrong password or username";
                 echo "<h2 style='color : red;'>Wrong password or username<h2>";
            }

        }
        else{
        echo "<h2 style='color : red;'>$emailErr <br>$pwordErr<h2>";
        } 
}


function checksession(){
    session_start();
    if(!isset($_SESSION["Email"])){

        header('Location: index.html');
        exit();
    }
    else{
        $email=$_SESSION["Email"];
        $user_Password=$_SESSION["Password"];

        $host = "localhost";
        $dbname = "portfolio";
        $username ="root";
        $password = "";

        $conn = mysqli_connect($host,$username,$password,$dbname);


        $sql = "SELECT * FROM users WHERE Email='$email';";

            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);

            if(!($user_Password == $row['Password'])){
                session_destroy();
                header('Location: index.html');
                exit();
            }

        
    }
}

function validateMessageForm(){
        // Initialize variables to store form data and error messages
$email = $message = "";
$emailErr = $messageErr = "";
$flage1 = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Function to sanitize input data
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

  // Validate and sanitize message
    if (empty($_POST["Message"])) {
        $messageErr = "Message is required";
    } else {
        $message = sanitize_input($_POST["Message"]);
        // Additional validation/sanitization can be added here as needed
        $flage1 = 1;
    }

    $url = sanitize_input($_POST["URL"]);
}
if($flage1 == 1){

        $email=$_SESSION["Email"];

        $host = "localhost";
        $dbname = "portfolio";
        $username ="root";
        $password = "";

        $conn = mysqli_connect($host,$username,$password,$dbname);

        if (mysqli_connect_errno()) {
            echo "Connection unsuccessful";
            die("Connection error:".mysqli_connect_error());
        }

        $sql = "INSERT INTO `messages` (`Email`,`URL`, `Message`) VALUES ('$email', '$url','$message');";
        $result = mysqli_query($conn,$sql);

        
        echo "<h3>recoded</h3>";

}
else{
echo "<h2>$messageErr</h2>";
}   

}

function prevMessages(){
    
    $email=$_SESSION["Email"];

    $host = "localhost";
    $dbname = "portfolio";
    $username ="root";
    $password = "";

    $conn = mysqli_connect($host,$username,$password,$dbname);
    $sql = "SELECT * FROM messages WHERE Email='$email';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    echo "<br>";
    echo "<h2>sent messages</h2>";

    echo "<table style ='border-collapse: collapse; width: 100%; border: 1px solid #f7931e;' >";
    echo "<tr>";
    echo "<th>Message ID</th>";
    echo "<th>Message</th>";
    echo "<th>URL</th>";
    echo "</tr>";

    if($resultCheck > 0){
      while($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$row['M_ID']."</td>";
        echo "<td>".$row['Message']."</td>";
        echo "<td>".$row['URL']."</td>";
        echo "</tr>";
      }
    }
    echo "</table>";
  
}
?>
