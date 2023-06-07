<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use voku\helper\HtmlDomParser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class KetQuaSoXoController extends Controller
{
    public $useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36';
    public function index()
    {
        $response = Http::withHeaders([
            'user-agent' => $this->useragent,
        ])->get('https://xoso.mobi/embedded/kq-mienbac?ngay_quay=' . date('d-m-Y'));

        $dom = HtmlDomParser::str_get_html($response->body());
        foreach ($dom->find('table') as $item) {
            if ($item->find('span', 27)->innertext == '') {
                $result[] = array(
                    'status' => 'error',
                    'des' => 'Chưa Tới giờ sổ số nhé'
                );
            }
            $result[] = array(
                'dacbiet' => $item->find('span', 1)->innertext,
                'giai1' => $item->find('span', 2)->innertext,
                'giai2' => $item->find('span', 3)->innertext . '-' . $item->find('span', 4)->innertext,
                'giai3' => $item->find('span', 5)->innertext . '-' . $item->find('span', 6)->innertext . '-' . $item->find('span', 7)->innertext . '-' . $item->find('span', 8)->innertext . '-' . $item->find('span', 9)->innertext . '-' . $item->find('span', 10)->innertext,
                'giai4' => $item->find('span', 11)->innertext . '-' . $item->find('span', 12)->innertext . '-' . $item->find('span', 13)->innertext . '-' . $item->find('span', 14)->innertext,
                'giai5' => $item->find('span', 15)->innertext . '-' . $item->find('span', 16)->innertext . '-' . $item->find('span', 17)->innertext . '-' . $item->find('span', 18)->innertext . '-' . $item->find('span', 19)->innertext . '-' . $item->find('span', 20)->innertext,
                'giai6' => $item->find('span', 21)->innertext . '-' . $item->find('span', 22)->innertext . '-' . $item->find('span', 23)->innertext,
                'giai7' => $item->find('span', 24)->innertext . '-' . $item->find('span', 25)->innertext . '-' . $item->find('span', 26)->innertext . '-' . $item->find('span', 27)->innertext,
            );
        }
        return (object)[
            'status' => 'success',
            'message' => 'KQXS MIỀN BẮC NGÀY ' . date('d-m-Y'),
            'data' => $result[0]
        ];
    }
}
