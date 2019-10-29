<?php

use Illuminate\Database\Seeder;
use App\Preset;

class PresetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $presets = config('presets');

        foreach ($presets as $title => $preset) {
            $dbPreset = Preset::where('title', $title)->first();
            if (!$dbPreset) {
                $preset['title'] = $title;
                Preset::create($preset);
            }
        }
    }
}
