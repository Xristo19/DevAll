<?php
    $errors = array();

    //connection
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "devall";

    try{
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
    }catch(PDOException $e){
       //echo "DB Connection Failed: ". $e->getMassage();
    }

    //check if button works
    if(isset($_POST['register'])) {

        $username = $_POST['username'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        
    //check Field validation
    if(empty($username)){
        array_push($errors, "Username is required");
    }
    if(empty($lastname)){
        array_push($errors, "Lastname is required");
    }
    if(empty($email)){
        array_push($errors, "Email is required");
    }

    //save user to database
    if(count($errors) == 0){
        $sql = "INSERT INTO `users` (`username`, `lastname`, `email`) 
                VALUES (:username , :lastname, :email);";  
                
        $pdoResult = $pdo->prepare($sql);

        $pdoExec = $pdoResult->execute(['username'=>$username,'lastname'=>$lastname,'email'=>$email]);

        $to = 'test@developer-alliance.com';
        $subject = 'Details';
        $message = 'Username = '.$username."\r\n". 
                    'Lastname = '.$lastname."\r\n".
                    'Email = '.$email;
        $headers = "From: server@test-gmail.com \r\n";
        ini_set('smtp_port', 1025); 

        mail($to, $subject, $message, $headers);
        
        header('Refresh: 0; url=register.php');
    }

}

?>