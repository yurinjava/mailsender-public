<?php 

echo '  <link rel="icon" type="image/x-icon" href="../assets/site-icon.png">';
    //print_r($_POST);
    session_start();

    require "../libs/PHPMailer/Exception.php";
    require "../libs/PHPMailer/DSNConfigurator.php";
   
    require "../libs/PHPMailer/OAuthTokenProvider.php";
    require "../libs/PHPMailer/PHPMailer.php";
    require "../libs/PHPMailer/POP3.php";
    require "../libs/PHPMailer/SMTP.php";


    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


    class Message{
        private $recipient= null;
        private $subject = null;
        private $message=null;
        public $status = array('status_code'=> null, 'status_description'=> '');


        public function __get($attribute){
            return $this->$attribute;
        }
        public function __set($attribute, $valor){
             $this->$attribute=$valor;
        }
        public function validMessage(){
            ///////////
            if(empty($this->recipient) || empty($this->subject) || empty($this->message)){
                //echo '<div style="z-index:100; position: fixed;">Hello</div>';
                
                return false;
            }
            return true;
               
        }
           
        
    }

    $message = new Message();
    $message->__set('recipient',$_POST['recipient']);
    $message->__set('subject',$_POST['subject']);
    $message->__set('message',$_POST['message']);

    if(!$message->validMessage()){
       $_SESSION['valid']='0';
        header('Location: index.php');
    }else{
        $_SESSION['valid']='1';
    }
   
    //print_r($message);
    

    $mail = new PHPMailer(true);
    if(isset($_POST['action'])){
             // echo 'success';
                $archive = $_FILES['file'];
                
                $newarchive = explode('.', $archive['name']);
                move_uploaded_file($archive['tmp_name'], 'uploads/'.$archive['name']);
               /* echo '<pre>';
                print_r($_FILES);
                echo '</pre>'; */
            } 
  try {
        //Server settings
        $mail->SMTPDebug = false;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'naledi.mailer@gmail.com';                     //SMTP username
        $mail->Password   = 'ggln uosq edog ezrf';                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('naledi.mailer@gmail.com', 'Naledi Mailer');
        $mail->addAddress($message->__get('recipient'), );     //Add a recipient
       
        $mail->addReplyTo('naledi.mailer@gmail.com', 'please dont');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
    
        //Attachments
       // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
       if($archive['size']>0){
        $mail->addAttachment('uploads/'. $archive['name']);    //Optional name
      }
      //echo print_r($archive);
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $message->__get('subject');
        $mail->Body    = $message->__get('message');
        $mail->AltBody = "The email require html support to display it's full content";
    
        $mail->send();

        $message->status['status_code']=1;
        $message->status['status_description']='The message has been sent successfully!';
      //  echo '<div style="color: green;">Message has been sent</div>';
    } catch (Exception $e) {

        $message->status['status_code']=2;
        $message->status['status_description']='It was not possible to send the message! '.$mail->ErrorInfo;

        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>
<html>
<html lang="pt-br">
    <head> <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <body>
            <div class="container-sm w-25 p-3 form-container bg-light mx-auto  d-flex justify-content-center">
               

                <div class="d-inline-flex p-2 ">
                <div class="form-image ">
                    <img src="../assets/email.png" alt="Image" class="img-fluid">
                </div>

                
                    <div class="">
                        <?php if($message->status['status_code']==1){ ?>
                               
                                <div class="container">
                                    <h1 class="display-4 text-success">Message sent</h1>
                                    <p><?php echo $message->status['status_description'] ?></p>
                                    
                                    <a href="index.php" class="btn btn-success btn-lg text-white">Return</a>
                                    
                                </div>
                                
                         <?php } ?>   

                         <!-- ******************************* -->

                         <?php if($message->status['status_code']==2){ ?>
                                
                                <div class="container">
                                    <h1 class="display-4 text-danger">Could not send the email!</h1>
                                    <p><?php echo $message->status['status_description']; ?></p>
                                    
                                    <a href="index.php" class="btn btn-danger btn-lg text-white">Return</a>
                                    
                                </div>
                         <?php } ?>   
                    </div>
                </div>
            </div>
        </body>
    </head>
</html> 
