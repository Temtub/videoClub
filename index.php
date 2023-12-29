<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Video club</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/styles.css"/>
    </head>
    <body>
        
        <div class="container-fluid">
            
            <?php
            //Check errors
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
            
            <form class="form d-flex flex-column align-items-center w-25 m-auto mt-5" action="./lib/controllers/login.php" method="POST">
                
                <h2 class="form__subtitle">INICIA SESION</h2>
                <h1 class="form__title">VIDREO</h1>
                
                <div class="d-flex flex-column form__inputs">  
                    <input class="form__input" type="text" name="user">
                    <label class="form__label">USUARIO</label>
                </div>
                

                <div class="d-flex flex-column form__inputs">  
                    <input class="form__input form__inputs--pink" type="text" name="pass">
                    <label class="form__label">CONTRASEÑA</label>
                </div>
                
                <input class="form__submit" type="submit" name="sub">
            </form>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
