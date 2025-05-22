<?php
require_once(__DIR__ . "/core/Database.php");
require_once(__DIR__ . "/model/loginModel.php");
require_once(__DIR__ . "/controller/loginController.php");

require_once 'header.mustache';?>
  <div class="container">
    <div class="login-box">
      <h2>Iniciá Sesión</h2>
       <form action="" method="POST">
        <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <a href="#" class="forgot">¿Olvidaste tu contraseña?</a>
      <button type="submit" value="Submit">Ingresar</button>
      <div class="remember">
        <input type="checkbox" id="remember">
        <label for="remember">Recordar</label>
      </div>
      </form>
      <div class="bottom-text">¿No tenes una cuenta?
        <a href="registerView.php" class="registrar">Registrarme</a>
       </div>
    </div>
  </div>
<?php  require_once 'footer.mustache';?>
