<?php

namespace App\Console\Commands;

use App\Models\ApiUser;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetApiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:getData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get user data from Schulcampusport API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://schulcampus.securon.eu/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials&client_id=" . config('app.client_id') . "&client_secret=" . config('app.client_secret'),
            CURLOPT_HTTPHEADER => [
                "content-type: application/x-www-form-urlencoded"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $access_token = json_decode($response)->access_token;
        };

        if ($access_token) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://schulcampus.securon.eu/ims/oneroster/v1p1/users?offset=0",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "authorization: Bearer " . $access_token,
                    "content-type: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $count = 0;
                $users = json_decode($response, true);
                foreach ($users as $user) {
                    foreach ($user as $key => $value) {
                        $exists = ApiUser::where('sourcedId', $value['sourcedId'])->first();
                        if (!$exists) {
                            $count += 1;
                            $toSave = ApiUser::create([
                                'sourcedId' => $value['sourcedId'],
                                'username' => $value['username'],
                                'status' => $value['status'],
                                'givenName' => $value['givenName'],
                                'familyName' => $value['familyName'],
                                'role' => $value['role'],
                            ]);
                        }
                    }
                }
            }
        }
        echo $count . ' new records saved.';
        return 0;
    }
}
