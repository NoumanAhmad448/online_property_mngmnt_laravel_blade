<?php

use App\Models\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private $cities;

    public function __construct() {
        $this->cities = ['Lower Bogue', 'Upper Bogue', 'Spanish Wells', 'Bluff', 'Harbour island',
        ];
    }

    public function up() {
        if (Schema::hasTable(config('table.cities'))) {

            $data = [];
            foreach ($this->cities as $city) {
                $data[] = [
                    'name' => $city,
                    'is_active' => 1,
                    'state_id' => 3599,
                    'country_id' => config('setting.bahmas_country_code'),
                ];
            }
            City::insert($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        if (Schema::hasTable(config('table.cities'))) {
            City::whereIn('name', $this->cities)->where('country_id', config('setting.bahmas_country_code'))->delete();
        }
    }
};
