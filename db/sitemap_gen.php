<?php
include('vendor/autoload.php');
include('json2mysql/config.php');
include('json2mysql/include.classloader.php');

header("Content-Type: application/xml; charset=utf-8");
$file = 'sitemap.xml';
unlink($file);
//Main URL
$base_url = "https://kinozone.co/";
//Page base URL
$video_page_base_url = "https://kinozone.co/video-page.php";

$sitemap_head = '<!--?xml version="1.0" encoding="UTF-8"?-->' . PHP_EOL;

$sitemap_head .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemalocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;
$sitemap_head .= '<url>' . PHP_EOL;
$sitemap_head .= '<loc>'.$base_url.'</loc>' . PHP_EOL;
$sitemap_head .= '<changefreq>daily</changefreq>' . PHP_EOL;
$sitemap_head .= '</url>' . PHP_EOL;

file_put_contents($file, $sitemap_head, FILE_APPEND);

    $sql = "SELECT * FROM kinozone.films where nameRu is not null and year<2022 order by year desc, ratingKinopoiskVoteCount desc limit 0,49999";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $sitemap_line = '<url>' . PHP_EOL;
            $sitemap_line .= '<loc>'.$video_page_base_url."?filmId=". $row["kinopoiskId"] .'</loc>' . PHP_EOL;
            $sitemap_line .= '<changefreq>daily</changefreq>' . PHP_EOL;
            $sitemap_line .= '</url>' . PHP_EOL;
            file_put_contents($file, $sitemap_line, FILE_APPEND);
        }
        mysqli_free_result($result);
    }

file_put_contents($file, '</urlset>' . PHP_EOL, FILE_APPEND);

