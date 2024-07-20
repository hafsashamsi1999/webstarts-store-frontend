<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserAvatars;
use App\Models\FBClients;
use App\Models\Sites;

/**
 * Class User
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property bool $customertype
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $phone
 * @property string $cell
 * @property string $fax
 * @property int $businesscategory
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $country
 * @property string $timestamp
 * @property string $lastlogin
 * @property bool $isSliderAdRemoved
 * @property bool $active
 * @property string $notes
 * @property int $billInfoFlag
 * @property string $billFirstName
 * @property string $billLastName
 * @property string $billEmail
 * @property string $billPhone
 * @property string $billAddress
 * @property string $billCity
 * @property string $billState
 * @property string $billZipCode
 * @property string $billCountry
 * @property string $billNotes
 * @property string $inform_date
 * @property string $clean_date
 * @property float $app_version
 * @property bool $isPaid
 * @property bool $upgraded
 * @property int $companyId
 * @property bool $is_designer_client
 *
 * @package App\Models
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';
	public $timestamps = false;
	public $picture = "";

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
	protected $casts = [
		'customertype' => 'bool',
		'businesscategory' => 'int',
		'isSliderAdRemoved' => 'bool',
		'active' => 'bool',
		'billInfoFlag' => 'int',
		'app_version' => 'float',
		'isPaid' => 'bool',
		'upgraded' => 'bool',
		'companyId' => 'int',
		'is_designer_client' => 'bool',
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
	protected $fillable = [
		'username',
		'password',
		'customertype',
		'firstname',
		'lastname',
		'email',
		'phone',
		'cell',
		'fax',
		'businesscategory',
		'address',
		'city',
		'state',
		'zipcode',
		'country',
		'timestamp',
		'lastlogin',
		'isSliderAdRemoved',
		'active',
		'notes',
		'billInfoFlag',
		'billFirstName',
		'billLastName',
		'billEmail',
		'billPhone',
		'billAddress',
		'billCity',
		'billState',
		'billZipCode',
		'billCountry',
		'billNotes',
		'inform_date',
		'clean_date',
		'app_version',
		'isPaid',
		'upgraded',
		'companyId',
		'is_designer_client'
	];

    /* Relationships */
	public function sites() {
        return $this->hasMany('App\Models\Sites', 'userid');
    }

    public function designer()
    {
        return $this->hasOne(\App\Models\Designer::class, 'userid');
    }

    public function domains()
    {
        return $this->hasMany(\App\Models\Domaininfo::class, 'userid');
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Orders::class, 'customer_id');
    }

    public function opensrs_emails()
    {
        return $this->hasMany(App\Models\OpensrsEmail::class, 'userid');
    }

    public function creditcards()
    {
        return $this->hasMany(UserStripe::class);
    }
    /* Relationships */



    public static function verifySite($userid, $siteid)
    {
        $site = Sites::where('userid', $userid)->where('id', $siteid)->first();
        if ($site) {
            return true;
        }
        return false;
    }

    public function getEmail()
    {
        return !empty($this->email) ? $this->email : $this->username;
    }

    /**
     * Parse the full name into first name and last name. Explode the string provided with 'space'
     *
     * @param   str 	 $full_name  	A string containing full name that needs to be parsed into chunks
     * @return  array
     */
    public static function parse_name($full_name)
    {
        // Exploding the name with 'space' and taking the value into first_name
        $first_name = explode(' ', $full_name);

        // If there are more than 1 elements in the array, pop the last element and put it in last_name
        if(count($first_name) > 1)
            $last_name = array_pop($first_name);
        else
            $last_name = '';

        // Return the last_name and first_name after imploding first_name with space
        return ['first'=>implode(' ', $first_name), 'last'=>$last_name];
    }

    public function getFullName()
    {
        $fullName = "";
        if (($this->firstname != null) && (strlen($this->firstname) > 0))
        {
            $fullName = $this->firstname;
        }
        if (($this->lastname != null) && (strlen($this->lastname) > 0))
        {
            if (strlen($fullName) > 0)
            {
                $fullName .= " ";
            }
            $fullName .= $this->lastname;
        }
        return $fullName;
    }

    public function get_address()
    {
        $address = $this->address;
        $city = $this->city;
        $state = $this->state;

        if(empty($address))
        {
            if(empty($city)) {
                $address = false;
            } else {
                if( ! empty($state)) {
                    $address .= ', ' . $state;
                }
            }
        } else {
            if( ! empty($city))
            {
                $address .= ' ' .$city;

                if ( ! empty($state)) {
                    $address .= ', ' .$state;
                }

            }
        }

        return $address;
    }

    function avatar()
    {
        $avatar = UserAvatars::where("user_id",'=',$this->id)->first();
        if($avatar) {
            return $avatar->avatar_url;
        }

        $avatar = FBClients::where("client_id",'=',$this->id)->first();
        if($avatar) {
            return 'https://graph.facebook.com/'. $avatar->fb_user_id .'/picture';
        }
        // No avatar or FB connected account, use gravatar
        return $this->getGravatar();
    }

    function getGravatar($size = 80) {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $this->username ) ) );
        $url .= "?s=$size&d=mm&r=g";
        return $url;
    }
}
