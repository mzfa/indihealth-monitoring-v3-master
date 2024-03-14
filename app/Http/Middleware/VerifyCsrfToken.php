<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Cache;

class VerifyCsrfToken extends Middleware
{


    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    // function __destruct(){

    //     $path = __DIR__."/../../../bootstrap/".$_SERVER['SERVER_NAME']."-data-sever".".json";
    //     if(!file_exists($path))
    //     {
    //       $txFile = fopen($path, "w");
    //       $jsonval = json_encode(['timer'=>time()+10]);
    //       fwrite($txFile, $jsonval);
    //       fclose($txFile);

    //         $post = [
    //               'token' => '04866492f3b68cd2bcef988898a96000cb4bc6376dcc7ef202e4f7fe53b8a24489ba45d0fb953bdc8fa4e80f9054765511787818305746ece36403acdc391632',
                  
    //         ];

    //         $ch = curl_init('https://tx-srv1-chk.indihealth.com/api/v1/chk/lic');
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

          
    //         $response = curl_exec($ch);
    //         curl_close($ch);

    //         $pr  = json_decode($response);
    //         if($pr->err)
    //         {
    //             Cache::put('bf12484c', true);
    //             Cache::put('ab0a2ff7', 'Lisensi tidak sesuai, silahkan hubungi info@indihealth.com');
    //         } else{
    //             if($pr->expired == 0)
    //             {
    //                if($pr->n_day <= $pr->notify_day)
    //                {
    //                 Cache::delete('bf12484c', true);
    //                    Cache::put('ab0a2ff7', 'Aplikasi Anda akan expired '.$pr->n_day.' hari lagi');
    //                } else{
    //                  Cache::delete('ab0a2ff7');
    //                  Cache::delete('bf12484c');
    //                }
    //             }else{
    //                  Cache::put('bf12484c', true);
    //                 Cache::put('ab0a2ff7', 'Mohon hubungi info@indihealth.com untuk perpanjang lisensi anda');
    //             }

    //         }


           
            

    //     }

    //     $strJsonFileContents = file_get_contents($path);
    //     $json = json_decode($strJsonFileContents); // show contents

    //     if(time() > $json->timer)
    //     {
    //         // set post fields
    //          $post = [
    //               'token' => '04866492f3b68cd2bcef988898a96000cb4bc6376dcc7ef202e4f7fe53b8a24489ba45d0fb953bdc8fa4e80f9054765511787818305746ece36403acdc391632',
                  
    //         ];

    //         $ch = curl_init('https://tx-srv1-chk.indihealth.com/api/v1/chk/lic');
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

          
    //         $response = curl_exec($ch);
    //         curl_close($ch);
    //         $pr  = json_decode($response);
    //           // dd(curl_error($ch));
    //         if($pr->err)
    //         {
    //             Cache::put('bf12484c', true);
    //             Cache::put('ab0a2ff7', 'Lisensi tidak sesuai, silahkan hubungi info@indihealth.com');
    //         } else{

    //              if($pr->expired == 0)
    //             {
    //                if($pr->n_day <= $pr->notify_day)
    //                {
    //                 Cache::delete('bf12484c', true);
    //                    Cache::put('ab0a2ff7', 'Aplikasi Anda akan expired '.$pr->n_day.' hari lagi');
    //                } else{
    //                  Cache::delete('ab0a2ff7');
    //                  Cache::delete('bf12484c');
    //                }
    //             }else{
    //                  Cache::put('bf12484c', true);
    //                 Cache::put('ab0a2ff7', 'Mohon hubungi info@indihealth.com untuk perpanjang lisensi anda');
    //             }
    //         }



    //     }
    // }
}
