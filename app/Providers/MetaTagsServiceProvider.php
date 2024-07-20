<?php

namespace App\Providers;

use Butschster\Head\Contracts\Packages\PackageInterface;
use Butschster\Head\Facades\PackageManager;
use Butschster\Head\Packages\Package;
use Butschster\Head\MetaTags\Meta;
use Butschster\Head\MetaTags\Entities\Favicon;
use Butschster\Head\MetaTags\Entities\ConditionalComment;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\Contracts\Packages\ManagerInterface;
use Butschster\Head\Providers\MetaTagsApplicationServiceProvider as ServiceProvider;

class MetaTagsServiceProvider extends ServiceProvider
{
    protected function packages()
    {
        // Create your own packages here
        /*PackageManager::create('favicons', function(Package $package) {
            $sizes = ['16x16', '32x32', '64x64'];

            foreach ($sizes as $size) {
                $package->addTag(
                    'favicon.'.$size,
                    new Favicon('https://site.com/favicon-'.$size.'.png', [
                        'sizes' => $size
                    ])
                );
            }

            $package->addTag('favicon.ie', new ConditionalComment(
                new Favicon('https://site.com/favicon-ie.png'), 'IE gt 6'
            ));
        });*/
        PackageManager::create('jquery', function(Package $package) {
            $package->addScript(
               'jquery.js', 
               'https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js',
               ['defer']
            );
        });

        PackageManager::create('jquery-old', function(Package $package) {
            $package->addScript(
               'jquery.js', 
               'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',
               ['defer']
            );
        });

        PackageManager::create('moment', function(Package $package) {
            $package->addScript(
               'moment.js', 
               'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js',
               ['defer']
            );
        });

        PackageManager::create('main-font', function(Package $package) {
            $package->addStyle('main-font', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700,800,900&display=swap', [
                'media' => 'print', 'defer', 'async', 'onload' => 'this.media=`all`; this.onload = ``'
            ]);
        });

        PackageManager::create('app-css', function(Package $package) {
            $package->requires('main-font');
            $package->addStyle('app.css', asset('css/app.css'),
               ['media' => 'all', 'defer', 'async']
            );
        });

        PackageManager::create('app', function(Package $package) {
            $package->requires('app-css');
            $package->addScript(
               'app.js',
               asset('js/app.js'),
               ['defer']
            );
        });

        PackageManager::create('bootstrap', function(Package $package) {
            $package->requires('jquery-old');
            $package->addScript(
               'bootstrap.js', 
               'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', 
               ['defer']
            );
        });

        PackageManager::create('material', function(Package $package) {
            $package->requires('bootstrap');
            $package->addStyle('ripples-css', 'https://cdn.secure.website/ws/1631048375/library/ripples.min.css', [
                'media' => 'print', 'defer', 'async', 'onload' => 'this.media=`all`; this.onload = ``'
            ]);
            $package->addScript(
                'arrive.js', 
                'https://cdnjs.cloudflare.com/ajax/libs/arrive/2.4.1/arrive.min.js', 
                ['defer']
             );
            $package->addScript(
               'ripples.js', 
               'https://cdn.secure.website/ws/1631048375/library/ripples.min.js', 
               ['defer']
            );
            $package->addScript(
                'material.js',
                'https://cdn.secure.website/ws/1631048375/library/material.min.js', 
                ['defer']
             );
            $package->addScript(
               'ui-common.js', 
               'https://cdn.secure.website/ws/1631048375/library/ui-common.min.js', 
               ['defer']
            );
        });

        PackageManager::create('icons', function(Package $package) {
            $package->addStyle('mt-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons&display=swap', [
                'media' => 'print', 'defer', 'async', 'onload' => 'this.media=`all`; this.onload = ``'
            ]);
        });

        PackageManager::create('fa-icons', function(Package $package) {
            $package->addStyle('fa-icons', 'https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css', [
                'media' => 'print', 'defer', 'async', 'onload' => 'this.media=`all`; this.onload = ``'
            ]);
        });
    }

    // if you don't want to change anything in this method just remove it
    protected function registerMeta(): void
    {
        $this->app->singleton(MetaInterface::class, function () {
            $meta = new Meta(
                $this->app[ManagerInterface::class],
                $this->app['config']
            );

            // It just an imagination, you can automatically
            // add favicon if it exists
            // if (file_exists(public_path('favicon.ico'))) {
            //    $meta->setFavicon('/favicon.ico');
            // }

            // This method gets default values from config and creates tags, includes default packages, e.t.c
            // If you don't want to use default values just remove it.
            $meta->initialize();

            return $meta;
        });
    }
}
