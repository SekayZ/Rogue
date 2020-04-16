<?php

namespace Tests\Feature;


use App\Post;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;


class UserTest extends TestCase
{
    use RefreshDatabase;

    // @@@ OK
    public function test_as_a_guest_I_can_register()
    {
        $user = factory(User::class)->create();
        $response = $this->post('register', $user->toArray());
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    // @@@ OK
    public function test_as_a_user_I_can_login()
    {
        $user = factory(User::class)->create();
        $response = $this->post('login', [ $user->username , $user->password ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    // *** TESTING FOLLOWING *** //

    // @@@ OK
    public function test_as_a_user_I_can_follow_someone_else()
    {
        $user = factory(User::class)->create();
        $user_to_follow = factory(User::class)->create();
       
        $response = $this->actingAs($user)
            ->post('follow', [
                'follow' => $user_to_follow->id,
            ]);
        
        $response->assertStatus(302);
        $response->assertRedirect('profile/'.$user_to_follow->id);
    }

    // @@@ OK
    public function test_as_a_guest_I_cant_follow_someone_else()
    {
        $user_to_follow = factory(User::class)->create();
       
        $response = $this
            ->post('follow', [
                'follow' => $user_to_follow->id,
            ]);
        
        $response->assertStatus(302);
    }

    // *** TESTING COMMENTING *** //

    // @@@ OK
    public function test_as_a_user_I_can_comment_on_someone_elses_post()
    {
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $post = $otherUser->posts()->save(factory(Post::class)->make());
       
        $response = $this->actingAs($user)
            ->post('comments', [
                'post_id' => $post->id,
                'user_id' => $otherUser->id,
                'comment' => 'blabla',
            ]);
        
        $response->assertStatus(302);
        $response->assertRedirect('posts/'.$post->id);
    }

    // @@@ OK
    public function test_as_a_user_I_can_comment_on_my_own_post()
    {
        $user = factory(User::class)->create();
        $post = $user->posts()->save(factory(Post::class)->make());
       
        $response = $this->actingAs($user)
            ->post('comments', [
                'post_id' => $post->id,
                'user_id' => $user->id,
                'comment' => 'blabla',
            ]);
       
        $response->assertStatus(302);
        $response->assertRedirect('posts/'.$post->id);
    }

    // *** TESTING POST CREATION *** //

    // @@@ OK
    public function test_as_a_user_I_can_create_a_post()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('new_post.jpg', 400 , 400);

        $response = $this->actingAs($user)
            ->post('posts', [
                'user_id' => $user->id,
                'image' => $file,
                'caption' => 'blabla',
                ]);

        $latest_post = Post::latest()->first();
        $this->assertEquals('images/posts/' . $file->hashName(), $latest_post->image);
        Storage::disk('public')->assertExists('images/posts/' . $file->hashName());
        $response->assertStatus(302);
        $response->assertRedirect('posts/' . $latest_post->user->id);
    }

    // @@@ OK
    public function test_as_a_user_I_cant_create_post_with_empty_caption()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('new_post.jpg', 400 , 400);

        $response = $this->actingAs($user)
            ->post('posts', [
                'user_id' => $user->id,
                'image' => $file,
                'caption' => null,
                ]);
        
        $response->assertSessionHasErrors(('caption'));
        
    }

    // @@@ OK
    public function test_as_a_user_I_cant_create_post_with_empty_image()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('new_post.jpg', 400 , 400);
    
        $response = $this->actingAs($user)
            ->post('posts', [
                'user_id' => $user->id,
                'image' => null,
                'caption' => 'blabla',
                ]);
        
        $response->assertSessionHasErrors(('image'));
    }

    // @@@ OK
    public function test_as_a_user_I_cant_create_post_with_all_empty_fields()
    {
        Storage::fake('public');
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('new_post.jpg', 400 , 400);
    
        $response = $this->actingAs($user)
            ->post('posts', [
                'user_id' => $user->id,
                'image' => null,
                'caption' => null,
                ]);
        
        $response->assertSessionHasErrors(('image'));
        $response->assertSessionHasErrors(('caption'));
    }


    // *** TESTING SEARCH BAR *** //

    // @@@ OK
    public function test_as_a_user_I_can_search_other_user()
    {
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->post('search', [
                'search' => $otherUser->username,
                ]);

        $response->assertStatus(302);
        $response->assertRedirect('profile/'.$otherUser->id);
    }

    // @@@ OK
    public function test_as_a_guest_I_can_search_other_user()
    {
        $otherUser = factory(User::class)->create();

        $response = $this
            ->post('search', [
                'search' => $otherUser->username,
                ]);
     
        $response->assertStatus(302);
        $response->assertRedirect('profile/'.$otherUser->id);
    }

    // @@@ OK
    public function test_as_a_user_searching_for_non_existing_user()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->post('search', [
                'search' => null,
                ]);

        $response->assertStatus(302);
        $response->assertRedirect('profile/');
    }

    // @@@ OK
    public function test_as_a_guest_searching_for_non_existing_user()
    {
        $response = $this
            ->post('search', [
                'search' => null,
                ]);

        $response->assertStatus(302);
        $response->assertRedirect('profile/');
    }

}
