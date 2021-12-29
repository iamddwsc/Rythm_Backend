<?php

namespace App\Scraper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Song;
use PHPHtmlParser\Dom;
use Illuminate\Http\Response;

class ChartsVN
{
    public function getMp3Url($url) {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $mp3_url = $crawler->filter('ul.list-unstyled > li .download_item')->each(
            function (Crawler $node) {
                // $url = Array(
                //     'url' => $node->attr('href').trim(),
                // );
                $url = $node->attr('href');
                return $url;

            }
        );
        $final_mp3_url = Array(
            '128kbps' => substr($mp3_url[0],0),
            '320kbps' => substr($mp3_url[1],0),
            '500kbps' => substr($mp3_url[2],0),
            // '32kbps' => substr($mp3_url[3],0),
        );
        return response()->json([
            'mp3_url' => $final_mp3_url
        ]);
    }


    public function scrape() {
        $url = 'https://chiasenhac.vn/nhac-hot.html';

        $client = new Client();

        $crawler = $client->request('GET', $url);

        $song_info = $crawler->filter('div.tab-content > #cat-3 > .tab-content > div.tab-pane.fade.tab_bxh.tab_music_bxh > ul.list-unstyled > li.media')->each(
            function (Crawler $node) {
                $id = $node->filter('div.media_tmp > span.counter')->text();
                $song_title = $node->filter('div.media-body > div > h5.media-title > a')->text();
                $song_artist = $node->filter('div.media-body > div > div.author')->text();
                $image = $node->filter('div.media-left > a > img')->attr('src');

                $info[] = Array(
                    'id' => $id,
                    'image' => $image,
                    'song_title' => $song_title,
                    'song_artist' => $song_artist
                );
                return $info;
            }
        );

        return response()->json([
            'success' => true,
            'data' => $song_info
        ]);

        // $stt = $crawler->filter('div.tab-pane.fade.tab_bxh.tab_music_bxh > ul.list-unstyled > li.media > div.media_tmp > span.counter')->each(function ($node) {


        //     return $node->text();
        // });

        // print($stt[0]);

        // $linkmp3 = $crawler->filter('h5.media-title > a')->each(function ($node) {

        //     return $node->attr('href');
        // });

        // print("https://chiasenhac.vn" . $linkmp3[0]);

        // $song = new Song;
        // $song->id = $song_info[0]->id;
        // $song->song_title = $song_info->song_title;
        // $song->song_artist = $song_info->song_artist;
        // $song->image = $song_info->image;
        // $song->save();
    }
}
