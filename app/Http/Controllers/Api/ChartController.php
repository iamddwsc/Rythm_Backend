<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class ChartController extends Controller
{
    public function getChart(Request $request) {
        $url = $request->url_info;
        //$url = 'https://chiasenhac.vn/nhac-hot/other.html';
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $albums = $crawler->filter('.d-table .card-footer')->each(
            function (Crawler $node) {
                $item_title = $node->filter('.name > a')->text();
                $item_artist = $node->filter('.author-ellepsis > a')->text();
                $item_href = $node->filter('.tool > ul > li > a')->attr('href');
                $client2 = new Client();
                $crawler2 = $client2->request('GET',$item_href);
                $song = $crawler2->filter('.container .col-md-9')->each(
                    function (Crawler $node) {
                        $song_image = $node->filter('#companion_cover > img')->attr('src');
                        $song_title = $node->filter('.card-body .card-title')->text();
                        $song_artist = $node->filter('.list-unstyled > li')->eq(0)->filter('a')->text();
                        //$song_of_artist = $node->filter('.list-unstyled > li')->eq(1)->filter('a')->text();
                        $song_of_album = $node->filter('.list-unstyled > li')->eq(2)->text();
                        $song_date_release = $node->filter('.list-unstyled > li')->eq(3)->text();
                        $song_date_release = substr($song_date_release,18);

                        $mp3_url_128 = $node->filter('ul.list-unstyled > li .download_item')->eq(0)->attr('href');
                        $mp3_url_320 = $node->filter('ul.list-unstyled > li .download_item')->eq(1)->attr('href');
                        $mp3_url_500 = $node->filter('ul.list-unstyled > li .download_item')->attr('href');
                        $song_info_arr = Array(
                            's_image' => $song_image,
                            's_title' => $song_title,
                            's_artist' => $song_artist,
                            'mp3_url_128' => $mp3_url_128,
                            'mp3_url_320' => $mp3_url_320,
                            'mp3_url_500' => $mp3_url_500,
                        );
                        return $song_info_arr;
                    }
                );
                $album = Array(
                    'title' => $item_title,
                    'artist' => $item_artist,
                    'href' => $item_href,
                    'song' => $song
                );
                return $album;
            }
        );
        $data = array();
        for ($i = 0; $i < 12; $i++) {
            $data[$i] = $albums[$i];
        }
        return response()->json([
            'success' => true,
            'info' => $data,
        ]);
    }
}
