<?php

namespace Database\Seeders;

use App\Actions\ReadCSV;
use App\Models\Survey;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedPSS();
        $this->seedMCS();
    }

    public function seedPSS()
    {
        $array = ReadCSV::handle('database/seeders/dataset/PSS.csv');

        Survey::create([
            'title' => 'PSS',
            'choice_type' => 'number',
        ]);

        $i = 1;
        foreach ($array as $item) {
            DB::table('survey_questions')->insert([
                'question' => $item['question'],
                'survey_id' => 1,
                'number' => $i,
            ]);
            $i++;
        }
    }

    public function seedMCS()
    {
        $array = ReadCSV::handle('database/seeders/dataset/MCS.csv');

        Survey::create([
            'title' => 'MCS',
            'choice_type' => 'text',
        ]);

        $i = 1;
        foreach ($array as $item) {
            DB::table('survey_questions')->insert([
                'question' => $item['question'],
                'survey_id' => 2,
                'number' => $i,
            ]);
            $i++;
        }
    }
}
