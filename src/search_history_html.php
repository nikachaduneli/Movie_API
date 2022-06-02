
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-zinc-300">
<?php require_once 'nav_html.php'; ?>
<div class="w-full grid grid-cols-3 gap-4 content-around m-14">
    <?php foreach ($movies as $movie):?>
        <div class="max-w-sm bg-teal-200 p-10 rounded ">
            <h1 class="font-mono text-2xl mb-1.5"><?= $movie['title'] ?></h1>
            <img class="max-w-60 max-h-60" src="data:image/jpg;charset=utf8;base64,<?= base64_encode($movie['poster']); ?>"/>
            <p class="font-mono"><strong>overview</strong><br><?= $movie['overview'] ?></p>
            <p class="font-medium">Released In <?=date('Y',strtotime($movie['release_date'])) ?></p>
        </div>
    <?php endforeach ?>
</div>
</body>
</html>
