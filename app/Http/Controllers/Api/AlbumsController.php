<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class AlbumsController extends Controller
{
    public function getAlbum(Request $request) {
        $url = $request->url_info;
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $albums = $crawler->filter('.d-table .card-footer')->each(
            function (Crawler $node) {
                $item_title = $node->filter('.name > a')->text();
                $item_artist = $node->filter('.author-ellepsis')->text();
                $item_href = $node->filter('.tool > ul > li > a')->attr('href');
                $client2 = new Client();
                $crawler2 = $client2->request('GET',$item_href);
                $song = $crawler2->filter('.container .col-md-9')->each(
                    function (Crawler $node) {
                        $song_image = $node->filter('#companion_cover > img')->attr('src');
                        $song_title = $node->filter('.card-body .card-title')->text();
                        $li_count = $node->filter('.card-body > .list-unstyled > li')->count();
                        if ($li_count < 4) {
                            $song_singer_count = $node->filter('.list-unstyled > li')->eq(0)->filter('a')->count(); 
                            $song_singer = $node->filter('.list-unstyled > li')->eq(0)->filter('a');
                            $z = array();
                            for ($i = 0; $i < $song_singer_count; $i++) {
                                array_push($z, $song_singer->eq($i)->text());
                            }
                            $z = implode(', ', $z);
                            $song_of_album = $node->filter('.list-unstyled > li')->eq(1)->filter('a')->text();
                            $song_date_release = $node->filter('.list-unstyled > li')->eq(2)->text();
                            $song_date_release = substr($song_date_release,18);
                            $songwriter = '';
                        } else {
                            $song_singer_count = $node->filter('.list-unstyled > li')->eq(0)->filter('a')->count();                   
                            $song_singer = $node->filter('.list-unstyled > li')->eq(0)->filter('a');
                            $z = array();
                            for ($i = 0; $i < $song_singer_count; $i++) {
                                array_push($z, $song_singer->eq($i)->text());
                            }
                            $z = implode(', ', $z);
                            $songwriter = $node->filter('.list-unstyled > li')->eq(1)->filter('a')->text();
                            $song_of_album = $node->filter('.list-unstyled > li')->eq(2)->filter('a')->text();
                            $song_date_release = $node->filter('.list-unstyled > li')->eq(3)->text();
                            $song_date_release = substr($song_date_release,18);
                        }
                        //$song_artist = $node->filter('.list-unstyled > li')->eq(0)->filter('a')->text();
                        
                        
                        // $child = $node->filter('ul.list-unstyled > li .download_item')->count();
                        // if ($child >= 5) {
                        $mp3_url_128 = $node->filter('ul.list-unstyled > li .download_item')->eq(1)->attr('href');
                        $mp3_url_320 = str_replace('/128/', '/320/', $mp3_url_128);
                        $mp3_url_500 = str_replace(array('/128/', '.mp3'), array('/m4a/','.m4a'), $mp3_url_128);
                        $lossless = str_replace(array('/128/', '.mp3'), array('/flac/','.flac'), $mp3_url_128);
                            //$mp3_url_320 = $node->filter('ul.list-unstyled > li .download_item')->eq(2)->attr('href');
                            //$mp3_url_500 = $node->filter('ul.list-unstyled > li .download_item')->eq(3)->attr('href');
                        // } else {
                        //     $mp3_url_128 = $node->filter('ul.list-unstyled > li .download_item')->eq(1)->attr('href');
                        //     $pos = strpos($mp3_url_128, '/128/');
                        //     $mp3_url_320 = '';
                        //     $mp3_url_500 = '';
                        // }
                        // $mp3_url_500 = $node->filter('ul.list-unstyled > li .download_item')->eq(3)->attr('href');
                        $song_info_arr = Array(
                            'song_image' => $song_image,
                            'song_title' => $song_title,
                            'song_singer' => $z,
                            'songwriter' => $songwriter,
                            'song_of_album' => $song_of_album,
                            'song_date_release' => $song_date_release,
                            'mp3_url_128' => $mp3_url_128,
                            'mp3_url_320' => $mp3_url_320,
                            'mp3_url_500' => $mp3_url_500,
                            'lossless' => $lossless
                            //'pos' => $pos
                            //'child' => $li_count
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
