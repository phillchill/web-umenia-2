<?php 
class UsersTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

        // DB::table('users')->truncate();
        
        $now = date("Y-m-d H:i:s");

        $users = [
            [
                'username' => 'admin',
                'email' => 'lab@sng.sk',
                'password' => Hash::make('admin'),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'username' => 'sng',
                'email' => 'info@sng.sk',
                'password' => Hash::make('sng'),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'username' => 'press',
                'email' => '',
                'password' => Hash::make('press'),
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('users')->insert($users);

	}

}
