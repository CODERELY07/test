<?php

use App\Models\User;

it('shows validation errors when submitting an empty new ticket form', function () {

    $user = User::factory()->create(['password' => bcrypt('password')]);
    
    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'password')
        ->click('Log in');

    $page = visit('/repairs')
        ->click('New Ticket')
        ->waitForText('Create New Ticket'); 

    $page->click('Register Ticket');

    $page->waitForText('The name field is required.')
        ->assertSee('The name field is required.')
        ->assertSee('The model field is required.')
        ->assertSee('The category field is required.')
        ->assertSee('The estimated cost field is required.')
        ->assertSee('The description field is required.');
});


it('can create a repair ticket, edit and view its details', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password')
    ]);


    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'password')
        ->click('Log in');


    $page = visit('/repairs')
        ->click('New Ticket')
        ->waitForText('Create New Ticket') 
        ->fill('name', 'Juan Dela Cruz')
        ->fill('model', 'iPhone 13 Pro')
        ->fill('category', 'Smartphone')
        ->fill('estimated_cost', '4500')
        ->fill('description', 'Screen replacement and battery optimization.');
        

    $page->click('Register Ticket');;


    $page->assertPathIs('/repairs')
        ->assertSee('Juan Dela Cruz')
        ->assertSee('iPhone 13 Pro')
        ->click('View')
        ->waitForText('Ticket Details') 
        ->assertSee('Juan Dela Cruz')
        ->assertSee('Screen replacement and battery optimization.')
        ->click('Close Details');

    $page->assertPathIs('/repairs')
        ->click('Edit')
        ->waitForText('Edit Ticket Details');
        
        $page->click('Save Changes');
});

