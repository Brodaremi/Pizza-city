<?php include("../config/db_connect.php")?>
<?php

if(isset($_GET["id"])){
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
    
    //make query
    $sql = "SELECT * FROM pizza WHERE id = $id";

    //get query result
    $result = mysqli_query($conn, $sql);

    //fetch result
    $pizzas = mysqli_fetch_assoc($result);


    //free memory and close connection
    mysqli_free_result($result);
    mysqli_close($conn);
}
 ?>

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

             $id_to_update = mysqli_real_escape_string($conn, $_POST["id_to_update"]);
            //make query
            $sql =  "UPDATE `pizza` SET `names`='$name',`email`='$email',`title`='$title',`ingredients`='$ingredients' WHERE id = $id_to_update";
                if(mysqli_query($conn, $sql)){
                    header("location: details.php?id=$id_to_update");
                }else{
                    echo 'query error:'. mysqli_error($conn);
                }
}
}


?>


<?php include("../templates/header.php"); ?>
</nav>

<h1>Edit pizza</h1>
<?php if($pizzas){?>
    <form action="edit.php" method="POST" class="">
        <label for="Your name">
            <input type="text" name="name" id="" placeholder="Enter your name" value="<?php echo htmlspecialchars($pizzas["names"])?>">
        </label>
        <div>
            <?php echo $error["name"]?>
        </div>
        <label for="Your email">
            <input type="text" name="email" id="" placeholder="Enter your Email" value="<?php echo htmlspecialchars($pizzas["email"]) ?>">
        </label>
        <div>
            <?php echo $error["email"]?>
        </div>
        <label for="pizza title">
            <input type="text" name="title" id="" placeholder="Pizza title" value="<?php echo htmlspecialchars($pizzas["title"]) ?>">
        </label>
        <div>
            <?php echo $error["title"]?>
        </div>
        <label for="Ingredients (Comma and space seperated">
            <input type="text" name="ingredients" id="" placeholder="Pizza ingredients" value="<?php echo htmlspecialchars($pizzas["ingredients"]) ?>">
        </label>
        <div>
            <?php echo $error["ingredients"]?>
        </div>
        <input type="hidden" name="id_to_update" value="<?php echo $pizzas["id"]?>">
        <input type="submit" value="Update" name="submit">

    <?php } else {?>
            <h5>No such pizza exist</h5>
        <?php } ?>



<?php include("../templates/footer.php"); ?>