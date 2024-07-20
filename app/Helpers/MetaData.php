<?php

namespace App\Helpers;

use Butschster\Head\Facades\Meta;
use Butschster\Head\MetaTags\Entities\Webmaster;
use Butschster\Head\Packages\Entities\OpenGraphPackage;
use Butschster\Head\Packages\Entities\TwitterCardPackage;
use Butschster\Head\MetaTags\Entities\GoogleAnalytics;
use App\Helpers\SchemaTag;

class MetaData {
    public static function set($meta)
    {
        //https://github.com/butschster/LaravelMetaTags

        $title = 'Free Website Builder | Make a Free Website | WebStarts';

        $isHome = false;

        if(isSet($meta->isHome)) {
            $isHome = true;
        }

        if(isSet($meta->title)) {
            $title = $meta->title;
        }

        $keywords = ['Free Website', 'Website Builder', 'Free Website Builder', 'Create A Website', 'Create A Free Website', 'Make A Website', 'Make A Free Website', 'Build A Website', 'Build A Free Website'];

        if(isSet($meta->keywords)) {
            $keywords = $meta->keywords;
        }

        $description = 'Call us at 1-800-805-0920. Make a free website with the #1 free website builder and get ranked on Google, Yahoo and Bing. When you create a free website, it includes free web hosting.';

        if(isSet($meta->description)) {
            $description = $meta->description;
        }

        //$reqUri = isSet($_SERVER['SCRIPT_URI']) ? $_SERVER['SCRIPT_URI'] : str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);
        $reqUri = $_SERVER['REQUEST_URI'];
        $canonical = env('COR_URL').$reqUri;

        if(isSet($meta->canonical)) {
            $canonical = $meta->canonical;
        }

        Meta::setContentType('text/html');

        Meta::setTitle($title);
        Meta::setKeywords($keywords);
        Meta::setDescription($description);
        Meta::setCanonical($canonical);

        // CSP Meta
        /* Meta::addMeta('csp-meta', [
            'http-equiv' => "Content-Security-Policy",
            'content' => "script-src 'none'",
        ]); */

        Meta::addLink('preconnect1', [
            'rel' => 'preconnect',
            'href' => 'https://fonts.googleapis.com/',
        ]);

        Meta::addLink('preconnect2', [
            'rel' => 'preconnect',
            'href' => 'https://fonts.gstatic.com/',
            'crossorigin' => 'anonymous',
        ]);

        Meta::addLink('preconnect3', [
            'rel' => 'preconnect',
            'href' => 'https://files.secure.website/',
        ]);

        if(isSet( $meta->noindex ) && $meta->noindex) {
            Meta::setRobots('noindex,follow');
        } else {
            Meta::setRobots('index,follow');
        }
        
        Meta::addWebmaster(Webmaster::GOOGLE, 'E84LMFIRoyePf7HbZ0VSbgQET9NRV4EUQwk5j1WZpk0');
        Meta::addMeta('wot-verification', [
            'content' => 'd9adfa3a5e53754dae54',
        ]);

        $image = 'https://files.secure.website/wscfus/10219978/3949291/minimal-logo-source-png-w500-o.png';

        if(isSet($meta->image)) {
            $image = $meta->image;
        }

        $og = new OpenGraphPackage('facebook');
        $og->setType('website')
            ->setSiteName('webstarts.com')
            ->setTitle($title)
            ->setDescription($description)
            ->setUrl($canonical)
            ->addImage($image, ['type' => 'image/png', 'width' => '500', 'height' => '500', 'secure_url' => $image]);

        Meta::registerPackage($og);

        $card = new TwitterCardPackage('twitter');

        $card->setType('summary_large_image')
            ->setSite('@webstarts')
            ->setTitle($title)
            ->setDescription($description)
            ->setImage($image);

        Meta::registerPackage($card);

        $script = new GoogleAnalytics('UA-10429317-1');
        Meta::addTag('google.analytics', $script);

        if($isHome) {
            $schemaTag = new SchemaTag([
                "@context" => "http://schema.org",
                "@type" => "Organization",
                "name" => "WebStarts.com",
                "alternateName" => "WebStarts",
                "url" => "https://www.webstarts.com",
                "logo" => "https://files.secure.website/img2/ws-logo.png",
                'sameAs' => [
                    'https://www.facebook.com/webstarts',
                    'https://www.twitter.com/webstarts',
                    'https://www.youtube.com/user/webstarts',
                    'https://www.instagram.com/freewebsitebuilder',
                    'https://www.pinterest.com/webstarts.com',
                    'https://www.linkedin.com/company/webstarts',
                    'https://plus.google.com/+webstarts'
                ]
            ]);
    
            Meta::addTag('schema', $schemaTag);
        }
    }
}