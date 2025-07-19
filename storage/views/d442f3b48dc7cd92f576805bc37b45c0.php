<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $__env->yieldContent('title', 'Duble Check'); ?></title>    
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    
</head>
<body>    

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer>
        <p>&copy; <?php echo e(date('Y')); ?> <a href="https://fcbfrst.com/" target="_blank">fcbfrst.com</a></p>
    </footer>
</body>
</html>
<?php /**PATH E:\FCB\ORACULUM\Oraculum\oraculum\resources\views////layouts/app.blade.php ENDPATH**/ ?>