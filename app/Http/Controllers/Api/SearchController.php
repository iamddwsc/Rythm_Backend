<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class SearchController extends Controller
{
    public function getSearchSong(Request $request) {
        $key = $request->myQuery;
        $key = str_replace(' ', '+', $key);
        $url = 'https://chiasenhac.vn/tim-kiem?q=';
        // $seeker = $url.$key.'&page_music=1&filter=';
        $seeker = $url.$key.'&page_music=1&filter=';
        $client = new Client();
        $crawler = $client->request('GET', $seeker);

        // $seeker_info = $crawler->filter('div#nav-album')->filter('div.col')->each(
        //     function (Crawler $node) {
        //         $seeker_title = $node->filter('.card-title')->text();
        //         $seeker_artist = $node->filter('.card-text')->text();
        //         $seeker_artist = str_replace(';',',',$seeker_artist);
        //         $seeker_href = 'https://chiasenhac.vn'.$node->filter('a')->attr('href');
        //         $seeker_image = $node->filter('')->eq(2)->attr('style');
        //         $seeker_image = substr($seeker_image, 22, -2);
        //         $search_info = Array(
        //             'item_title' => $seeker_title,
        //             'item_artist' => $seeker_artist,
        //             'item_image' => $seeker_image,
        //             'item_href' => $seeker_href,
        //                         // 'total_view' => $seeker_total_view,
        //                         // 'quality' => $seeker_quality,
        //                         //'song_info' => $song,
        //         );
        //         return $search_info;
        //     }
        // );

        $seeker_info2 = $crawler->filter('div#nav-music')->filter('.list-unstyled > li');
        $result2 = Array();
        if ($seeker_info2->count() > 0) {
           $count = $seeker_info2->count();
            if ($seeker_info2->children()) {
                for($i = 0; $i < $count; $i++) {
                    $node = $seeker_info2->eq($i);
                    $seeker_title = $node->filter('div.media-body > div > p > a')->text();
                    $seeker_artist = $node->filter('div.media-body > div > div.author')->text();
                    $seeker_artist = str_replace(';',',',$seeker_artist);
                    $seeker_href = $node->filter('a')->attr('href');
                    $seeker_image = $node->filter('a > img')->attr('src');
                    // $seeker_image = substr($seeker_image, 22, -2);
                    $search_info = Array(
                        'item_title' => $seeker_title,
                        'item_artist' => $seeker_artist,
                        'item_image' => $seeker_image,
                        'item_href' => $seeker_href,
                                   // 'total_view' => $seeker_total_view,
                                    // 'quality' => $seeker_quality,
                                    //'song_info' => $song,
                    );
                //return $search_info;
                array_push($result2, $search_info);
                }
            }
        }
        //$result = $seeker_info->count();

        return response()->json([
            'success' => true,
            'seeker_result' => $result2,
            'seeker' => $seeker
        ]);
    }

    public function getSearch(Request $request) {
        $key = $request->myQuery;
        $key = str_replace(' ', '+', $key);
        $url = 'https://chiasenhac.vn/tim-kiem?q=';
        $seeker = $url.$key;//.'&page_album=1&filter=';
        $client = new Client();
        $crawler = $client->request('GET', $seeker);

        $seeker_info = $crawler->filter('div#nav-album')->filter('div.col');
        $result = Array();
        if ($seeker_info->count() > 0) {
           $count = $seeker_info->count();
            if ($seeker_info->children()) {
                for($i = 0; $i < $count; $i++) {
                    $node = $seeker_info->eq($i);
                    $seeker_title = $node->filter('.card-title')->text();
                    $seeker_artist = $node->filter('.card-text')->text();
                    $seeker_artist = str_replace(';',',',$seeker_artist);
                    $seeker_href = 'https://chiasenhac.vn'.$node->filter('a')->attr('href');
                    $seeker_image = $node->filter('')->eq(2)->attr('style');
                    $seeker_image = substr($seeker_image, 22, -2);
                    $search_info = Array(
                        'item_title' => $seeker_title,
                        'item_artist' => $seeker_artist,
                        'item_image' => $seeker_image,
                        'item_href' => $seeker_href,
                                   // 'total_view' => $seeker_total_view,
                                    // 'quality' => $seeker_quality,
                                    //'song_info' => $song,
                    );
                //return $search_info;
                array_push($result, $search_info);
                }
            }
        }

        $seeker_info2 = $crawler->filter('div#nav-music')->filter('.list-unstyled > li');
        $result2 = Array();
        if ($seeker_info2->count() > 0) {
           $count = $seeker_info2->count();
            if ($seeker_info2->children()) {
                for($i = 0; $i < $count; $i++) {
                    $node = $seeker_info2->eq($i);
                    $seeker_title = $node->filter('div.media-body > div > p > a')->text();
                    $seeker_artist = $node->filter('div.media-body > div > div.author')->text();
                    $seeker_artist = str_replace(';',',',$seeker_artist);
                    $seeker_href = $node->filter('a')->attr('href');
                    $seeker_image = $node->filter('a > img')->attr('src');
                    // $seeker_image = substr($seeker_image, 22, -2);
                    $search_info = Array(
                        'item_title' => $seeker_title,
                        'item_artist' => $seeker_artist,
                        'item_image' => $seeker_image,
                        'item_href' => $seeker_href,
                                   // 'total_view' => $seeker_total_view,
                                    // 'quality' => $seeker_quality,
                                    //'song_info' => $song,
                    );
                //return $search_info;
                array_push($result2, $search_info);
                }
            }
        }
        //$result = $seeker_info->count();
        $all_result = Array(
            'album' => $result,
            'song' => $result2
        );
        return response()->json([
            'success' => true,
            'seeker_result' => $all_result,
            'seeker' => $seeker
        ]);
    }
}
