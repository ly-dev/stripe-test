<?php
namespace App\Modules\Auditlog\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Auditlog extends Model
{

    // CONSTANT - SEVERITY
    const SEVERITY_EMERGENCY = 0;

    const SEVERITY_ALERT = 1;

    const SEVERITY_CRITICAL = 2;

    const SEVERITY_ERROR = 3;

    const SEVERITY_WARNING = 4;

    const SEVERITY_NOTICE = 5;

    const SEVERITY_INFO = 6;

    const SEVERITY_DEBUG = 7;

    public static $SEVERITY_LABELS = [
        self::SEVERITY_EMERGENCY => 'Emergency',
        self::SEVERITY_ALERT => 'Alert',
        self::SEVERITY_CRITICAL => 'Critical',
        self::SEVERITY_ERROR => 'Error',
        self::SEVERITY_WARNING => 'Warning',
        self::SEVERITY_NOTICE => 'Notice',
        self::SEVERITY_INFO => 'Info',
        self::SEVERITY_DEBUG => 'Debug',
    ];

    // Data Input related

    /**
     *
     * @var string
     */
    protected $table = 'audit_logs';

    /**
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ip_address',
        'severity',
        'category',
        'activity',
        'target_id',
        'data',
    ];

    /**
     * Relation - user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function search($start = 0, $tpp = 999, $orderBy = null, $search = null)
    {

        $tableName = ((new self)->getTable());
        $orderMap = [
            0 => $tableName . '.updated_at',
            1 => $tableName . '.severity',
            2 => $tableName . '.category',
            4 => $tableName . '.ip_address',
            5 => 'userEmail',
        ];

        $query = self::select($tableName . '.*', 'users.email AS userEmail')
            ->leftJoin('users', $tableName . '.user_id', '=', 'users.id');

        if (isset($search) && is_object($search)) {
            // Open search
            if (isset($search->q)) {
                $query->where(function ($internalQuery) use ($search, $tableName) {
                    $internalQuery->where('users.email', 'like', '%' . $search->q . '%')
                        ->orWhere($tableName . '.category', 'like', '%' . $search->q . '%')
                        ->orWhere($tableName . '.activity', 'like', '%' . $search->q . '%')
                        ->orWhere($tableName . '.ip_address', 'like', '%' . $search->q . '%');
                });
            }
        }

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
     * Log web request activities
     *
     * @param integer $severity
     * @param string $category
     * @param string $activity
     * @param integer $targetId
     * @param string $data
     */
    public static function log($severity, $category, $activity = null, $targetId = null, $data = null)
    {
        $user = Auth::user();
        if (empty($user)) {
            $user = Auth::guard('api')->user();
        }

        $ipaddress = '127.0.0.1';
        if (!empty($_SERVER) && !empty($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }

        $log = [
            'user_id' => (empty($user) ? 0 : $user->id), // use the system anonymous user or the actual user
            'ip_address' => $ipaddress,
            'severity' => $severity,
            'category' => $category,
            'activity' => $activity,
            'target_id' => $targetId,
            'data' => $data,
        ];

        self::create($log);
    }

    public static function info($category, $activity = null, $targetId = null, $data = null)
    {
        self::log(self::SEVERITY_INFO, $category, $activity, $targetId, $data);
    }

    public static function warning($category, $activity = null, $targetId = null, $data = null)
    {
        self::log(self::SEVERITY_WARNING, $category, $activity, $targetId, $data);
    }

    public static function critical($category, $activity = null, $targetId = null, $data = null)
    {
        self::log(self::SEVERITY_CRITICAL, $category, $activity, $targetId, $data);
    }
}
