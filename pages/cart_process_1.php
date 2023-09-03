<?php

session_start();

require_once ('cart/component.php');
require_once ('../Classes/DbConnector.php');

// create connection
$con_obj = new Classes\DbConnector();
$con = $con_obj->getConnection();

if (isset($_POST['remove'])){
  if ($_GET['action'] == 'remove'){
      foreach ($_SESSION['cart'] as $key => $value){
          if($value["product_id"] == $_GET['id']){
              unset($_SESSION['cart'][$key]);
              echo "<script>alert('Product has been Removed...!')</script>";
              echo "<script>window.location = 'cart.php'</script>";
          }
      }
  }
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/cart.css">
</head>
<body class="bg-light">

<?php
    require_once ('cart/header.php');
?>

<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-6">
            <div class="shopping-cart">
                <h6>My Cart</h6>
                <hr>

                <?php

                $total = 0;
                    if (isset($_SESSION['cart'])){
                        $product_id = array_column($_SESSION['cart'], 'product_id');

                        $sql = "SELECT * FROM software WHERE license='Paid'";
                        $result = $con->prepare($sql);
                        $result->execute();
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                            foreach ($product_id as $id){
                                if ($row['Sid'] == $id){
                                    $sql_2 = "SELECT user.username FROM user WHERE user.Uid = (SELECT developer.user FROM developer WHERE developer.Did = (SELECT software.developer FROM software WHERE software.Sid = \"{$row['Sid']}\"))";
                                    $seller_name = $con->prepare($sql_2);
                                    $seller_name->execute();
                                    $name = $seller_name->fetch(PDO::FETCH_ASSOC);
                                    cartElement($row['name'],$row['amount'], $row['Sid'], $name['username']);
                                    $total = $total + (int)$row['amount'];
                                }
                            }
                        }
                    }else{
                        echo "<h5>Cart is Empty</h5>";
                    }

                ?>

            </div>
        </div>
        <div class="col-md-4" >
            <div class="offset-md-1 border rounded mt-5 bg-white p-3" style="height: fit-content;">
                <div class="pt-4">
                    <h6 style="font-size: 1.3rem;"><b>PRICE DETAILS</b></h6>
                    <hr>
                    <div class="row price-details">
                        <div class="col-md-6">
                            <?php
                                if (isset($_SESSION['cart'])){
                                    $count  = count($_SESSION['cart']);
                                    echo "<h6>Price ($count items)</h6>";
                                }else{
                                    echo "<h6>Price (0 items)</h6>";
                                }
                            ?>

                            <hr>
                            <h6>Amount Payble</h6>
                        </div>
                        
                        <div class="col-md-6" style="width: fit-content;">
                            <h6>$<?php echo $total; ?></h6>

                            <hr>
                            
                            <h6>$<?php
                                echo $total;
                                ?></h6>
                        </div>
                    
                        
                    </div>
                </div>
                <div class="my-2 mx-auto" style="width: fit-content;">
                    <form method="post">
                        <input type="hidden" name="checkout" value="true">
                        <button type="submit" class="btn btn-success">Checkout</button>
                    </form>
                </div>
        </div>
        </div>
        <div class="col-md-4">
            
        </div>
    </div>
    
</div>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
