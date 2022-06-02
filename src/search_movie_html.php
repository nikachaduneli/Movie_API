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
<form action="index.php" method="get" class="w-full  grid place-items-center my-5">
    <div class=" flex items-center border-b rounded  p-2 bg-neutral-100 ml-10 border-teal-500 py-2">
        <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
               type="text" name="title" placeholder="enter movie name...">
        <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
                type="submit" name="submit">Search</button>
    </div>
</form>
<?php if(! $movie['error'] && $movie !== null):?>
    <div class="grid place-items-center ">
        <div class="max-w-sm bg-teal-200 p-10 rounded ">
            <h1 class="font-mono text-2xl mb-1.5"><?= $movie['title'] ?></h1>
            <img class="max-w-60 max-h-60" src="data:image/jpg;charset=utf8;base64,<?= base64_encode($movie['poster']); ?>"/>
            <p class="font-mono"><strong>overview</strong><br><?= $movie['overview'] ?></p>
            <p class="font-medium">Released In <?=date('Y',strtotime($movie['release_date'])) ?></p>
        </div>
    </div>
<?php elseif($movie['error']): ?>
        <div class="grid place-items-center ">
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                <h1 class="font-medium text-lg"><?= $movie['error']?></h1>
            </div>
        </div>
<?php endif ?>
</body>
</html>