<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreateLand extends CustomModel {
    use CustomModelTrait, HasFactory;

    protected $table = 'land_create';

    protected $guarded = [];

    public function __construct() {
        $this->table = config('table.land_create');
    }

    public function landDetails($user) {
        if (isNotArray($user)) {
            $user = [$user];
        }
        $lands = self::whereIn(config('table.user_id'), $user)
            ->with('landComment', function ($query) {
                return $query->orderByDesc(config('table.created_at'));
            });
        $lands = $lands->showQuery();
        $lands = $lands->orderByDesc(config('table.primary_key'));
        $lands = $lands->get();

        return $lands;
    }

    private function insertData($input, $user, $isInsertReq = false) {
        $data = [];
        debug_logs($input);
        debug_logs($user);

        $data = add_key_if_exist(config('table.size'), $input, $data);
        $data = add_key_if_exist(config('table.location'), $input, $data);
        $data = add_key_if_exist(config('table.title'), $input, $data);
        $data = add_key_if_exist(config('table.description'), $input, $data);

        $data[config('table.user_id')] = $user->id;
        if ($isInsertReq) {
            $data[config('table.uuid')] = gen_str(true);
        }
        $data[config('table.city').'_id'] = $input[config('table.city')];

        return $data;
    }

    public function insert($user, $input) {
        $data = $this->insertData($input, $user, true);
        $created_obj = CreateLand::create($data);
        debug_logs('Before data');
        debug_logs($data);

        $data[config('table.land_id')] = $created_obj->id;
        CreateLandLog::create($data);
        debug_logs('After Data');
        debug_logs($data);

        debug_logs($created_obj->toSql());

        return $created_obj;
    }

    public function updateLand($land, $input, $user = '') {
        $data = [];
        if (empty($user)) {
            $user = auth()->user();
        }

        $data = $this->insertData($input, $user);

        $land->update($data);
        debug_logs('Before data');
        debug_logs($data);

        $data[config('table.land_id')] = $land->id;
        $data[config('table.uuid')] = $land->uuid;
        CreateLandLog::create($data);
        debug_logs('After Data');
        debug_logs($data);

        debug_logs($land->toSql());

        return $land;
    }

    public function getLand($id_or_uuid) {

        if (isNotArray($id_or_uuid)) {
            $id_or_uuid = [$id_or_uuid];
        }
        $land = self::whereIn(config('table.primary_key'), $id_or_uuid)
            ->orWhereIn(config('table.uuid'), $id_or_uuid)
            ->with(['city', 'landFiles']);
        $land = $land->showQuery();
        $land = $land->orderByDesc(config('table.primary_key'));
        $land = $land->get();

        if ($land->count() < 2) {
            $land = $land[0];
        }

        return $land;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function landFiles() {
        return $this->hasMany(LandFile::class, config('table.land_create_id'));
    }

    public function landComment() {
        return $this->hasMany(LandComments::class, config('table.land_create_id'));
    }

    public function commonUser() {
        return $this->belongsTo(User::class, 'user_id')
            ->whereNull('users.'.config('table.is_super_admin'))
            ->whereNull('users.'.config('table.is_admin'));
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function normalUserRel() {
        return ['users' => function ($query) {
            $query->where('users.'.config('table.is_super_admin'), false);
        }];
    }
}
