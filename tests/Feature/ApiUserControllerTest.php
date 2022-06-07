<?php

namespace Tests\Feature;

use App\Http\Controllers\ApiUsersController;
use App\Models\ApiUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Nette\Utils\Random;
use Tests\TestCase;

class ApiUserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_search_request()
    {
        $response = $this->post('get-results/');
        $response->assertStatus(200);
    }

    public function test_json_response()
    {

        $user = ApiUser::create([
            'sourcedId' => '123456789',
            'username' => 'test',
            'status' => 'active',
            'givenName' => 'Carlotta',
            'familyName' => 'test',
            'role' => 'student',
        ]);

        $this->assertTrue($user->givenName == 'Carlotta');

        $response = $this->post('get-results/', ['searchInput' => 'Carlotta']);
        $data = $response->getData();
        $this->assertTrue($data[0]->givenName == 'Carlotta');

        $response = $this->post('get-results/', ['searchInput' => 'carlotta']);
        $data = $response->getData();
        $this->assertTrue($data[0]->givenName == 'Carlotta');
    }
}
