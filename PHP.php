<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style type="text/css">
        * {
            background: lightgray;
        }
        #redLetter {
            color: red;
        }
        input, textarea {
            background: white;
        }
        button {
            background: #b38124;
            color: white;
        }
        .hidden {
            display: none;
        }
    </style>
    <title>PHP test document</title>
</head>
<body>

    <h1>Click button to see example</h1>
    <nav id="navigation"></nav>

    <section id="formValidation" class="hidden">

    <?php
        // define variables and set to empty values
        $nameErr = $emailErr = $genderErr = $commentErr = $websiteErr = "";
        $name = $email = $gender = $comment = $website = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
                $nameErr = "Name is required!";
            } else {
                $name = test_input($_POST["name"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                  $nameErr = "Only letters and white space allowed"; 
                }
          }
          
            if (empty($_POST["email"])) {
                $emailErr = "Email is required!";
            } else {
                $email = test_input($_POST["email"]);
                // check if e-mail address is well-formed
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  $emailErr = "Invalid email format"; 
                }
            }
          
            if (empty($_POST["website"])){
                $website = "";
            } else {
                $website = test_input($_POST["website"]);
                // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
                if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
                  $websiteErr = "Invalid URL"; 
                }
            }

            if (empty($_POST["comment"])) {
                $comment = "";
            } else {
                $comment = test_input($_POST["comment"]);
            }
          
            if (empty($_POST["gender"])) {
                $genderErr = "Gender is required";
            } else {
                $gender = test_input($_POST["gender"]);
            }
          
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>

    <header>
        <h1>PHP Form Validation Example</h1>
        <h4 id="redLetter">* indicates required fields</h4>
    </header>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        Name: <input type="text" name="name" autocomplete="name" value="<?php echo $name;?>"><span class="error" id="redLetter">*<?php echo $nameErr;?></span>
        <br><br>
        E-mail: <input autocomplete="email" type="text" name="email" value="<?php echo $email;?>"><span class="error" id="redLetter">*<?php echo $emailErr;?></span>
        <br><br>
        Website: <input type="text" name="website" autocomplete="website" value="<?php echo $website;?>"><span class="error" id="redLetter"><?php echo $websiteErr;?></span>
        <br><br>
        Comment: <textarea name="comment" rows="5" cols="40" placeholder="Comments?"><?php echo $comment;?></textarea>
        <br><br>
        Gender:
        <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
        <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male<span class="error" id="redLetter">*<?php echo $genderErr;?></span>
        <br><br>
        <button type="submit" name="submit">Submit</button>  
    </form>

    <footer><h1>Your Input:</h1></footer>

    <?php
        echo "$name <br>" . "$email <br>" . "$website <br>" . "$comment <br>" . "$gender <br>";
    ?>
    
    </section>

    <section id="mutiDimensionalArrays" class="hidden">

    <h1>Multi-Dimensional Arrays</h1>

    <?php 
        $cars = array(
            array("Volvo", 22, 18),
            array("BMW", 15, 13),
            array("Saab", 5, 2),
            array("Land Rover", 17, 15)
        );

        echo $cars[0][0] . ": In stock: " . $cars[0][1] . ", sold: " . $cars[0][2] . ".<br>";
        echo $cars[1][0] . ": In stock: " . $cars[1][1] . ", sold: " . $cars[1][2] . ".<br>";
        echo $cars[2][0] . ": In stock: " . $cars[2][1] . ", sold: " . $cars[2][2] . ".<br>";
        echo $cars[3][0] . ": In stock: " . $cars[3][1] . ", sold: " . $cars[3][2] . ".<br>"; 

        for ($row = 0; $row < count($cars); $row++) {
          echo "<p><b>Row number $row</b></p>";
          echo "<section>";
          for ($col = 0; $col < count($cars[$row]); $col++) {
            echo "<div>" . $cars[$row][$col] . "</div>";
          }
          echo "</section>";
        }
    ?>
    
    </section>

    <section class="hidden" id="dateTime">

    <h1>Date and Time</h1>
    <?php
    echo "Today is " . date("Y/m/d") . "<br>";
    echo "Today is " . date("Y.m.d") . "<br>";
    echo "Today is " . date("Y-m-d") . "<br>";
    echo "Today is " . date("l");
    ?>

    </section>

    <section class="hidden" id="fileUpload">

        <br><br>
        <h1>Upload an image to the server</h1>
        <br><form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
        </form>

    </section>

<script>
    var buttonArray = ["formValidation", "mutiDimensionalArrays", "dateTime", "fileUpload"];

    for (var buttonItterator = buttonArray.length - 1; buttonItterator >= 0; buttonItterator--) {
        $("#navigation").append("<button id='button" + buttonItterator + "' onclick='buttonClick(this.id)'>" + buttonArray[buttonItterator] + 
            "</button>");
    }
// todo create a buttons array to control all this
    function buttonClick(buttonID) {
        // $("#dateTime, #formValidation, #mutiDimensionalArrays").toggleClass('hidden');
        switch (buttonID) {
            case 'button0':
                $("#formValidation").toggleClass('hidden');
                break;
            case 'button1':
                $("#mutiDimensionalArrays").toggleClass('hidden');
                break;
            case 'button2':
                $("#dateTime").toggleClass('hidden');
                break;
            case 'button3':
                $("#fileUpload").toggleClass('hidden');
                break;
        }
    }
</script>
<br><br>&copy; 2010-<?php echo date("Y");?>
</body>
</html>