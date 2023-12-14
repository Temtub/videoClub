<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Video club</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        
        <div class="container-fluid">
            
            <?php
            //Comprobar errores pasados
            if(isset($_GET['errorLog']) ){
                echo 'Inicia sesión';
            }
            
            if(isset($_GET['wrong']) ){
                echo 'Contraseña o usuario incorrectos';
            }
            
            if(isset($_GET['redirected']) ){
                echo 'Debes iniciar sesión';
            }
            ?>
            
            <form class="d-flex flex-column w-25 m-auto mt-5" action="./lib/controllers/login.php" method="POST">
                
                <input type="text" name="user">
                
                <input type="password" name="pass">
                
                <input type="submit" name="sub">
            </form>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
