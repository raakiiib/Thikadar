<?php

use App\Models\Account;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $account = Account::create(['name' => 'Thikadar']);

        factory(User::class)->create([
            'account_id' => $account->id,
            'first_name' => 'Rakibul',
            'last_name' => 'Hasan',
            'email' => 'rakib@example.com',
            'owner' => true,
        ]);

        factory(User::class, 5)->create(['account_id' => $account->id]);


        $organizations = factory(Organization::class, 20)
            ->create(['account_id' => $account->id]);

        factory(Contact::class, 20)
            ->create(['account_id' => $account->id])
            ->each(function ($contact) use ($organizations) {
                $contact->update(['organization_id' => $organizations->random()->id]);
            });

        // factory(Staff::class, 10)->create();

    }
}

