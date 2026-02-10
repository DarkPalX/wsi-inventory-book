<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SettingSeeder::class,
            MenuSeeder::class,
            MenusHasPagesSeeder::class,
            PageSeeder::class,
            AlbumSeeder::class,
            RoleSeeder::class,
            OptionSeeder::class,
            BannerSeeder::class,
        ]);

        $this->users();
        $this->book_categories();
        $this->authors();
        $this->publishers();
        $this->agencies();
        $this->books();
        $this->book_authors();
        $this->suppliers();
        $this->receivers();
    }

    private function users()
    {
        $users = [
            [
                'name' => 'Admin Istrator',
                'firstname' => 'admin',
                'middlename' => 'user',
                'lastname' => 'istrator',
                'email' => 'wsiprod.demo@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'role_id' => 1,
                'is_active' => 1,
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'mobile' => '09456714321',
                'phone' => '022646545',
                'address_street' => 'Maharlika St',
                'address_city' => 'Pasay',
                'address_zip' => '1234'
            ]
        ];

        DB::table('users')->insert($users);
    }
    
    private function book_categories()
    {
        $book_categories = [
            [
                'name' => 'Horror',
                'slug' => 'horror',
                'description' => 'Scaryyy',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 

            [
                'name' => 'Action',
                'slug' => 'action',
                'description' => 'Wow',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 

            [
                'name' => 'Romance',
                'slug' => 'romance',
                'description' => 'Sanaol',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 

            [
                'name' => 'Theology',
                'slug' => 'theology',
                'description' => 'Study about God',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ];

        DB::table('book_categories')->insert($book_categories);
    }
    
    private function authors()
    {
        $authors = [
            [
                'name' => 'Robert Thieme',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 

            [
                'name' => 'William Shakespeare',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 

            [
                'name' => 'Andrew Echaveria',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ];

        DB::table('authors')->insert($authors);
    }
    
    private function publishers()
    {
        $publishers = [
            [
                'name' => 'Bukang Liwayway Pub. House',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 

            [
                'name' => 'Good Morning Publisher',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 

            [
                'name' => 'Adobo Pub',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ];

        DB::table('publishers')->insert($publishers);
    }
    
    private function agencies()
    {
        $agencies = [
            [
                'name' => 'Nam Il Ho Financing',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 

            [
                'name' => 'Gogo Foundation',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 

            [
                'name' => 'Centaurion',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ];

        DB::table('agencies')->insert($agencies);
    }
    
    private function books()
    {
        $books = [
            [
                'sku' => 'DFA0001',
                'name' => 'Hamlet',
                'slug' => 'hamlet',
                'edition' => '1st Edition',
                'subtitle' => 'The Tragedy of Hamlet, Prince of Denmark',
                'isbn' => 'ISBN1',
                'publication_date' => '2024-08-01',
                'category_id' => 1,
                'publisher_id' => 1,
                'researcher' => 500,
                'total_cost' => 500,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'sku' => 'DFA0002',
                'name' => 'The Trinity',
                'slug' => 'the-trinity',
                'edition' => '1st Edition',
                'subtitle' => 'Exploring the Divine Mystery',
                'isbn' => 'ISBN2',
                'publication_date' => '2024-08-01',
                'category_id' => 4,
                'publisher_id' => 1,
                'researcher' => 777,
                'total_cost' => 777,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'sku' => 'DFA0003',
                'name' => 'Romeo and Juliet',
                'slug' => 'romeo-and-juliet',
                'edition' => '1st Edition',
                'subtitle' => 'A Tragic Love Story',
                'isbn' => 'ISBN3',
                'publication_date' => '2024-08-02',
                'category_id' => 3,
                'publisher_id' => 2,
                'researcher' => 700,
                'total_cost' => 700,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'sku' => 'DFA0004',
                'name' => 'The Art of War',
                'slug' => 'the-art-of-war',
                'edition' => '2nd Edition',
                'subtitle' => 'Strategies for Victory',
                'isbn' => 'ISBN4',
                'publication_date' => '2024-08-03',
                'category_id' => 2,
                'publisher_id' => 3,
                'researcher' => 600,
                'total_cost' => 600,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'sku' => 'DFA0005',
                'name' => 'Moby Dick',
                'slug' => 'moby-dick',
                'edition' => '1st Edition',
                'subtitle' => 'The Whale',
                'isbn' => 'ISBN5',
                'publication_date' => '2024-08-04',
                'category_id' => 1,
                'publisher_id' => 2,
                'researcher' => 800,
                'total_cost' => 800,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'sku' => 'DFA0006',
                'name' => 'The Odyssey',
                'slug' => 'the-odyssey',
                'edition' => '3rd Edition',
                'subtitle' => 'An Epic Journey Home',
                'isbn' => 'ISBN6',
                'publication_date' => '2024-08-05',
                'category_id' => 1,
                'publisher_id' => 1,
                'researcher' => 789,
                'total_cost' => 789,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'sku' => 'DFA0007',
                'name' => 'The Iliad',
                'slug' => 'the-iliad',
                'edition' => '3rd Edition',
                'subtitle' => 'The Siege of Troy',
                'isbn' => 'ISBN7',
                'publication_date' => '2024-08-06',
                'category_id' => 2,
                'publisher_id' => 3,
                'researcher' => 200,
                'total_cost' => 200,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'sku' => 'DFA0008',
                'name' => 'Don Quixote',
                'slug' => 'don-quixote',
                'edition' => '2nd Edition',
                'subtitle' => 'The Ingenious Gentleman of La Mancha',
                'isbn' => 'ISBN8',
                'publication_date' => '2024-08-07',
                'category_id' => 3,
                'publisher_id' => 1,
                'researcher' => 500,
                'total_cost' => 500,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'sku' => 'DFA0009',
                'name' => 'Macbeth',
                'slug' => 'macbeth',
                'edition' => '1st Edition',
                'subtitle' => 'The Scottish Play',
                'isbn' => 'ISBN9',
                'publication_date' => '2024-08-08',
                'category_id' => 1,
                'publisher_id' => 2,
                'researcher' => 200,
                'total_cost' => 200,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'sku' => 'DFA0010',
                'name' => 'War and Peace',
                'slug' => 'war-and-peace',
                'edition' => '1st Edition',
                'subtitle' => 'The Epic of Russia',
                'isbn' => 'ISBN10',
                'publication_date' => '2024-08-09',
                'category_id' => 2,
                'publisher_id' => 3,
                'researcher' => 800,
                'total_cost' => 800,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ];

        DB::table('books')->insert($books);
    }

    private function book_authors()
    {
        $book_authors = [
            [
                'book_id' => 1,
                'author_id' => 2,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'book_id' => 2,
                'author_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'book_id' => 3,
                'author_id' => 3,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'book_id' => 4,
                'author_id' => 2,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'book_id' => 5,
                'author_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'book_id' => 6,
                'author_id' => 3,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'book_id' => 7,
                'author_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'book_id' => 8,
                'author_id' => 2,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'book_id' => 9,
                'author_id' => 3,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'book_id' => 10,
                'author_id' => 2,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
        ];

        DB::table('book_authors')->insert($book_authors);
    }

    private function suppliers()
    {
        $suppliers = [
            [
                'name' => 'Maligaya Printers',
                'address' => 'Davao City',
                'cellphone_no' => '09987654321',
                'telephone_no' => '2287000',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 

            [
                'name' => 'Epson Printer',
                'address' => 'Davao City',
                'cellphone_no' => '09987654321',
                'telephone_no' => '2287000',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 

            [
                'name' => 'Asus',
                'address' => 'Davao City',
                'cellphone_no' => '09987654321',
                'telephone_no' => '2287000',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ];

        DB::table('suppliers')->insert($suppliers);
    }

    private function receivers()
    {
        $receivers = [
            [
                'name' => 'Bureau of Immigrations',
                'address' => 'Davao City',
                'contact' => '09987654321',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 
            [
                'name' => 'Commmission on Audit',
                'address' => 'Buhangin, Davao City',
                'contact' => '09987654321',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ], 
            [
                'name' => 'San Miguel',
                'address' => 'Panabo City',
                'contact' => '09987654321',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ];

        DB::table('receivers')->insert($receivers);
    }
}
