<?php

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $tags_names = ['FrontEnd', 'Backend', 'FullStack', 'UI/UX', 'Design', 'CMS'];

        foreach ($tags_names as $tag_label) {
            $tag = new Tag();
            $tag->label = $tag_label;
            $tag->color = $faker->hexColor();
            $tag->save();
        }
    }
}
