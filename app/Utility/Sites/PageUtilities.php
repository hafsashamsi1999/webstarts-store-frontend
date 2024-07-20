<?php

namespace App\Utility\Sites;

use App\Models\Pages;

class PageUtilities
{
    public $commonPagesTitle = [
                'index.html'=>'Home',
                'about.html'=>'About',
                'contact.html'=>'Contact',
                'photos.html'=>'Photos',
                'profile.html'=>'Profile'
            ];

    public static function getPageTitle($page)
    {
        $commonPages = self::commonPagesTitle;

        if($commonPages[strtolower($page['name'])] != '')
            $pageTitle = $commonPages[strtolower($page['name'])];
        else{
            if( substr($page['name'], -4) == ".htm" )
                $pageTitle = ucfirst(str_replace('.htm', '', $page['name']));
            else
                $pageTitle = ucfirst(str_replace('.html', '', $page['name']));
        }

        return $pageTitle;
    }
}
