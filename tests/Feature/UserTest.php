<?php

namespace Tests\Feature;

use App\Film;
use App\News;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'username' => 'JanuszKowalski',
            'email' => 'januszkowalski@gmail.com',
            'name' => 'JanuszKowalski',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $this->assertCount(1, User::all());
        //$response->assertRedirect('/home');
    }

    public function test_duplicate_email_throws_an_error()
    {
        $user = factory(User::class)->create();
        $response = $this->post('/register', [
            'username' => 'JanuszKowalski',
            'email' => $user->email,
            'name' => 'JanuszKowalski',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertSessionHasErrors(['email']);
        $this->assertCount(1, User::all());
    }

    public function test_duplicate_username_throws_an_error()
    {
        $user = factory(User::class)->create();
        $response = $this->post('/register', [
            'username' => $user->username,
            'email' => 'januszkowalski@gmail.com',
            'name' => 'JanuszKowalski',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertSessionHasErrors(['username']);
        $this->assertCount(1, User::all());
    }

    public function test_user_can_log_in()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/home');
        $response->assertOk();
    }

    public function test_user_can_write_a_post()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->post('/p', [
            'id' => 1,
            'user_id' => $user->id,
            'title' => 'Title',
            'category' => 'filmy',
            'content' => NULL
        ]);
        $response->assertRedirect('/p/'. 1);
    }

    public function test_user_can_edit_his_post()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->post('/p', [
            'id' => 1,
            'user_id' => $user->id,
            'title' => 'Title',
            'category' => 'filmy',
            'content' => NULL
        ]);
        $response = $this->post('/p/1/update', [
            'title' => 'Title 2',
            'category' => 'filmy',
            'content' => 'This post has been edited'
        ]);
        $response->assertRedirect('/p/'. 1);
    }

    public function test_user_can_delete_his_post()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->post('/p', [
            'id' => 1,
            'user_id' => $user->id,
            'title' => 'Title',
            'category' => 'filmy',
            'content' => NULL
        ]);
        $response = $this->delete('/p/1');
        $response->assertRedirect('/forum');
    }

    public function test_user_cant_edit_other_users_post()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $post = factory(Post::class)->create();
        $response = $this->get('/p/' . $post->id . '/edit');
        $response->assertStatus(302);
        /*
        $response = $this->post('/p/'. $post->id .'/update', [
            'content' => 'This post has been edited'
        ]);
        $response->assertRedirect('/');*/
    }

    public function test_user_can_write_a_comment()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $post = factory(Post::class)->create();
        $response = $this->post('/comment', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'content' => 'My Comment'
        ]);
        $response->assertOk();
    }

    public function test_user_can_write_a_review()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $film = factory(Film::class)->create();
        $response = $this->post('/review', [
            'film_id' => $film->id,
            'user_id' => $user->id,
            'rating' => 10,
            'content' => 'My Review'
        ]);
        $response->assertRedirect('/film/'. $film->id);
    }

    public function test_user_cant_access_add_film_form()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->get('/film/create');
        $response->assertStatus(302);
    }

    public function test_user_cant_access_add_actor_form()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->get('/actor/create');
        $response->assertStatus(302);
    }

    public function test_user_cant_add_a_film()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->post('/film/store', [
            'title' => 'Title',
            'original_title' => 'Original Title',
            'release'=>Carbon::parse('1994-10-09'),
            'description'=>'Description',
            'image'=>'uploads/00SNaQo7HsHd6ZKrMQS1xX7CE7dqd1jp8JgKBvZLfv.jpg'
        ]);
        $response->assertStatus(302);
        $this->assertCount(0, Film::all());
    }

    public function test_user_cant_add_a_news()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->post('/admin/news', [
            'user_id'=>$user->id,
            'title'=>'Title',
            'content'=>'Text',
            'image'=>'uploads/0135171_1.11.jpg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        $response->assertStatus(302);
        $this->assertCount(0, News::all());
    }
}
