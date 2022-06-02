<?php
declare(strict_types=1);

const HOSTNAME  = "localhost";
const USER      = "root";
const PASSWORD  = "root";
const DATABASE  = "bitoid";

function createConnection()
{
    try{
        $connection = mysqli_connect(HOSTNAME, USER, PASSWORD);
        $connection->query('CREATE DATABASE IF NOT EXISTS '.DATABASE);

        return mysqli_connect(HOSTNAME, USER, PASSWORD, DATABASE);
    }
    catch(Exception $e){
        ?>
        <h1>Couldn't Connect To Database "<?=DATABASE?>"</h1>
        <?php
        exit();
    }
}

function createTable(mysqli $connection):void
{
    $query = 'CREATE TABLE IF NOT EXISTS Movies (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    poster LONGBLOB,
    overview TEXT,
    release_date TIMESTAMP
    )';

    $connection->query($query);
}

function insertIntoTable(mysqli $connection, array $values):void
{
    if (select($connection, $values['title'])['title'] === null){
        $query = "INSERT INTO Movies(title,poster,overview,release_date)
              VALUES(?,?,?,?)";

        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt,'ssss',$values['title'],$values['poster'],
                                                            $values['overview'],$values['release_date']);
        mysqli_stmt_execute($stmt);
    }
}

function select(mysqli $connection, string $keyword='*'):array
{

    $query = "SELECT * FROM Movies WHERE title like ?";

    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt,'s', $keyword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id,$title, $poster, $overview,$release_date );
    mysqli_stmt_fetch($stmt);

    if($title === null){
        return ['error'=>'could\'t find movie in database'];
    }
    return ['title'=>$title, 'poster'=>$poster, 'overview'=>$overview,'release_date'=>$release_date];

}

function selectAll(mysqli $connection):array
{
    $query = 'SELECT * FROM Movies';
    $data = [];
    $result = $connection->query($query);

    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return  $data;
}