<?php
	
    /*function render($template, $values = [])
    {
        // if template exists, render it
        if (file_exists("../templates/$template"))
        {
            // extract variables into local scope
            extract($values);
            // render header
            require("../templates/header.php");
            // render template
            require("../templates/$template");
            // render footer
            require("../templates/footer.php");
        }
        // else err
        else
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }*/

	if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        
        render("../views/login_form.php");
    }
    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

        // validate submission
        if (empty($_POST["username"]))
        {
            echo "You must provide your username.";
        }
        else if (empty($_POST["password"]))
        {
            echo "You must provide your password.";
        }

        else
        {

            $servername = "localhost";
            $username = "root"; //mysql username
            $password = "IlovemyindiA19!"; //mysql password

            // Create connection
            $conn = new mysqli($servername, $username, $password, "buyandsell");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            //echo "Connected successfully";
            
            $user = $_POST["username"];
            $userp = $_POST["password"];

            $row = "SELECT * FROM users WHERE username = '". $user."'";

            // query database for user
            $result = $conn->query($row);


            
            if (!$result) {
                die($conn->error);
            }

            
            
            //echo "num_rows = ".$result->num_rows."\n";
            if ($result->num_rows > 0) {

                // if we found user, check password
                
                $userdata = $result->fetch_assoc();


                if ($userdata["password"] == $userp)
                {
                    echo "You are logged in";

                    session_start();

                    $_SESSION["loggedin"] = true;

                    $_SESSION["college"] = $userdata["college"];
                    $_SESSION["username"] = $userdata["username"];

                    require "../views/portfolio.php";
                }
                else{
                    
                    echo "Wrong Password";
                    require "../views/login_form.html";
                }

                
                   
                   
            } 
            else {

                    echo "user doesn't exist";

                }
                 

              
        }
        
        
      
            // compare hash of user's input against hash that's in database
            /*if (crypt($_POST["password"], $row["hash"]) == $row["hash"])
            {
                // remember that user's now logged in by storing user's ID in session
                $_SESSION["id"] = $row["id"];
                $_SESSION["cash"] = $row["cash"];
                
            }*/
        //}
        
    }
?>