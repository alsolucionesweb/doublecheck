<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido, <?php echo e($_SESSION['user']['name']); ?></h1>
    <p>Tu correo: <?php echo e($_SESSION['user']['email']); ?></p>
    <a href="/logout">Cerrar sesión</a>
</body>
</html>
<?php /**PATH E:\FCB\ORACULUM\Oraculum\oraculum\resources\views/home.blade.php ENDPATH**/ ?>