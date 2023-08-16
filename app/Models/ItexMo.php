<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class ItexMo extends Model
{

    /**
     * @param array $recipient
     * @return void
     */
    public static function broadcast2d(array $contents) {
        // REFERENCES: DO NOT DELETE
        // $contents sample -
            // - 160 characters per sms
            // - must have unique recipient in every request
            // - 250 maximum charactest for $contents json
            // - 1 message: 1 recipient

        // 'Contents' => [
        //     ["Message" => "Text Message 1", "Recipient" => "099999999"],
        //     ["Message" => "Text Message 2", "Recipient" => "099999991"],
        //     ["Message" => "Text Message 3", "Recipient" => "099999992"],
        // ];

        try {
            $ch = curl_init();

            $email = env('ITEXMO_EMAIL');
            $password = env('ITEXMO_PASSWORD');
            $apiCode = env('ITEXMO_API_KEY');
            $isTestingMode = env('ITEXMO_IS_TESTING', true);

            $itexmo = [
                'Email' => $email,
                'Password' => $password,
                'ApiCode' => $apiCode,
                'Contents' => $contents,
                'SenderId' => "VSY"
            ];

            // DO NOT SEND IF IN TESTING MODE
            if ($isTestingMode == true) {
                return json_encode($contents);
            }

            curl_setopt($ch, CURLOPT_URL, "https://api.itexmo.com/api/broadcast-2d");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($itexmo));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            curl_close($ch);

            return json_encode($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

      /**
     * @param array $recipient
     * @return void
     */
    public static function broadcast(string $message, array $recipients) {
        // REFERENCES: DO NOT DELETE

        // {
        //     "Email": "itexmoclient@gmail.com",
        //     "Password": "123456789ABCD ",
        //     "Recipients": [ "09123456789", "09123456788"],
        //     "Message": "Test message.",
        //     "ApiCode": "PR-SAMPL123456_ABCDE",
        //     "SenderId": "ITEXMO SMS"
        //     }

        try {
            $ch = curl_init();

            $email = env('ITEXMO_EMAIL');
            $password = env('ITEXMO_PASSWORD');
            $apiCode = env('ITEXMO_API_KEY');
            $isTestingMode = env('ITEXMO_IS_TESTING', true);

            $itexmo = [
                'Email' => $email,
                'Password' => $password,
                'ApiCode' => $apiCode,
                'Message' => $message,
                'Recipients' => $recipients,
                'SenderId' => "VSY"
            ];

            // DO NOT SEND IF IN TESTING MODE
            if ($isTestingMode == true) {
                return json_encode([
                    'Message' => $message,
                    'Recipients' => $recipients
                ]);
            }

            curl_setopt($ch, CURLOPT_URL, "https://api.itexmo.com/api/broadcast");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($itexmo));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
            curl_close($ch);

            return json_encode($response);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    // Itexmo Notes


    // https://api.itexmo.com/api/broadcast-2d
    // 1 message : 1 recipient

    // REQUEST

    // {
    //     "Email": "itexmoclient@gmail.com",
    //     "Password": "123456789ABCD ",
    //     "Contents": [ { "Message": "Test Message 1", "Recipient": "09123456789" }, { "Message": "Test Message 1", "Recipient": "09123456789" } ],
    //     "ApiCode": "PR-SAMPL123456_ABCDE",
    //     "SenderId": "ITEXMO SMS"
    //     }

    // RESPONSE

    // SUCCESS
    // {
    //     "DateTime": "2020-01-03 15:04:33",
    //     "Error": false,
    //     "TotalSMS": 1,
    //     "Accepted": 1,
    //     "TotalCreditUsed": 1,
    //     "Failed": 0,
    //     "ReferenceId": "PRSAM75814724521785347215"
    // }


    // FAILED
    // {
    //     "DateTime": "2023-01-03 15:08:58",
    //     "Error": true,
    //     "Message": "ITEXMO email and password is required."
    // }



    // https://api.itexmo.com/api/broadcast
    // 1 message :  many recipient recipient


// {
//     "Email": "itexmoclient@gmail.com",
//     "Password": "123456789ABCD ",
//     "Recipients": [ "09123456789", "09123456788 "],
//     "Message": "Test message.",
//     "ApiCode": "PR-SAMPL123456_ABCDE",
//     "SenderId": "ITEXMO SMS"
//     }

}

