<?php

declare(strict_types=1);

require_once __DIR__ . '/dbFunctions.php';
require_once __DIR__ . '/api.php';

$connection = createConnection();

if(isset($_GET['submit']))
{
    $movie = getMovie($connection);
}
require_once 'search_movie_html.php';

mysqli_close($connection);