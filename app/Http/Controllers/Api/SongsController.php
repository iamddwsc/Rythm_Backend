<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Song;

class SongsController extends Controller
{
    public function getLyric(Request $request) {
        // $bot = new \App\Scraper\ChartsVN();
        // $bot->scrape();
        $url = $request->url_info;
        //$url ='https://chiasenhac.vn/mp3/mone-kamishiraishi/shiroidoro-tsvmqw3rq8e9wa.html';
        //$url = 'https://chiasenhac.vn/nghe-album/dynamite-deluxe-xss73wd6qtw9mk.html';

        $client = new Client();

        $crawler = $client->request('GET', $url);

        $lyric = $crawler->filter('article #fulllyric')->each(function ($node) {

            //return $node->html();
            return $node->html();
        });
        $lyric = str_replace("\n", "||", $lyric);
        $lyric = str_replace("<br>\r", "", $lyric);
        $lyric = str_replace("</div>", "", $lyric);
        $lyric = str_replace("<div class=\"vietsub1 sub_line\">", "", $lyric);
        $lyric = str_replace('"', "", $lyric);
        $lyric = str_replace("  ", "", $lyric);
        $arr = explode("||", $lyric[0]);
        return response()->json([
            'success' => true,
            'data' => $arr,
        ]);
    }
}
