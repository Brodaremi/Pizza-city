<?php include("../config/db_connect.php")?>
<?php
if(isset($_POST["delete"])){
    $id_to_delete = mysqli_real_escape_string($conn, $_POST["id_to_delete"]);
    
    //make query
    $sql = "DELETE FROM pizza WHERE id = $id_to_delete";


    if(mysqli_query($conn, $sql)){
        header("location: ../index.php");
    }else{
        echo 'query error:'. mysqli_error($conn);
    }
}
?>
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

<?php include("../templates/header.php"); ?>
</nav>

    <?php if($pizzas){?>
        <h2><?php echo htmlspecialchars($pizzas["title"])?></h2>
        <div>
        <p>Created by: <?php echo htmlspecialchars($pizzas["names"])?>  </p>
        <p>Contact: <?php echo htmlspecialchars($pizzas["email"])?></p>
        </div>
        <h3>Ingredients: <?php echo htmlspecialchars($pizzas["ingredients"])?></h3>

        <form action="details.php" method="POST">
        <input type="hidden" name="id_to_delete" value="<?php echo $pizzas["id"]?>">
        <input type="submit" name="delete" value="Delete pizza">
    </form>
    <a href="edit.php?id=<?php echo $pizzas["id"]?>">Edit pizza</a>

    <?php } else {?>
            <h5>No such pizza exist</h5>
        <?php } ?>



<?php include("../templates/footer.php"); ?>