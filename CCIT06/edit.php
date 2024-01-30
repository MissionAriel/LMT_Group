<?php  

include('db_conn.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Edit& Update Client Information</title>
</head>
<body>
    <div class="container">
        <div class="row">
              <div class="col-md-8 mt-4">

              <div class="card">
                <div class="card-header">
                <h1> EDIT & UPDATE CLIENT INFORMATION
                <a href="index.php" class="btn btn-danger float-end">Back</a>
            </h1>
                </div>
                <div class="card-body">

                <?php
                if(isset($_GET['id']))
                {
                    $client_id = $_GET['id'];

                    $query = "SELECT * FROM client WHERE id=:client_id LIMIT 1";
                    $statement = $conn->prepare($query);
                    $data = [':client_id' => $client_id];
                    $statement->execute($data);

                    $result = $statement->fetch(PDO::FETCH_OBJ);
                }
                ?>


                     <form action="process.php" method="POST">
                          
                     <input type="hidden" name="client_id" value="<?= $result->id?>">

                            <div class="mb-3">
                                <label>Firstname</label>
                                <input type="text" name="fname" value="<?= $result->fname ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Lastname</label>
                                <input type="text" name="lname" value="<?= $result->lname ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="text" name="email" value="<?= $result->email ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Address</label>
                                <input type="text" name="address" value="<?= $result->address ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Contact</label>
                                <input type="text" name="contact" value="<?= $result->contact ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="update_client_btn" class="btn btn-primary">Update Client</button>
                            </div>
                            
                     </form>

                </div>
              </div>

              </div>
        </div>
    </div>


</body>
</html>