<html lang="en">
<head>
    <title>devbox</title>
</head>
<body>
    <h1 style="text-align: center"><?php echo "Your devbox is working!"; ?></h1>
    <?php
        phpinfo();
        $foo = 'bar';
        if ($foo) {
            # test your xdebug here
            $foo = 'baz';
        }
    ?>
</body>
</html>
