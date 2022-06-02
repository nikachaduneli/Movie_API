<?php
declare(strict_types=1);

const MOVIEAPI  = 'https://api.themoviedb.org/3/search/movie?api_key=15d2ea6d0dc1d476efbca3eba2b9bbfb&query=';
const POSTERURL = 'https://image.tmdb.org/t/p/w500/';


function getAPIData(string $url):array
{
    $ch = curl_init();
    $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $json_data = curl_exec($ch);

    curl_close($ch);

    return json_decode($json_data, true);
}

function getPoster(?string $poster_path):string
{
    if($poster_path===null){
        return file_get_contents('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1f4C-cWV03_czRXhL1THkOdS9RDnAtPxRnA&usqp=CAU');
    }
    return file_get_contents(POSTERURL.$poster_path);
}

function filterData(array $data):array
{
    $data = $data['results'][0];

    $poster = getPoster($data['poster_path']);

    return ['title'=>$data['original_title'],
            'poster'=>$poster,
            'overview'=>$data['overview'],
            'release_date'=>$data['release_date']];
}

function getMovie(mysqli $connection):array
{
    if($_GET['title'] !== '')
    {
        $film = $_GET['title'];
        $film = str_replace(" ", '%20',$film);

        $api_data = getAPIData(MOVIEAPI.$film);

        if(count($api_data['results'])!==0)
        {
            $filtered_data = filterData($api_data);
            insertIntoTable($connection, $filtered_data);
            return select($connection, $filtered_data['title']);
        }
        return ['error'=>'Couldn\'t Find Any Movie With Name "'.str_replace('%20',' ', $film).'"'];
    }
    return ['error'=>'Please Enter Movie Name'];
}