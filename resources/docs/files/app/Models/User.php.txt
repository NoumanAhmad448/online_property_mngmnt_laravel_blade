<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, HasRoles, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_super_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function normalUserCond($all_users = false) {
        $query = '';
        if ($all_users) {
            $query = self::deletedUsr()->whereNull(config('table.is_super_admin'))->
                    whereNull(config('table.is_admin'));
        } else {
            $query = self::whereNull(config('table.is_super_admin'))->whereNull(config('table.is_admin'));
        }

        return $query;
    }

    public function normalUsrCond() {
        $query = $this->whereNull(config('table.is_super_admin'))->whereNull(config('table.is_admin'));

        return $query;
    }

    public static function adminCond($all_users = false) {
        if ($all_users) {
            $query = self::deletedUsr()->where(config('table.is_admin'), true);
        } else {
            $query = self::where(config('table.is_admin'), true);
        }

        return $query;
    }

    public function adminCondion() {
        $query = $this->where(config('table.is_admin'), true);

        return $query;
    }

    public static function deletedUsr() {
        $query = self::withTrashed();

        return $query;
    }

    /**
     * Get all ids of users
     *
     * @return array<string>
     */
    public function getIds(): array {
        $users = self::normalUserCond();
        $users = $users->pluck(config('table.primary_key'));
        $users = $users->all();
        debug_logs($users);

        return $users;
    }

    /**
     * Change the user Password
     *
     * @return array<string>
     */
    public function passChange($ids, $pass) {

        $ids = str_to_array($ids);
        debug_logs($ids);
        $users = User::deletedUsr();

        $users = $users->whereIn(config('table.primary_key'), $ids);
        debug_logs($users);
        if ($users) {
            // make deleted users active
            $users->restore();
            debug_logs($users);
            foreach ($ids as $id) {
                $user = User::find($id);
                debug_logs($user);
                $user = $user->fill([
                    config('table.password') => Hash::make($pass),
                ])->save();
                debug_logs($users);
            }
        }

        return $users;
    }

    /**
     * Get all admins
     *
     * @return array<string>
     */
    public function getAdmins(): Collection {
        $users = self::deletedUsr()->where(config('table.is_admin'), true);
        $users = $users->get();
        debug_logs($users);

        return $users;
    }

    /**
     * Delete all admins
     *
     * @return array<string>
     */
    public function delAdmins($ids) {
        $ids = str_to_array($ids);
        $users = self::whereIn(config('table.primary_key'), $ids);
        $users = $users->delete();
        debug_logs($users);

        return $users;
    }

    public function defaultProfilePhotoUrl() {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }

    public function userProfile() {
        return $this->hasOne(UserProfile::class);
    }
}
