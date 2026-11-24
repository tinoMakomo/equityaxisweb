<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Preference;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => "James",
            'email' => "jamess@equityaxis.net",
            'password' => Hash::make("jamess@eq"),
            'user_type_id' => 1,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user1->id,
        ]);

        $user2 = User::create([
            'name' => "Raynold Mhotseka",
            'email' => "raynoldm@equityaxis.net",
            'password' => Hash::make("raynoldm@eq"),
            'user_type_id' => 2,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user2->id,
        ]);

        $user3 = User::create([
            'name' => "Respect Gwenzi",
            'email' => "respect@equityaxis.net",
            'password' => Hash::make("respect@eq"),
            'user_type_id' => 2,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user3->id,
        ]);

        $user4 = User::create([
            'name' => "Caroline Chikerema",
            'email' => "carolinec@equityaxis.net",
            'password' => Hash::make("carolinec@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user4->id,
        ]);

        $user5 = User::create([
            'name' => "Rumbidzai Goredema",
            'email' => "rumbidzaig@equityaxis.net",
            'password' => Hash::make("rumbidzaig@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user5->id,
        ]);

        $user6 = User::create([
            'name' => "Eben Mabunda",
            'email' => "ebenm@equityaxis.net",
            'password' => Hash::make("ebenm@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user6->id,
        ]);

        $user7 = User::create([
            'name' => "Guest Guest",
            'email' => "newsdesk@equityaxis.net",
            'password' => Hash::make("newsdesk@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user7->id,
        ]);

        $user8 = User::create([
            'name' => "Guest Writer",
            'email' => "guest@equityaxis.net",
            'password' => Hash::make("guest@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user8->id,
        ]);

        $user9 = User::create([
            'name' => "Zvikomborero Sibanda",
            'email' => "zvikomboreros@equityaxis.net",
            'password' => Hash::make("zvikomboreros@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user9->id,
        ]);

        $user10 = User::create([
            'name' => "Aaron Chiraerae",
            'email' => "aaronc@equityaxis.net",
            'password' => Hash::make("aaronc@eq"),
            'user_type_id' => 1,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user10->id,
        ]);

        $user11 = User::create([
            'name' => "Ntando Nsikane",
            'email' => "ntandon@equityaxis.net",
            'password' => Hash::make("ntandon@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user11->id,
        ]);

        $user12 = User::create([
            'name' => "Desmond Tapfuma",
            'email' => "desmondt@equityaxis.net",
            'password' => Hash::make("desmondt@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user12->id,
        ]);

        $user13 = User::create([
            'name' => "Tinashe W Duma",
            'email' => "tinashed@equityaxis.net",
            'password' => Hash::make("tinashed@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user13->id,
        ]);

        $user14 = User::create([
            'name' => "Beaven Dhliwayo",
            'email' => "beavend@equityaxis.net",
            'password' => Hash::make("beavend@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user14->id,
        ]);

        $user15 = User::create([
            'name' => "Rugare Mukanganga",
            'email' => "rugarem@equityaxis.net",
            'password' => Hash::make("rugarem@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user15->id,
        ]);

        $user16 = User::create([
            'name' => "Mishma Chakanyuka",
            'email' => "mishmac@equityaxis.net",
            'password' => Hash::make("mishmac@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user16->id,
        ]);

        $user17 = User::create([
            'name' => "Blessing Kanyemba",
            'email' => "blessingk@equityaxis.net",
            'password' => Hash::make("blessingk@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user17->id,
        ]);

        $user18 = User::create([
            'name' => "Faith Nyaude",
            'email' => "faithn@equityaxis.net",
            'password' => Hash::make("faithn@eq"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user18->id,
        ]);

        $user19 = User::create([
            'name' => "Staff Writer",
            'email' => "staffwriter@equityaxis.net",
            'password' => Hash::make("staffwriter@eq"),
            'user_type_id' => 1,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user19->id,
        ]);

        $user20 = User::create([
            'name' => "Rufaro Sithole",
            'email' => "rufarosithole4@gmail.com",
            'password' => Hash::make("CaRtEr.4"),
            'user_type_id' => 1,
            'bio' => "A software developer",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user20->id,
        ]);


        $user21 = User::create([
            'name' => "Admin User",
            'email' => "admin@equityaxis.net",
            'password' => Hash::make("tadiwa"),
            'user_type_id' => 1,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user21->id,
        ]);


        $user22 = User::create([
            'name' => "Author User",
            'email' => "writer@equityaxis.net",
            'password' => Hash::make("tadiwa"),
            'user_type_id' => 3,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user22->id,
        ]);


        $user23 = User::create([
            'name' => "Editor User",
            'email' => "editor@equityaxis.net",
            'password' => Hash::make("tadiwa"),
            'user_type_id' => 2,
            'bio' => "",
            'twitter' => "",
            'linkedin' => "",
            'phone' => "",
        ]);
        Preference::create([
            'user_id' => $user23->id,
        ]);
    }
}
