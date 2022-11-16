<?php include("config/db_connect.php")?>
<?php

//Getting data from database
//Query for all pizza and sort by id
$sql = "SELECT title, ingredients, id FROM pizza ORDER BY 'created at'";

//make query
$result = mysqli_query($conn, $sql);

//fetching resulting rows of an array and convert to an associative array
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

//free result from memory
mysqli_free_result($result);

//close conection
mysqli_close($conn);
?>

<?php include("templates/header.php"); ?>
        <button class="navbar-nav mr-auto btn btn-success justify-content-end">
            <a href="./views/add.php" class="nav-link text-light">Add a pizza</a>
        </button>
    </nav>
        <h4 class="text-dark bg-light text-center">PIZZAS</h4>
<div class="container row">
        <?php foreach($pizzas as $pizza){?>
            <div class="card card-group col-3 col-xs-12 p-0 border-0">
            <img src="image/pizzaimg.jpg" alt="" class="img-fluid card-img-top rounded">
            <div class="card-body">
            <h4 class="card-title"><?php echo htmlspecialchars($pizza["title"]);?></h4>
            <ul>
            <p>Ingredients:</p>
                <?php foreach(explode(",", $pizza["ingredients"]) as $ingredient){?>
                    <li><?php echo htmlspecialchars($ingredient)?></li>
                    <?php } ?>
            </ul>
            <a class="btn btn-dark" href="views/details.php?id=<?php echo $pizza["id"]?>">More info</a>
            </div>
            </div>
           
            <?php } ?>
</div>


<?php include("templates/footer.php"); ?>
    
