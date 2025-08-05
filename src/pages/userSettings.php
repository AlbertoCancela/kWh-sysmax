<?php
  session_name('sysmax-tuya');
  session_start();
  if (!isset($_SESSION['userName'])) {
      header("Location: /kWh-sysmax/src/login.php");
      exit;
  }
//   echo $_SESSION['data']['id'];
  $name = $_SESSION['data']['name'];
  $id = $_SESSION['data']['id'];
  $userName = $_SESSION['userName'];
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/kWh-sysmax/public/img/sysmax_logo64.png" type="image/png">
    <link rel="stylesheet" href="/kWh-sysmax/public/css/styles.css">
    <link rel="stylesheet" href="/kWh-sysmax/public/css/generalModal.css">
    <link rel="stylesheet" href="/kWh-sysmax/public/css/userSettings.css">
    <link href='/kWh-sysmax/public/boxicons-master/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Sysmax Tecnología S.A. de C.V.</title>
</head>
  <body>    
    <div class="main-con">
      <?php include_once "../components/general/header.php"?>
      <?php include_once "../components/general/generalModal.php"?>
      <main class="sysmax-main">
            <section class="userSettings">
                <div class="userSettings-settings">
                    <div class="settings-header">
                        <i class='bx bxs-user bx-md'></i>
                        <p class="settings-title">Información y ajuste de la cuenta</p>
                    </div>
                    <div class="settings-settings">
                        <div class="settings-row">
                            <p>Nombre</p>
                            <p id="settings-name"><?php echo $name ?></p>
                            <p></p>
                        </div>
                        <div onclick="openGeneralModal('setUserSettings',this)" class="settings-row">
                            <p>Nombre de usuario</p>
                            <p id="settings-userName" modalType="username" 
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
                        <div class="settings-row">
                            <p>Departamento</p>
                            <p id="settings-department">a01204</p>
                            <p></p>
                        </div>
                    </div>
                </div>
            </section>
      </main>
    </div>
    <script type="module">
        import { closeSession, getSingleBreakerData, changeUserName, verifyPassword, changePassword } from "/kWh-sysmax/public/js/general.js";
        window.closeSession = closeSession;
        window.changeUserName = changeUserName;
        window.verifyPassword = verifyPassword;
        window.changePassword = changePassword;
    </script>
    <script src="/kWh-sysmax/public/js/generalModal.js"></script>
  </body>
</html>