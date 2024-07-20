<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Butschster\Head\Facades\Meta;
use App\Helpers\MetaData;
use App\Helpers\AuthWs;
use App\Helpers\WebstartsHelper;
use App\Models\Product;
use App\Models\User;

class HomeController extends Controller
{
    protected $meta;
 
    public function __contruct(MetaInterface $meta)
    {
        $this->meta = $meta;
    }

    public function home(Request $request)
    {
        // Affiliate
        $aff = $request->input('aff', false);
        if ($aff) {
            try{
                WebstartsHelper::track_affiliate($aff);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        // Inviter
        $rc = $request->input('rc', false);
        if ($rc) {
            try{
                WebstartsHelper::inviter($rc);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
        

        $meta = new \stdClass();
        $meta->title = 'Free Website Builder | Make a Free Website | WebStarts';
        $meta->canonical = env('COR_URL');
        $meta->isHome = true;
        MetaData::set($meta);

        Meta::includePackages(['icons', 'jquery', 'app'/* , 'moment' */]);

        Meta::addScript('home.js', asset('js/home.js'), ['defer', 'async']);

        /* Meta::addStyle('home', asset('css/home.css'), [
            'media' => 'print', 'defer', 'async', 'onload' => 'this.media=`all`; this.onload = ``'
        ]); */

        Meta::addStyle('testimonialslider', asset('css/testimonialslider.css'), [
            'media' => 'print', 'defer', 'async', 'onload' => 'this.media=`all`; this.onload = ``'
        ]);

        Meta::addStyle('faq', asset('css/faq.css'), [
            'media' => 'print', 'defer', 'async', 'onload' => 'this.media=`all`; this.onload = ``'
        ]);

        return view('home');
    }

    public function faq(Request $request)
    {
        $meta = new \stdClass();
        $meta->title = 'Frequently Asked Questions | WebStarts';
        $meta->keywords = ['FAQ', 'WebStarts Questions', 'Free Website', 'Make A Free Website', 'Create A Free Website', 'Website Builder', 'Free Website Builder', 'Free Hosting', 'Make Website'];
        $meta->description = 'Frequently asked questions about WebStarts free website builder.';
        MetaData::set($meta);

        Meta::includePackages(['icons', 'jquery', 'app']);

        return view('faq');
    }

    public function testimonials(Request $request)
    {
        $meta = new \stdClass();
        $meta->title = 'Client Testimonials | WebStarts';
        $meta->keywords = ['webstarts customer testimonials', 'webstarts reviews', 'create personal websites', 'recommend webstarts', 'affordable website', 'cost-effective web design'];
        $meta->description = 'Take a look at what Webstarts customers have to say about the Webstarts free website builder.';
        MetaData::set($meta);

        Meta::includePackages(['icons', 'jquery', 'app']);

        return view('testimonials');
    }

    public function about(Request $request)
    {
        $meta = new \stdClass();
        $meta->title = 'About Us | WebStarts';
        $meta->keywords = ['About Us', 'WebStarts Story', 'Free Website', 'Make A Free Website', 'Create A Free Website', 'Website Builder', 'Free Website Builder', 'Free Hosting', 'Make Website'];
        $meta->description = 'About Us. WebStarts is everything you need to build and maintain your own website.';
        MetaData::set($meta);

        Meta::includePackages(['icons', 'jquery', 'app']);

        return view('about');
    }

    public function features(Request $request)
    {
        // SEO not ready yet
        $meta = new \stdClass();
        $meta->title = 'WebStarts Store Features | WebStarts';
        $meta->keywords = ['Free Website', 'Make A Free Website', 'Create A Free Website', 'Website Builder', 'Free Website Builder', 'Free Hosting', 'Make Website'];
        $meta->description = 'Everything you need to launch and manage your own web design agency.';
        MetaData::set($meta);

        Meta::includePackages(['icons', 'jquery', 'app']);

        return view('store-features');
    }

    public function terms(Request $request)
    {
        $meta = new \stdClass();
        $meta->title = 'Terms and Conditions | WebStarts';
        $meta->keywords = ['promote your website', 'website terms and conditions', 'web hosting, create web pages'];
        $meta->description = 'Webstarts Website Builder Terms and Conditions. View our terms and conditions as they relate to your Webstarts account.';
        MetaData::set($meta);

        Meta::includePackages(['icons', 'jquery', 'app']);

        return view('terms');
    }

    public function privacy(Request $request)
    {
        $meta = new \stdClass();
        $meta->title = 'Privacy Policy | WebStarts';
        $meta->keywords = ['free web hosting', 'webstarts privacy policy', 'internet privacy', 'website privacy'];
        $meta->description = 'Your privacy on the Internet is of the utmost importance to Webstarts. We want to make your online experience satisfying and safe.';
        MetaData::set($meta);

        Meta::includePackages(['icons', 'jquery', 'app']);

        return view('privacy');
    }

    public function pricing(Request $request)
    {
        $meta = new \stdClass();
        $meta->title = 'Pricing Plans & Premium Upgrades: 1.800.805.0920 | WebStarts';
        $meta->keywords = ['Free Website', 'Make A Free Website', 'Create A Free Website', 'Website Builder', 'Free Website Builder', 'Free Hosting', 'Make Website'];
        $meta->description = 'Webstarts Website Builder Features - View a full list of features available to you when creating a website with Webstarts.';
        MetaData::set($meta);

        //Meta::includePackages(['icons', 'material', 'app']);
        Meta::includePackages(['icons', 'jquery', 'app']);

        Meta::addStyle('index-pricing', asset('css/index-pricing.css'), [
            'media' => 'print', 'defer', 'async', 'onload' => 'this.media=`all`; this.onload = ``'
        ]);

        Meta::addStyle('pricing-page', asset('css/pricing-page.css'), [
            'media' => 'print', 'defer', 'async', 'onload' => 'this.media=`all`; this.onload = ``'
        ]);

		// Get the price and beforeprice of pro plus for the pricing page
        $proplus = Product::where('active', 1)->where('pcode', 'PROPLUS_11_1Y')->first();
		$proplus_price = number_format(round($proplus->price/12, 2), 2);
		$proplus_price_before = number_format(round($proplus->beforeprice/12, 2), 2);
		$tmp = explode(".", $proplus_price);
		$proplus_price_major = $tmp[0];
		$proplus_price_minor = $tmp[1];

		// Get the price and beforeprice of Business for the pricing page
        $business = Product::where('active', 1)->where('pcode', 'PROPLUS_BUSINESS_PLUS_1Y')->first();
		$business_price = number_format(round($business->price/12, 2), 2);
		$business_price_before = number_format(round($business->beforeprice/12, 2), 2);
		$tmp = explode(".", $business_price);
		$business_price_major = $tmp[0];
		$business_price_minor = $tmp[1];


        return view('index-pricing', [
            'symbol' => '$',
            'proplus_price' => $proplus_price,
            'proplus_price_before' => $proplus_price_before,
            'proplus_price_major' => $proplus_price_major,
            'proplus_price_minor' => $proplus_price_minor,

            'business_price' => $business_price,
            'business_price_before' => $business_price_before,
            'business_price_major' => $business_price_major,
            'business_price_minor' => $business_price_minor,
        ]);
    }

    public function plans(Request $request)
    {
        $meta = new \stdClass();
        $meta->title = 'Pricing Plans & Premium Upgrades: 1.800.805.0920 | WebStarts';
        $meta->keywords = ['Free Website', 'Make A Free Website', 'Create A Free Website', 'Website Builder', 'Free Website Builder', 'Free Hosting', 'Make Website'];
        $meta->description = 'Webstarts Website Builder Features - View a full list of features available to you when creating a website with Webstarts.';
        MetaData::set($meta);

        //Meta::includePackages(['icons', 'material', 'app']);
        Meta::includePackages(['icons', 'jquery', 'app']);

        Meta::addStyle('index-pricing', asset('css/index-pricing.css'), [
            'media' => 'print', 'defer', 'async', 'onload' => 'this.media=`all`; this.onload = ``'
        ]);

        Meta::addStyle('pricing-page', asset('css/pricing-page.css'), [
            'media' => 'print', 'defer', 'async', 'onload' => 'this.media=`all`; this.onload = ``'
        ]);

        
        $plans = Product::select('id', 'pcode', 'name', 'simple_name', 'description', 'key_features', 'price', 'beforeprice', 'domainnames', 'emailaccounts', 'websites', 'storagespace', 'bandwidth', 'phonesupport', 'recursion', 'trial_days')
            ->where(function ($query) {
                $query->where('pcode', 'LIKE', 'T_INDIVIDUAL_%')
                    ->orWhere('pcode', 'LIKE', 'T_BUSINESS_%')
                    ->orWhere('pcode', 'LIKE', 'T_STUDIO_%');
            })
            ->where('active', 1)
            ->orderBy('id', 'ASC')
            ->get();


        return view('plans', compact('plans'));
    }


    public function storeFeatures(Request $request)
    {
        $meta = new \stdClass();
        $meta->title = 'WebStarts Store Features | WebStarts';
        $meta->keywords = ['Free Website', 'Make A Free Website', 'Create A Free Website', 'Website Builder', 'Free Website Builder', 'Free Hosting', 'Make Website'];
        $meta->description = 'WebStarts website builder includes so many features so you can make a unique and powerful website.';
        MetaData::set($meta);

        Meta::includePackages(['icons', 'jquery', 'app']);

        return view('store-features');
    }


    public function checkout(Request $request)
    {
        $meta = new \stdClass();
        $meta->title = 'WebStarts Checkout | Free Website Builder | WebStarts';
        $meta->keywords = ['Free Website', 'Make A Free Website', 'Create A Free Website', 'Website Builder', 'Free Website Builder', 'Free Hosting', 'Make Website'];
        $meta->description = 'Call us at 1-800-805-0920. Make a free website with the #1 free website builder and get ranked on Google, Yahoo and Bing. When you create a free website, it includes free web hosting.';
        MetaData::set($meta);

        Meta::includePackages(['icons', 'jquery', 'app']);

        return view('checkout');
    }

}
