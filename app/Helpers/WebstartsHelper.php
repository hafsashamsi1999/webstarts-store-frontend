<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Adminuser;
use App\Models\AffHit;
use App\Models\ContributorInvite;
use App\Models\InviterCode;

/**
 * By Humayun
 * 17 March 2020
 * A general Helper class for quick and handy works in webstarts project.
 */
class WebstartsHelper
{
    // Get FQDN (Fully Qualified Domain Name)
    // Makes and return fully qualified domain name by replacing unnecessary http(s)://www. characters from the domain name
    public static function __fqdn( $domain, $prepend_string = false )
    {
        if ( ! $domain )
            return false;

        $replacewords = ['http://www.', 'http://', 'https://www.', 'https://', 'www.'];
        $domain = trim(strtolower($domain));

        foreach ($replacewords as $targetword) {
            if (substr($domain, 0, strlen($targetword)) === $targetword )
                $domain = substr($domain, strlen($targetword));
        }

        if( $prepend_string )
            $domain = $prepend_string . $domain;

        return $domain;
    }

    /* This function extracts TLD parts from a domain name.
        Only applies to a domain and NOT FOR SUBDOMAINS.
        Domain examples are example.com, example.co.uk, example.website etc
    */
    public static function extractTLDFromDomain($domain)
    {
        if (empty($domain)) {
            return null;
        }

        $tlds = array();
        $str_parts = explode('.',$domain);
        for ($i = count($str_parts)-1; $i>0; $i--) {
            $tlds[] = $str_parts[$i]; # saving backwards i.e. uk.co
        }

        // Let's reverse it
        $reversed = array_reverse($tlds);
        // Concat the parts with dot(.) now i.e. co.uk
        $tld_str = implode('.',$reversed);
        return '.'.$tld_str; // Make a proper tld now i.e. .co.uk or .com etc
    }

    /**
     * Track affiliate and perform related actions.
     *
     * @param datatype $aff description
     */
    public static function track_affiliate($aff)
    {
        $cookieDomain = '.webstarts.com';

        if(! Cookie::has('ws_aff')) {
            Cookie::queue(Cookie::make('ws_aff', $aff, 0, "/", $cookieDomain, true, true));

            if(! Cookie::has('set_hit')) {
                Cookie::queue(Cookie::make('set_hit', true, 0, "/", $cookieDomain, true, true));

                $adminUser = Adminuser::where('username', $aff)->first();

                if (!is_null($adminUser)) {
                    AffHit::create([
                        'affiliateid' => $adminUser->clientId,
                        'timestamp' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
    }

    /**
     * Verify the invite with the given code.
     *
     * @param datatype $code description
     * @return datatype
     */
    public static function verifyInvite($code)
    {
        $inviter = InviterCode::where('code', $code)->first();

        if (!is_null($inviter)) {
            return $inviter->user_id;
        }

        return false;
    }

    /**
     * Perform the action of inviting a user.
     *
     * @param datatype $rc description
     */
    public static function inviter($rc)
    {
        if(WebstartsHelper::verifyInvite($rc))
        {
            Session::put('inviter', $rc);
        }
    }

    /**
     * A function to validate an invite token.
     *
     * @param string $invite_token The Contributor invite token to be validated
     * @return ContributorInvite|bool The contributor invite if valid, false otherwise
     */
    public static function valid_invite_token($invite_token='false')
    {
        $contrib_invite = ContributorInvite::where('invite_token', $invite_token)->first();

        if (!is_null($contrib_invite)) {
            return $contrib_invite;
        } else {
            return false;
        }
    }
}
