<?php

namespace App\Helpers;

/**
 * By Humayun
 * 17 March 2020
 * A general validation class for quickly check anything in webstarts project.
 */
class Validation
{
    public static function domainName(string $domain)
    {
        // FQDN Domain name regex.
        $pattern = '/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/i';
        return preg_match($pattern, strtolower($domain)) ? true : false;
    }

    public static function subdomain(string $subdomain)
    {
        $pattern = '/^(?!\-)([a-zA-Z0-9][a-zA-Z0-9-]*\.)*[a-zA-Z0-9]*[a-zA-Z0-9-]*[[a-zA-Z0-9]+$/i';
        return preg_match($pattern, strtolower($subdomain)) ? true : false;
    }

    public static function hostname(string $hostname)
    {
        return self::domainName($hostname);
    }

    public static function ip($ip)
    {
        //first of all the format of the ip address is matched
        if (preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/",$ip))
        {
            //now all the intger values are separated
            $parts=explode(".",$ip);
            //now we need to check each part can range from 0-255
            foreach($parts as $ip_parts)
            {
                if(intval($ip_parts)>255 || intval($ip_parts)<0)
                    return false; //if number is not within range of 0-255
            }
            return true;
        }
        else
            return false; //if format of ip address doesn't matches
    }

    public static function nameserver($ns)
    {
        $pattern = '/^([a-z0-9]+)\.([a-z0-9]+)\.([a-z]{2,8})$/';
        return preg_match($pattern, strtolower($ns)) ? true : false;
    }

    public static function url($url)
    {
        // Based on http://www.apps.ietf.org/rfc/rfc1738.html#sec-5
        if ( ! preg_match(
            '~^

            # scheme
            [-a-z0-9+.]++://

            # username:password (optional)
            (?:
                    [-a-z0-9$_.+!*\'(),;?&=%]++   # username
                (?::[-a-z0-9$_.+!*\'(),;?&=%]++)? # password (optional)
                @
            )?

            (?:
                # ip address
                \d{1,3}+(?:\.\d{1,3}+){3}+

                | # or

                # hostname (captured)
                (
                         (?!-)[-a-z0-9]{1,63}+(?<!-)
                    (?:\.(?!-)[-a-z0-9]{1,63}+(?<!-)){0,126}+
                )
            )

            # port (optional)
            (?::\d{1,5}+)?

            # path (optional)
            (?:/.*)?

            $~iDx', $url, $matches))
            return FALSE;

        // We matched an IP address
        if ( ! isset($matches[1]))
            return TRUE;

        // Check maximum length of the whole hostname
        // http://en.wikipedia.org/wiki/Domain_name#cite_note-0
        if (strlen($matches[1]) > 253)
            return FALSE;

        // An extra check for the top level domain
        // It must start with a letter
        $tld = ltrim(substr($matches[1], (int) strrpos($matches[1], '.')), '.');
        return ctype_alpha($tld[0]);
    }
    
    public static function email($email)
    {
        if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email))
            return false;
        
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        
        for ($i = 0; $i < sizeof($local_array); $i++)
        {
            if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i]))
              return false;
        }
        
        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1]))
        {
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2)
                return false;
            
            for ($i = 0; $i < sizeof($domain_array); $i++)
            {
                if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i]))
                    return false;
            }
        }
        
        return true;
    }

    public static function aplha($str)
    {
        if(preg_match("/^([-a-z])+$/i", $str))
            return true;
        else
            return false;
    }
    
    public static function numeric($n)
    {
        if(preg_match("/^([0-9])+$/i", $n))
            return true;
        else
            return false;
    }
    
    public static function aplhaNumeric($str)
    {
        if(preg_match("/^([-a-z0-9])+$/i", $str))
            return true;
        else
            return false;
    }
}
