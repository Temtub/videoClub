<?PHP
//Estos "use" deben de ir al principio del archivo
//Si no, no fucniona
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


    /*
     * Hay que especificar la ruta relativa de:
     *  - Exception.php
     *  - PHPMailer.php
     *  - SMTP.php
     */
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' ){
        
        //Comprobamos que las variables estén declaradas
        if(!isset($_POST['email']) ){
            header('Location: ../../../pages/sendEmailUser.php?asunto='.$_POST['asunto'].'&cuerpo='.$_POST['cuerpo']);
        }
        if(!isset($_POST['asunto']) ){
            header('Location: ../../../pages/sendEmailUser.php?email='.$_POST['email'].'&cuerpo='.$_POST['cuerpo']);
        }
        if(!isset($_POST['cuerpo']) ){
            header('Location: ../../../pages/sendEmailUser.php?email='.$_POST['email'].'&asunto='.$_POST['asunto']);
        }
        
        try {
            
            /*
            * Necesitas la vereficación de dos pasos en el gmail activada.
            * Y la contraseña de aplicación (app password).
            */

           $mail = new PHPMailer(true); //Crear objeto de la clase PHPMailer

           $mail->isSMTP();
           $mail->Host = 'smtp.gmail.com'; //Tipo de host: gmail en este caso
           $mail->SMTPAuth = true; //Autentificación activada


           $mail->Username = 'Aqui va tu email'; //Tu gmail
           $mail->Password = 'Aquí va tu contraseña de aplicación'; //Tu contraseña de aplicación de gamil
           $mail->SMTPSecure = 'ssl'; //Tipo de seguridad
           $mail->Port = 465; //Puerto de smtp
           $mail->Timeout = 5;


           $mail->setFrom('El correo que envía el mensaje'); //Gmail desde el que se envía el mensaje

           $mail->addAddress($_POST['email']); //El email que recibe el correo

           $mail->isHTML(true); //El mensaje enviado es HTML

           $mail->Subject = $_POST["asunto"]; //Asunto del mensaje
           $mail->Body = $_POST['cuerpo']; //Cuerpo del mensaje
           
           
           /*
            * De esta forma, envío el mensaje y el resultado lo guardo en una
            * variable llamada $exito.
            * 
            * Si el mensaje es enviado --> $exito tiene valor 1.
            * 
            * Por lo que si $exito tiene cualquier otro valor, siginifica que
            * el mensaje no fue enviado.
            */
           $exito = $mail->send(); 
           
           //Si el mensaje no fue enviado --> Mando una excepción;
           if($exito != 1){
               throw new Exception('Error en el envio: Alguno de los datos no es correcto');
           }else{
               echo '<p>El mensaje se envió con exíto</p>';
           }
           
        } catch (Exception $exc) {
            echo $exc->getMessage();
        } 

        //Volver a index.php
        echo '<p><a href="../index.php">Volver</a></p>';
        
        
    }//if