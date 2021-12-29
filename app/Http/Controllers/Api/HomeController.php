<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Song;
use App\Scraper\ChartsVn;

class HomeController extends Controller
{
    public function getSlider(Request $request) {
        $url = 'https://chiasenhac.vn';

        $client = new Client();

        $crawler = $client->request('GET', $url);

        $slider_info = $crawler->filter('div.slide_home .owl-carousel .item')->each(
            function (Crawler $node) {
                $slider_id = $node->filter('.card-body > span.card-text')->text();
                $slider_image = $node->filter('.card-header')->attr('style');
                $slider_title = $node->filter('.card-body > .card-title')->text();
                $slider_artist = $node->filter('.author > a')->text();
                $slider_href = 'https://chiasenhac.vn'.$node->filter('.card-header > a')->attr('href');
                $slider_image = substr($slider_image, 22, -2);
                //$mp3_url = $this->getMp3Url($slider_href);

                $info = Array(
                    'slider_id' => $slider_id,
                    'slider_image' => $slider_image,
                    'slider_title' => $slider_title,
                    'slider_artist' => $slider_artist,
                    'slider_href' => $slider_href,
                );
                return $info;
            }
        );
        return response()->json([
            'success' => true,
            'slider_info' => $slider_info
        ]);
    }

    public function getNewAlbum2020_vn() {
        $url   = 'https://chiasenhac.vn/mp3/vietnam.html';
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $new_album_vn = $crawler->filter('div.container .row_wrapper .col-md-9 .col')->each(
            function (Crawler $node, $i) {
                //$dir_title = $node->filter('.media')->text();
                $item_title = $node->filter('a')->eq(1)->text();
                $item_artist = $node->filter('.card-text')->text();
                $item_image = $node->filter('')->eq(2)->attr('style');
                $item_image = substr($item_image, 22, -2);
                $item_href = 'https://chiasenhac.vn'.$node->filter('a')->eq(0)->attr('href');
                $info = Array(
                    'item_title' => $item_title,
                    'item_artist' => $item_artist,
                    'item_image' => $item_image,
                    'item_href' => $item_href
                );
                
                return $info;
                
            }
        );
        return response()->json([
            'success' => true,
            'new_album' => $new_album_vn,
        ]);
    }
    public function getNewAlbum2020_usuk() {
        $url   = 'https://chiasenhac.vn/mp3/us-uk.html';
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $new_album_usuk = $crawler->filter('div.container .row_wrapper .col-md-9 .col')->each(
            function (Crawler $node) {
                //$dir_title = $node->filter('.media')->text();
                $item_title = $node->filter('a')->eq(1)->text();
                $item_artist = $node->filter('.card-text')->text();
                $item_image = $node->filter('')->eq(2)->attr('style');
                $item_image = substr($item_image, 22, -2);
                $item_href = 'https://chiasenhac.vn'.$node->filter('a')->eq(0)->attr('href');
                $info = Array(
                    'item_title' => $item_title,
                    'item_artist' => $item_artist,
                    'item_image' => $item_image,
                    'item_href' => $item_href
                );
                return $info;
            }
        );
        // $data_new_album_2020 = array();
        // for($i = 0; $i < 10; $i++) {
        //     $data_new_album_2020[$i] = $new_album_2020[$i];
        // }
        return response()->json([
            'new_album' => $new_album_usuk,
        ]);
    }
    public function getNewAlbum2020_kr() {
        $url  = 'https://chiasenhac.vn/mp3/korea.html';
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $new_album_kr = $crawler->filter('div.container .row_wrapper .col-md-9 .col')->each(
            function (Crawler $node) {
                //$dir_title = $node->filter('.media')->text();
                $item_title = $node->filter('a')->eq(1)->text();
                $item_artist = $node->filter('.card-text')->text();
                $item_image = $node->filter('')->eq(2)->attr('style');
                $item_image = substr($item_image, 22, -2);
                // if($item_image == '') 
                //     $item_image = 'https://developers.google.com/maps/documentation/maps-static/images/error-image-generic.png?hl=vi';
                
                $item_href = 'https://chiasenhac.vn'.$node->filter('a')->eq(0)->attr('href');
                $info = Array(
                    'item_title' => $item_title,
                    'item_artist' => $item_artist,
                    'item_image' => $item_image,
                    'item_href' => $item_href
                );
                return $info;
            }
        );
        // $data_new_album_2020 = array();
        // for($i = 0; $i < 10; $i++) {
        //     $data_new_album_2020[$i] = $new_album_2020[$i];
        // }
        return response()->json([
            'new_album' => $new_album_kr,
        ]);
    }
    public function getNewAlbum2020_cn() {
        $url   = 'https://chiasenhac.vn/mp3/chinese.html';
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $new_album_cn= $crawler->filter('div.container .row_wrapper .col-md-9 .col')->each(
            function (Crawler $node) {
                //$dir_title = $node->filter('.media')->text();
                $item_title = $node->filter('a')->eq(1)->text();
                $item_artist = $node->filter('.card-text')->text();
                $item_image = $node->filter('')->eq(2)->attr('style');
                $item_image = substr($item_image, 22, -2);
                $item_href = 'https://chiasenhac.vn'.$node->filter('a')->eq(0)->attr('href');
                $info = Array(
                    'item_title' => $item_title,
                    'item_artist' => $item_artist,
                    'item_image' => $item_image,
                    'item_href' => $item_href
                );
                return $info;
            }
        );
        // $data_new_album_2020 = array();
        // for($i = 0; $i < 10; $i++) {
        //     $data_new_album_2020[$i] = $new_album_2020[$i];
        // }
        return response()->json([
            'new_album' => $new_album_cn,
        ]);
    }
    public function getNewAlbum2020_jp() {
        $url   = 'https://chiasenhac.vn/mp3/japan.html';
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $new_album_jp = $crawler->filter('div.container .row_wrapper .col-md-9 .col')->each(
            function (Crawler $node) {
                //$dir_title = $node->filter('.media')->text();
                $item_title = $node->filter('a')->eq(1)->text();
                $item_artist = $node->filter('.card-text')->text();
                $item_image = $node->filter('')->eq(2)->attr('style');
                $item_image = substr($item_image, 22, -2);
                $item_href = 'https://chiasenhac.vn'.$node->filter('a')->eq(0)->attr('href');
                $info = Array(
                    'item_title' => $item_title,
                    'item_artist' => $item_artist,
                    'item_image' => $item_image,
                    'item_href' => $item_href
                );
                return $info;
            }
        );
        // $data_new_album_2020 = array();
        // for($i = 0; $i < 10; $i++) {
        //     $data_new_album_2020[$i] = $new_album_2020[$i];
        // }
        return response()->json([
            'new_album' => $new_album_jp,
        ]);
    }
    public function getNewAlbum2020_other() {
        $url   = 'https://chiasenhac.vn/mp3/other.html';
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $new_album_other = $crawler->filter('div.container .row_wrapper .col-md-9 .col')->each(
            function (Crawler $node) {
                $item_title = $node->filter('a')->eq(1)->text();
                $item_artist = $node->filter('.card-text')->text();
                $item_image = $node->filter('')->eq(2)->attr('style');
                $item_image = substr($item_image, 22, -2);
                $item_href = 'https://chiasenhac.vn'.$node->filter('a')->eq(0)->attr('href');
                $info = Array(
                    'item_title' => $item_title,
                    'item_artist' => $item_artist,
                    'item_image' => $item_image,
                    'item_href' => $item_href
                );
                return $info;
            }
        );
        // $data_new_album_2020 = array();
        // for($i = 0; $i < 10; $i++) {
        //     $data_new_album_2020[$i] = $new_album_2020[$i];
        // }
        return response()->json([
            'new_album' => $new_album_other,
        ]);
    }
}
