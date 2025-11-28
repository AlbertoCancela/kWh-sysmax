<?php
  $name = $_SESSION['data']['name'];
  $id = $_SESSION['data']['id'];
  $email = $_SESSION['data']['email'];
  $userName = $_SESSION['userName'];
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/public/img/sysmax_logo64.png" type="image/png">
    <link rel="stylesheet" href="/public/css/styles.css">
    <link rel="stylesheet" href="/public/css/generalModal.css">
    <link rel="stylesheet" href="/public/css/userSettings.css">
    <link href='/public/boxicons-master/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Tu proyecto</title>
</head>
  <body>    
    <div class="main-con">        
    <?php include_once __DIR__ . "/../components/general/header.php"?>    
    <?php include_once __DIR__ . "/../components/general/generalModal.php"?>    
      <main class="sysmax-main">
            <?php include_once __DIR__ . "/../components/admon/adminHeader.php"?>            
            <section class="userSettings">
                <h3 class="table title">USUARIOS</h3>
                <div class="userSettings-settings">
                    <div class="settings-header">
                        <i class='bx bxs-user bx-md'></i>
                        <p class="settings-title">Información y ajuste de la cuenta</p>
                    </div>
                    <div class="settings-settings">
                        <div onclick="openGeneralModal('setUserSettings',this)" class="settings-row">
                            <p>Nombre</p>
                            <p id="settings-name" modalType="simplechange" pa-name="<?php echo $name ?>"><?php echo $name ?></p>
                            <p><i class='bx bxs-chevron-right bx-md'></i></p>
                        </div>
                        <div onclick="openGeneralModal('setUserSettings',this)" class="settings-row">
                            <p>Nombre de usuario</p>
                            <p id="settings-userName" modalType="simplechange" 
                                pa-userName="<?php echo $userName ?>" 
                                pa-id = "<?php echo $id ?>">
                                <?php echo $userName ?>
                            </p>
                            <p><i class='bx bxs-chevron-right bx-md'></i></p>
                        </div>
                        <div onclick="openGeneralModal('setUserSettings',this)" class="settings-row">
                            <p>Contraseña</p>
                            <p id="settings-password" modalType="password">******</p>
                            <p><i class='bx bxs-chevron-right bx-md'></i></p>
                        </div>
                        <div onclick="openGeneralModal('setUserSettings',this)" class="settings-row">
                            <p>Email</p>
                            <p id="settings-email" modalType="simplechange" pa-email="<?php echo $email ?>"><?php echo $email ?></p>
                            <p><i class='bx bxs-chevron-right bx-md'></i></p>
                        </div>
                    </div>
                </div>
            </section>            
      </main>      
    </div>    
    <script type="module">
        import { closeSession, getSingleBreakerData, changeUserName, verifyPassword, changePassword, changeName, changeEmail } from "/public/js/general.js";
        window.closeSession = closeSession;
        window.changeUserName = changeUserName;
        window.verifyPassword = verifyPassword;
        window.changePassword = changePassword;
        window.changeName = changeName;
        window.changeEmail = changeEmail;
    </script>
    <script src="/public/js/generalModal.js"></script>
    <script src="/public/js/userSettings.js"></script>
  </body>
</html>