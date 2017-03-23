<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable
{
    const EXPIRATION_TIME_FORMAT = 'D M d Y H:i:s';

    use Notifiable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expired_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id',
        'email',
        'expired',
        'expires_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];


    /**
     * Return a list of accounts marked with the
     * expired bit in database.
     *
     * @return mixed
     */
    public function getExpiredAccounts()
    {
        return $this->where('expired', true)->get();
    }


    /**
     * Get an array of accounts that are not being used between 2 hours ago and 1 hour ago
     * So as example when its 15:00 now we will return accounts that checked there accounts
     * in this range.
     *
     * 15:00 - 2H = 13:00 and 15:00 - 1H = 14:00
     *
     * Return email acounts where expired is < 15:00 and last_check (last called /system/messages) is
     * between 13:00 and 15:00.
     *
     * @return mixed
     */
    public function getInactiveAccounts()
    {
        return $this->whereBetween('last_check', [
            Carbon::now()->subHours(2),
            Carbon::now()->subHours(1)
        ])->where('expired', false)->where('expires_at', '<', Carbon::now())->get();
    }


    /**
     * Return a list of active mail accounts on the system.
     */
    public static function getActiveAccounts()
    {
        return self::whereExpired(false)->get();
    }


    /**
     * Create a nicely formatted time notation. Probably in the future
     * this will deprecate and i will use Carbon for this.
     *
     * @param int $timestamp
     *
     * @return false|string
     */
    public static function formatTimestamp($timestamp = 0)
    {
        if ($timestamp == 0) {
            $timestamp = time();
        }

        return date(self::EXPIRATION_TIME_FORMAT, $timestamp);
    }


    /**
     * Create a new mail account and random unique_id.
     *
     * @see generateUniqueId
     * @return int|static
     */
    public static function generate()
    {
        $account = self::generateUniqueId();
        $email = $account.'@'.config('custom.mail_domain');
        $expires_at = \Carbon\Carbon::createFromTimestamp(strtotime("+10 MIN"));

        $account = Account::create([
            'unique_id'  => $account,
            'email'      => $email,
            'expired'    => false,
            'expires_at' => $expires_at
        ]);

        return $account;
    }


    /**
     * Create a unique_id for a new account to use.
     *
     * @return int
     */
    public static function generateUniqueId()
    {
        $number = mt_rand(1000, 999999); // better than rand()

        if (self::whereUniqueId($number)->exists()) {
            return generateBarcodeNumber();
        }

        return $number;
    }
}
