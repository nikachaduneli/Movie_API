<?php
require_once __DIR__.'/dbFunctions.php';

$connection = createConnection();

$movies = selectAll($connection);

require_once 'search_history_html.php';

mysqli_close($connection);