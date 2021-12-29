<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPHtmlParser\Dom;
use Illuminate\Http\Response;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;


class treeChiasenhac extends Controller
{   
    public function scrape() {
        require_once('simple_html_dom.php');
        $base = 'https://chiasenhac.vn/nghe-album/tell-ur-mom-ii-remake-cukak-remix-single-xss6dmswqkm849.html';
        $query = urlencode('librarianship');

        $html = file_get_html($base);
        return $html;
    }


    public function test()
    {
        require_once('simple_html_dom.php');
        // http://simplehtmldom.sourceforge.net/manual_api.htm

        $base = 'https://chiasenhac.vn/mp3/vietnam.html';

        $html = file_get_html($base);
        //return $html;

        // foreach ($html->find('img') as $element)
        //     echo $element->src . '<br>';

        // // Find all links
        // foreach ($html->find('a') as $element)
        //     echo $element->href . '<br>';

        $client = new Client();

        $crawler = $client->request('GET', $base);

        return $crawler;

        $crawler->filter('li')->each(function($node) {
            $node->filter('a')->each(function($nested_node) {
              echo $nested_node -> name();
            });
          });

        // $result = $crawler->nodeName();
        // return response()->json([
        //     'success' => true,
        //     'slider_info' => $result
        // ]);
    }

    public function test1()
    {
        // $html = <<<'HTML'
        //     <!DOCTYPE html>
        //     <html>
        //         <body>
        //             <p class="message">Hello World!</p>
        //             <p>Hello Crawler!</p>
        //         </body>
        //     </html>
        //     HTML;

        // $crawler = new Crawler($html);

        // foreach ($crawler as $domElement) {
        //     var_dump($domElement->nodeName);
        //      return response()->json([
        //         'success' => true,
        //         'slider_info' => $domElement -> nodeName
        //     ]);
        // }
        $dom = new Dom;
        $dom->loadStr('<div class="all"><p>Hey bro, <a href="google.com">click here</a><br /> :)</p></div>');
        $a = $dom->find('a')[0];
        echo $a->text; // "click here"
    }
}
