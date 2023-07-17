<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Container PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <h3 class="text-center">Pastas e arquivos</h3><hr>
    <nav class="nav justify-content-center">
        <ul class="nav">
            <?php 
                $path = getcwd()."/";
                $diretorio = dir($path);

                while($arquivo = $diretorio -> read()){
                    if($arquivo != '.' && 
                       $arquivo != '..' && 
                       $arquivo != 'index.php' && 
                       $arquivo != 'img'
                       ){
            ?>

            <li class="nav-item">
                <a class="nav-link fs-5" href="<?php echo($arquivo); ?>">
                    <?php echo($arquivo); ?>
                </a>
            </li>

            <?php 
                    }
                } 

                $diretorio -> close();
            ?>
        </ul>
    </nav>

    <hr>
    
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-2">
                <img src="img/docker_img.png" alt="" style="height: 90px;">
            </div>
            <div class="col-2">
                <img src="img/php_logo.png" alt="" style="height: 90px;">
            </div>
            <div class="col-2">
                <img src="img/apache_logo.png" alt="" style="height: 90px;">
            </div>
        </div>
    </div>
    
    <br>
    
    <p class="text-center"><b>Version PHP:</b> <?php echo(phpversion()); ?></p>
</body>
</html>