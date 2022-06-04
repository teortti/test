<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class ClientController extends Controller
{
    public function getalbumdata(){
       $url='http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=349b8b4ba2caef68a43b1509934c8d8d&artist=Mg%C5%82a&album=With%20Hearts%20Toward%20None&format=json';

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_URL, $url);

       $response=curl_exec($ch);
       $data=json_decode($response, true);
       curl_close($ch);
       echo "<pre>";
       print_r($data);
    }
}
