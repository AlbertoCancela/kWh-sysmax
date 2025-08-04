      <header class="topbar">
        <div class="container">
          <div class="nav">
            <div class="logo-wrapper">
              <img src="/public/img/sysmax_logo_transp.png" alt="" width="100" height="50" class="logo">
            </div>            
            <div class="client">
              <h3 class="clientname"><?php echo $_SESSION['userName']?></h3>
              <button onclick="closeSession()" class="btn-close">Cerrar Sesión</button>
            </div>
          </div>
        </div>
      </header>