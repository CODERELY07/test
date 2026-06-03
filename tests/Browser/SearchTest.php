<?php

use App\Models\Repair;
use App\Models\User;

    it('can log in through the form and search', function(){
        $user = User::factory()->create();
        $repair = Repair::factory()->create();

        visit('/login')
            ->type('email', $user->email)
            ->type('password', 'password')
            ->press('Log in');

        visit('/repairs')
            ->fill('searchTicket', $repair->ticket_number)
            ->press('@search-btn')
            ->assertPathIs('/repairs')
            ->assertQueryStringHas('searchTicket', $repair->ticket_number)
            ->assertSee($repair->ticket_number)
            ->assertDontSee('No Repairs Found');
    });

    it('Client can Search their ticket', function(){

        $repair = Repair::factory()->create();

        visit('/')
            ->fill('searchTicket', $repair->ticket_number)
            ->press('@search-btn')
            ->assertPathIs('/repairs')
            ->assertQueryStringHas('searchTicket', $repair->ticket_number)
            ->assertSee($repair->ticket_number)
            ->assertDontSee('No Repairs Found');
    });

    it('see no repairs found', function(){
        $user = User::factory()->create();
        visit('/login')
            ->fill('email', $user->email)
            ->fill('password', 'password')
            ->press('Log in');


        visit('/repairs')
            ->fill('searchTicket','Tkn-12345')
            ->press('@search-btn')
            ->assertPathIs('/repairs')
            ->assertQueryStringHas('searchTicket', 'Tkn-12345')
            ->assertSee('No Repairs Found')
            ->assertDontSee('Tkn-12345');
    });
