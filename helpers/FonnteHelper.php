<?php
namespace app\helpers;

class FonnteHelper
{
    public static function kirimWa($noHp, $pesan)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $noHp,
                'message' => $pesan,
                'delay' => '2',
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . \Yii::$app->params['fonnteToken'] // simpan token di params.php
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            \Yii::error("Fonnte WA Error: " . curl_error($curl), __METHOD__);
        }
        curl_close($curl);

        return $response;
    }
}
