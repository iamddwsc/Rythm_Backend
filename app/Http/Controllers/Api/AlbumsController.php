<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class AlbumsController extends Controller
{
    public function getAlbum(Request $request) {
        //$url = 'https://chiasenhac.vn/nghe-album/the-baddest-single-xss73mszqtw841.html#_=_';
        #$url = 'https://chiasenhac.vn/nghe-album/anh-mai-la-duy-nhat-single-xss6dwvzqkm921.html';
        $url = $request->url_info;
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
                        $song_of_album = $node->filter('.list-unstyled > li')->eq(1)->filter('a')->text();
                        $song_date_release = $node->filter('.list-unstyled > li')->eq(3)->text();
                        $song_date_release = substr($song_date_release,18);
                        $child = $node->filter('ul.list-unstyled > li .download_item')->count();
                        if ($child >= 5) {
                            $mp3_url_128 = $node->filter('ul.list-unstyled > li .download_item')->eq(1)->attr('href');
                            $mp3_url_320 = $node->filter('ul.list-unstyled > li .download_item')->eq(2)->attr('href');
                            $mp3_url_500 = $node->filter('ul.list-unstyled > li .download_item')->eq(3)->attr('href');
                        } else {
                            $mp3_url_128 = $node->filter('ul.list-unstyled > li .download_item')->eq(1)->attr('href');
                            $mp3_url_320 = '';
                            $mp3_url_500 = '';
                        }
                        // $mp3_url_500 = $node->filter('ul.list-unstyled > li .download_item')->eq(3)->attr('href');
                        $song_info_arr = Array(
                            'song_image' => $song_image,
                            'song_title' => $song_title,
                            'song_artist' => $song_artist,
                            'song_of_album' => $song_of_album,
                            'song_date_release' => $song_date_release,
                            'mp3_url_128' => $mp3_url_128,
                            'mp3_url_320' => $mp3_url_320,
                            'mp3_url_500' => $mp3_url_500,
                            'child' => $child
                        );
                        return $song_info_arr;
                    }
                );
                $album = Array(
                    'item_title' => $item_title,
                    'item_artist' => $item_artist,
                    'item_href' => $item_href,
                    'song' => $song
                );
                #$album = mb_convert_encoding($album['item_artist'], 'UTF-8', 'auto');
                // $album = mb_convert_encoding($album['item_artist'], 'UTF-8', 'auto');
                // $album = mb_convert_encoding($album['item_href'], 'UTF-8', 'auto');
                // $album = mb_convert_encoding($album['song'], 'UTF-8', 'auto');
                return $album;
            }
        );
        return response()->json([
            'success' => true,
            'album_info' => $albums
        ]);
    }
}
