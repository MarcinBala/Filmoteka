<?php

namespace Tests\Feature;

use App\Film;
use App\News;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_add_a_film()
    {
        $user = factory(User::class)->create();
        $user->user_type = 'admin';
        $this->actingAs($user);
        $response = $this->post('/film/store', [
            'title' => 'Title',
            'original_title' => 'Original Title',
            'release'=>Carbon::now(),
            'description'=>'Description',
            'image'=> UploadedFile::fake()->image('image.jpg')
        ]);
        $response->assertStatus(302);
        $this->assertCount(1, Film::all());
    }

    public function test_admin_can_add_a_news()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $user->user_type = 'admin';
        $this->actingAs($user);
        $response = $this->post('/admin/news', [
            'user_id'=>$user->id,
            'title'=>'Title',
            'content'=>'Text',
            'image'=> UploadedFile::fake()->image('image.jpg'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        $response->assertStatus(302);
        $this->assertCount(1, News::all());
    }
}
