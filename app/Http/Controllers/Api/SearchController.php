<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class SearchController extends Controller
{
    public function getSearch(Request $request) {
        $key = $request->myQuery;
        $key = str_replace('+', ' ', $key);
        $url = 'https://chiasenhac.vn/tim-kiem?q=';
        $seeker = $url.$key;

        $client = new Client();
        $crawler = $client->request('GET', $seeker);

        $seeker_info = $crawler->filter('.tab-pane > ul.list-unstyled > li')->each(
            function (Crawler $node) {
                $seeker_title = $node->eq(0)->filter('.media-body .media-title')->text();
                $seeker_href = 'https://chiasenhac.vn/'.$node->eq(0)->filter('.media-left > a')->attr('href');
                $seeker_artist = $node->eq(0)->filter('.media-body .author')->text();
                $seeker_image = $node->eq(0)->filter('.media-left > a > img')->attr('src');
                $seeker_total_view = $node->eq(0)->filter('.media-right .time_stt')->text();
                $seeker_quality = $node->eq(0)->filter('.media-body .c1')->text();

                $client2 = new Client();
                $crawler2 = $client2->request('GET',$seeker_href);
                $song = $crawler2->filter('.container .col-md-9')->each(
                    function (Crawler $node) {
                        $song_image = $node->filter('#companion_cover > img')->attr('src');
                        $song_title = $node->filter('.card-body .card-title')->text();
                        $song_artist = $node->filter('.list-unstyled > li')->eq(0)->filter('a')->text();
                        // $song_of_artist = $node->filter('.list-unstyled > li')->filter('a')->text();
                        // $song_of_album = $node->filter('.list-unstyled > li')->eq(2)->text();
                        // $song_date_release = $node->filter('.list-unstyled > li')->eq(3)->text();
                        // $song_date_release = substr($song_date_release,18);
                        $mp3_url_128 = $node->filter('ul.list-unstyled > li .download_item')->eq(0)->attr('href');
                        $mp3_url_320 = $node->filter('ul.list-unstyled > li .download_item')->eq(1)->attr('href');
                        $mp3_url_500 = $node->filter('ul.list-unstyled > li .download_item')->attr('href');
                        $song_info_arr = Array(
                            'song_image' => $song_image,
                            'song_title' => $song_title,
                            'song_artist' => $song_artist,
                            //'song_of_artist' => $song_of_artist,
                            // 'song_of_album' => $song_of_album,
                            //'song_date_release' => $song_date_release,
                            'mp3_url_128' => $mp3_url_128,
                            'mp3_url_320' => $mp3_url_320,
                            'mp3_url_500' => $mp3_url_500,
                        );
                        return $song_info_arr;
                    }
                );
                $search_info = Array(
                    'seeker_title' => $seeker_title,
                    'seeker_href' => $seeker_href,
                    'seeker_artist' => $seeker_artist,
                    'seeker_image' => $seeker_image,
                    'total_view' => $seeker_total_view,
                    'quality' => $seeker_quality,
                    'song_info' => $song,
                );
                return $search_info;
            }
        );
        $data = array();
        for ($i = 0; $i < 5; $i++) {
            $data[$i] = $seeker_info[$i];
        }
        return response()->json([
            'success' => true,
            'seeker_info' => $data,
        ]);
    }
}
