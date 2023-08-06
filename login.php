<?php
    // error_reporting(0);
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"]."/classes/php/Database.php";

    $errorMessage = "";
    $conn = new DatabaseConnection();

    if (isset($_SESSION["loggedin"])) {
        header("Location: index.php");
        exit();
    }
    
    if ($_POST) {
        $user_form = trim($_POST['user']);
        $pass_form = trim($_POST['password']);
         
        $conn = new DatabaseConnection();
        $conn->Connect();
        

        // Verificación de las credenciales de usuario
        $sql = "select id, username, password from usuarios where username = ?";
        $stmt = $conn->conn->prepare($sql);
        $stmt->bind_param("s", $user_form);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc(); // get the mysqli result
        var_dump($result);
        
        // Si los datos coinciden, inicializo la sesión
        if (isset($result["id"])) {
            if (password_verify($pass_form, $result["password"])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['account_type'] = $result["role"];
                $_SESSION['user'] = $result["username"];
                $_SESSION['userid'] = $result["id"];
                header("Location: index.php");
                exit();
            } else {
                $errorMessage = "Usuario y/o contraseña incorrectos.";
            }
        } else {
            $errorMessage = "Usuario y/o contraseña incorrectos.";
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Iniciar sesión en Factum</title>
    <meta name="description" content="Iniciar sesión en ViGal Artesana">
    <link rel="stylesheet" href="./includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/fontawesome.all.min.css">
    <link rel="stylesheet" href="./includes/css/Bootstrap-Callout.css">
    <link rel="stylesheet" href="./includes/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="./includes/css/bootstrap-icons.css"> 
    <link rel="stylesheet" href="./includes/css/styles.css"> 

</head>

<body style="background-color: rgb(241,247,252);">
    <div class="login-clean" style="background-color: rgba(241,247,252,0);">
        <form class="border rounded shadow-lg" method="post" style="margin-top: 20px;" action="login.php">
            <div style="margin-top: 20px; text-align: center;">
                <p style="font-family: Great Vibes; font-size: 32px;">ViGal Boutique</p>
            </div>
            <p style="font-size: 20px;text-align: center;">Factum<p>
            <div class="mt-5">
                <?php
                    if ($errorMessage != "") {
                        $message = $_SESSION["error"];
                        echo '<div class="illustration">
                                <div style="font-size: 16px;" class="alert alert-danger" >
                                    '.$errorMessage.'
                                </div>
                            </div>';
                        session_unset();
                        session_destroy();
                    }
                ?>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                    <input type="text" name="user"class="form-control" placeholder="Usuario" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-key"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" aria-label="Username" aria-describedby="basic-addon1">
                </div>

                <div class="d-grid">
                <button type="submit" class="btn my-button mt-3">Iniciar sesión</button>
                </div>
            </div>
        </form>
    </div>        
    <script src="./includes/js/jquery-3.6.0.min.js"></script>
    <script src="./includes/js/bootstrap.min.js"></script>
</body>
</html>