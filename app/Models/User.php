<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles;

    /**
     * Permissions
     */
    const PERMISSION_USER = 'user';
    const PERMISSION_MODERATOR = 'moderator';
    const PERMISSION_ADMIN = 'administrator';

    /**
     * Roles
     */
    const ROLE_USER = 'User';
    const ROLE_MODERATOR = 'Moderator';
    const ROLE_ADMIN = 'Administrator';

    /**
     * Status
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static $STATUS_LABELS = [
        self::STATUS_INACTIVE => 'Blocked',
        self::STATUS_ACTIVE => 'Active',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function searchQuery($search = null)
    {
        $tableName = ((new self)->getTable());

        $query = self::select($tableName . '.*', DB::raw('GROUP_CONCAT(roles.name SEPARATOR ",") AS roles'))
            ->where($tableName . '.id', '>', 0)
            ->leftJoin('model_has_roles', function ($join) use ($tableName) {
                $join->on($tableName . '.id', '=', 'model_has_roles.model_id')
                    ->on('model_has_roles.model_type', '=', DB::raw(DB::connection()->getPdo()->quote(self::class)));
            })
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->groupBy($tableName . '.id');

        //@TODO
        // see current active client users
        $requestUser = Auth::user();
        if ($requestUser->isAdmin()) {
            // ADMIN
            // include admin users
        } else if ($requestUser->isModerator()) {
            // MODERATOR
            // exclude admin users
        } else {
            // OTHERS
        }

        if (isset($search) && is_object($search)) {
            // Open search
            if (isset($search->q)) {
                $query->where(function ($internalQuery) use ($search, $tableName) {
                    $internalQuery->where($tableName . '.email', 'like', '%' . $search->q . '%')
                        ->orWhere($tableName . '.name', 'like', '%' . $search->q . '%');
                });
            }
        }

        return $query;
    }

    public static function search($start = 0, $tpp = 999, $orderBy = null, $search = null)
    {
        $tableName = ((new self)->getTable());
        $orderMap = [
            0 => $tableName . '.name',
            1 => $tableName . '.email',
            2 => $tableName . '.status',
            4 => $tableName . '.updated_at',
        ];

        $query = self::searchQuery($search);

        if (is_array($orderBy)) {
            foreach ($orderBy as $order) {
                $query->orderBy($orderMap[$order['column']], $order['dir']);
            }
        }

        return (object) [
            'ttl' => $query->get()->count(),
            'data' => $query->skip($start)->take($tpp)->get(),
        ];
    }

    /**
     * Whether user has moderator permission
     *
     * @return boolean
     */
    public function isUser()
    {
        return $this->hasPermissionTo(self::PERMISSION_USER);
    }

    /**
     * Whether user has moderator permission
     *
     * @return boolean
     */
    public function isModerator()
    {
        return $this->hasPermissionTo(self::PERMISSION_MODERATOR);
    }

    /**
     * Whether user has admin permission
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->hasPermissionTo(self::PERMISSION_ADMIN);
    }
}
