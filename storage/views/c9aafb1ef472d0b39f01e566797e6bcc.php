

<div class="container">
    <div class="login-card">
      <div class="header">
        <h1>Welcome<br>To the website</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <a href="#" class="create-account">Create Account</a>
      </div>
      <div class="login-form">
        <h2>User Login</h2>
        <form method="POST" action="/login">
          <div class="input-group">
            <span class="icon">👤</span>
            <input type="email" name="email" placeholder="Username" required />
          </div>
          <div class="input-group">
            <span class="icon">🔒</span>
            <input type="password" name="password" placeholder="Password" required />
          </div>
          <div class="form-options">
            <label><input type="checkbox" /> Remember</label>
            <a href="#">Forgot password?</a>
          </div>
          <?php if(isset($error)): ?>
                <div class="alert alert-danger" style="color: red">
                    <?php echo e($error); ?>

                </div>
            <?php endif; ?>
          <button type="submit" class="login-button">Login</button>
        </form>
      </div>
    </div>
</div>
<!--!DOCTYPE html>
<html>
<head>
    <title>Double Check</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    

    <form method="POST" action="/login">
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>

        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <br>

        <button type="submit">Ingresar</button>
    </form>
</body>
</html-->
<?php /**PATH E:\FCB\ORACULUM\Oraculum\oraculum\resources\views/auth/login.blade.php ENDPATH**/ ?>