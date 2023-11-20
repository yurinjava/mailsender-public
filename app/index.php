

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/site-icon.png">
    <link rel="stylesheet" href="../assets/custom.css">
    <script src="../assets/custom.js"></script>
    <link rel="stylesheet" href="../assets/custom.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Nelide Mailer</title>
    <style>
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 50px;
        }

        .form-image {
            text-align: center;
        }
    </style>
</head>
<?php 
session_start();
           // print_R($_SESSION) ;
        if(isset($_SESSION['valid']) && $_SESSION['valid']==0){
            echo'    
            <div  id="alert">
            <p class="mb-4">All fields must be filled!</p>
            <a class="btn btn-primary" onclick="displaynt()" >Got it!</a>
        </div>';
        }
          
        
        ?>

<body>
    <div class="container form-container bg-light" >
        <div class="form-image">
            <img src="../assets/email.png" alt="Image" class="img-fluid">
        </div>
       
        <form action="process-email.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="sendTo">Send to:</label>
                <input type="email" name="recipient" class="form-control" id="sendTo" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" name="subject" class="form-control" id="subject" placeholder="Enter subject">
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" name="message" id="message" rows="4" placeholder="Enter your message"></textarea>
            </div>

            <div class="form-group">
                <label for="browser">Select file:</label>
                <input type="file" id="file" name="file" class="form-control-file" placeholder="Enter your message">
            </div>

            <button type="submit" name="action" class="btn btn-primary"><img src="../assets/send.png"  ></button>
           
            <a type="button" id="cancel" href="<?php $_SERVER['PHP_SELF']; $_SESSION['valid']='1' ?>" class="btn btn-danger">Cancel</a>
            
            
        </form>
       
    </div>

   
</body>

</html>
