<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Artisan;
use UsersTableSeeder;

class UserControllerTest extends TestCase
{
    use WithFaker;
    use CreatesApplication, DatabaseMigrations;

    static $user = [
        'email' => 'admin@laravel.com',
        'password' => 'rootUser123#'
    ];

    public function setUp(): void{
        parent::setUp();
        Artisan::call('db:seed');
    }

    public function tearDown(): void{
        parent::tearDown();
    }
    /**
     * should not allow get requests
     *
     * @return void
     * @test
     */
    public function it_should_return_405_for_register()
    {
        $response = $this->get('/api/register');

        $response->assertStatus(405);
    }

    /**
     * should not allow get requests
     *
     * @return void
     * @test
     */
    public function it_should_return_405_for_login()
    {
        $response = $this->get('/api/login');

        $response->assertStatus(405);
    }


    /**
     * create new user 
     *
     * @return void
     * @test
     */
    public function it_should_register_user()
    {
        $response = $this->json('POST', '/api/register', [
            'email'    => $this->faker->email(),
            'name'     => $this->faker->name(),
            'address'  => $this->faker->address(),
            'password' => 'testUser'.rand(10, 100).'#' 
        ]);

        //dd($response);

        $response
        ->assertStatus(200)
        ->assertJsonStructure(['data', 'success']);
    }

    /**
     * should not create new user, validation errors 
     *
     * @return void
     * @test
     */
    public function it_should_not_register_user1()
    {
        $response = $this->json('POST', '/api/register', [
            'name'     => $this->faker->name(),
            'address'  => $this->faker->address(),
            'password' => 'testUser'.rand(10, 100).'#' 
        ]);

        //dd($response);

        $response
        ->assertStatus(422);
    }

    /**
     * should not create new user, validation errors 
     *
     * @return void
     * @test
     */
    public function it_should_not_register_user2()
    {
        $response = $this->json('POST', '/api/register', [
            'email'    => $this->faker->email(),
            'name'     => $this->faker->name(),
            'address'  => $this->faker->address(),
        ]);

        //dd($response);

        $response
        ->assertStatus(422);
    }

    /**
     * should not create new user, duplicate email 
     *
     * @return void
     * @test
     */
    public function it_should_not_register_user3()
    {
        $response = $this->json('POST', '/api/register', [
            'email'    => $this->faker->email(),
            'name'     => $this->faker->name(),
            'address'  => $this->faker->address(),
            'password' => User::all()->random()->email 
        ]);

        //dd($response);

        $response
        ->assertStatus(422);
    }

    /**
     * create awt token for user 
     *
     * @return void
     * @test
     */
    public function it_should_generate_and_send_awt_token()
    {

        $response = $this->json('POST', '/api/login', [
            'email'    => static::$user['email'],
            'password' => static::$user['password']
        ]);

        //dd($response);

        $response
        ->assertStatus(200)
        ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    /**
     * should not create awt token 
     *
     * @return void
     * @test
     */
    public function it_should_not_create_awt_token()
    {

        $response = $this->json('POST', '/api/login', [
            'email'    => $this->faker->email,
            'password' => 'testUxxx'.rand(99, 999).'#' 
        ]);

        //dd($response);

        $response
        ->assertStatus(401);
    }
}
