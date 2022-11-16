<?php include("../config/db_connect.php")?>
<?php


$error = ["name" => "", "email" => "", "title" => "", "ingredients" => "",];
$name = $email = $title = $ingredients = "";
if(isset($_POST["submit"])){
    //Name validation using regEx
    if(empty($_POST["name"])){
        $error["name"] = "a name is required";
    }else{
        $name = $_POST["name"];
        if(!preg_match('/^[a-zA-Z\s]+$/', $name)){
            $error["name"] =  "Name must only be letters and spaces";
        }
    };
    //Email validation
    if(empty($_POST["email"])){
        $error["email"] =  "An email is required";
    }else{
        $email = $_POST["email"];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error["email"] =  "please enter a valid email";
        }
    };
        //title validation using regEx
        if(empty($_POST["title"])){
            $error["title"] =  "A title is required";
        }else{
            $title = $_POST["title"];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                $error["title"] =  "title must only be letters and spaces";
            }
        };
        //Ingredients validation using regEx
        if(empty($_POST["ingredients"])){
            $error["ingredients"] =  "At least one ingredient is required";
        }else{
            $ingredients = $_POST["ingredients"];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s+[a-zA-Z\s]*)+$/', $ingredients)){
                $error["ingredients"] =  "Ingredients must be letters, comma and spaces only";
            }
        }
        //Redirect users to index page if the $error array is empty which will be true if the form is validated correctly
        if(!array_filter($error)){
            //prepare data to insert to database
            $name = mysqli_real_escape_string($conn, $_POST["name"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $title = mysqli_real_escape_string($conn, $_POST["title"]);
            $ingredients = mysqli_real_escape_string($conn, $_POST["ingredients"]);

            //Query to insert data
           $sql = "INSERT INTO `pizza`(`names`, `email`, `title`, `ingredients`) VALUES ('$name','$email','$title','$ingredients')";

            //save to db
            if(mysqli_query($conn, $sql)){
                //successful
                header("location: ../index.php");
            }else{
                echo 'query error:'. mysqli_error($conn);
            }
            
        }
}



?>






<?php include("../templates/header.php"); ?>
</nav>

<section class="container">
    <h3>Add a pizza</h3>
    <form action="add.php" method="POST" class="form form-group">
        <label for="Your name">
            <input type="text" name="name" id="" placeholder="Enter your name" value="<?php echo htmlspecialchars($name) ?>">
        </label>
        <div>
            <?php echo $error["name"]?>
        </div>
        <label for="Your email">
            <input type="text" name="email" id="" placeholder="Enter your Email" value="<?php echo htmlspecialchars($email) ?>">
        </label>
        <div>
            <?php echo $error["email"]?>
        </div>
        <label for="pizza title">
            <input type="text" name="title" id="" placeholder="Pizza title" value="<?php echo htmlspecialchars($title) ?>">
        </label>
        <div>
            <?php echo $error["title"]?>
        </div>
        <label for="Ingredients (Comma and space seperated">
            <input type="text" name="ingredients" id="" placeholder="Pizza ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
        </label>
        <div>
            <?php echo $error["ingredients"]?>
        </div>
        <input type="submit" value="Submit" name="submit">
    </form>

    <a href="../index.php">Cancel</a>
</section>


<?php include("../templates/footer.php"); ?>