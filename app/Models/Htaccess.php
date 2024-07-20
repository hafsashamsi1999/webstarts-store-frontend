<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 17 Jan 2020 19:44:21 +0000.
 */

namespace App\Models;

use App\Utility\Sites\Storage\CommonStorage;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Htaccess
 *
 * @property int $id
 * @property int $siteid
 * @property array $features
 * @property \Carbon\Carbon $timestamp
 *
 * @package App\Models
 */
class Htaccess extends Eloquent
{
	protected $table = 'Htaccess';
	public $timestamps = false;
	public static $HtaccessFilePath = '.htaccess';

	protected $casts = [
		'siteid' => 'int',
		'features' => 'object'
	];

	protected $dates = [
		'timestamp'
	];

	protected $fillable = [
		'siteid',
		'features',
		'timestamp'
	];

	public function site()
    {
        return $this->belongsTo(\App\Models\Sites::class, 'siteid');
    }

    public function getHtaccessContent()
    {
        // Clone features into an array arranged by priority
        $features = [];
        foreach($this->features as $key => $val)
        {
            $features[$key] = (array) $val;
            $features[$key]['key'] = $key;
        }

        usort($features, function($a, $b) {
            if($a['priority'] == $b['priority']) {
                return 0;
            }
            return $a['priority'] < $b['priority'] ? -1 : 1;
        });

        $content = '';
        foreach($features as $feature)
        {
            $name = $feature['key'];

            if( $feature['status'] )
            {
                $content .= "#### START BLOCK ".$name." ####\n";
                foreach($feature['entry'] as $entry)
                {
                    $content .= $entry."\n";
                }
                $content .= "#### END BLOCK ####\n\n";
            }
        }
        return $content;
    }

    // From DB string to PHP variables.
    /**
     * get features as array or object based on type
     * @param  string $type type can be array or object
     * @return [mixed]       [description]
     */
    public function getFeatures($type='array')
    {
        if ($type === 'array')
            return json_decode(json_encode($this->features), true);
        elseif ($type === 'object')
            return $this->features;
        else
            return false;
    }
    
    public function setFeatures($features)
    {   
        if (is_array($features)) {
            $this->features = json_decode( json_encode($features) );
        } elseif (is_object($features)) {
            $this->features = $features;
        } else {
            return false;
        }
    }

    public function save_file_novalidation($filepath=false)
    {
        if (empty($filepath))
            return false;

        return $this->save_file($filepath);
        /*$content = $this->getHtaccessContent();
        $cs = new CommonStorage();
        return $cs->writePage($filepath, $content);*/
    }

    public function save_file($filepath=false, $returncontent=false)
    {
        $content = $this->getHtaccessContent();

        if ($returncontent)
            return $content;


        if (empty($filepath))
            $file = '.htaccess';
        else
            $file = $filepath;

        if ( substr($file, 0, 9) === '.htaccess' ){
            return $this->site->storage()->writePage($file, $content);
        } else {
            $cs = new CommonStorage();
            return $cs->writeFile($file, $content);
        }
    }

    public static function getDefaultFeatures()
    {
        $object = new \stdclass;

        $object->{'redirect-www'} = [
                        'priority' => 0,
                        'status' => true,
                        'entry' => [
                            "RewriteEngine on",
                            "RewriteCond %{HTTPS} off",
                            "RewriteCond %{HTTP_HOST} !\.webstarts\.com$ [NC]", // Not on WebStarts SubDomain
                            "RewriteCond %{HTTP_HOST} !^www\. [NC]", // Not have WWW
                            "RewriteRule ^(.*)$ http://www.%{HTTP_HOST}/$1 [R=301,L]" // Go to WWW
                        ]
                    ];

        $object->{'render-PHP'} = [
                        'priority' => 1,
                        'status' => false, //by default add this rule true|false
                        'entry' => [
                            "RewriteEngine on",
                            "RewriteCond %{REQUEST_URI} !unpaid.html [NC]",
                            "RewriteRule ^([a-z0-9_\-]*\.html)\$ /render.php?for=\$1&%{QUERY_STRING}"
                        ]
                    ];

        $object->{'membership-app'} = [
                        'priority' => 2,
                        'status' => false,
                        'entry' => [
                            "AddHandler mywrapper2 .html",
                            "Action mywrapper2 /Scripts/authentication.php"
                        ]
                    ];

        $object->{'redirect-404'} = [
                'priority' => 3,
                'status' => true,
                'entry' => [
                    "ErrorDocument 404 /404.html"
                ]
            ];

        return $object;
    }
}
