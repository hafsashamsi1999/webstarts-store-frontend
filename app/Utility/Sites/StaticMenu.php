<?php


namespace App\Utility\Sites;


use Illuminate\Support\Facades\Log;
use App\Models\Sites;
use App\Models\Pages;
use App\Utility\simple_html_dom;


class StaticMenu
{
    protected $site;
    protected $siteURL;
    protected $siteLevel;
    protected $excludePages;

    function __construct(Sites $site)
    {
        $this->site = $site;

        $this->siteURL = [$this->site->getTitle('', false)];

        if( ! empty($this->site->domain) ) {
            $domain = $this->site->getTitle('');
            $this->siteURL[] = $domain;
            $this->siteURL[] = str_replace('http://', 'https://', $domain);
        }

        $this->siteLevel = $this->site->getPlanLevel();

        $this->excludePages = ['__blog_post.html', '__store_product.html'];
    }

    function getDom($filePath)
    {
        $html = false;
        $html_str = $this->site->storage()->readPage($filePath);

        if($html_str) {
            $html = new simple_html_dom();
            $html->load($html_str, true, false);
        }

        return $html;
    }

    function updateStaticMenu()
    {
        if( $this->site->id ) {

            if($this->site->dynamic) {

                $dest = 'include/';
                // Find the menu

                $pages = array(
                    'header.html' => $dest.'header.html',
                    'shared.html' => $dest.'shared.html',
                    'footer.html' => $dest.'footer.html'
                );

                $menuUpdated = false;

                foreach($pages as $page => $file) {

                    if($menuUpdated) continue;

                    $html = $this->getDom($file);

                    if($html === false) continue;

                    foreach($html->find('.wse-men') as $menu) {

                        foreach($menu->find('> nav') as $nav)
                        {
                            $options = array(
                                'sameSize' => $nav->getAttribute('data-menu-same-size'),
                                'orientation' => $nav->getAttribute('data-menu-orientation'),
                                'fillSpace' => $nav->getAttribute('data-menu-fill-space'),
                                'spacing' => $nav->getAttribute('data-menu-spacing')
                            );

                            if( $nav->getAttribute('data-menu-moretab') === false) {
                                $nav->setAttribute('data-menu-moretab', '1');
                            }

                            $script = $html->find('#activate-static-menu');
                            if( ! is_array($script) || count($script) == 0 ) {

                                $id = $menu->getAttribute('id');
                                $inlineScript = '<script id="activate-static-menu" type="text/javascript">'.
                                    '_ws.activateNav(document.getElementById("'.$id.'"));'.
                                    '</script>';

                                $menu->outertext = $menu->outertext . $inlineScript;
                            }

                            // Get Classes

                            foreach($nav->find('> ul > li > a[href]') as $el)
                            {
                                $options['class1'] = $el->getAttribute('class');
                            }
                            foreach($nav->find('> ul > li > ul > li > a[href]') as $el)
                            {
                                $options['class2'] = $el->getAttribute('class');
                            }

                            foreach($nav->find('> ul > li') as $el)
                            {
                                $options['style'] = $el->getAttribute('style');
                            }

                            /*
                                Very strange issue, since we save the parent $menu->outertext above, its seems like its overwriting the menu and we lost changes,
                                So as a work around, I extract the HTML from DOM first
                            */

                            $html_str = $html->save();
                            $html->clear();

                            $html = new simple_html_dom();
                            $html->load($html_str, true, false);

                            foreach($html->find('.wse-men > nav > ul') as $ul)
                            {
                                if($menuUpdated === false) {
                                    $updatedHTML = $this->getUpdatedHTML($options);

                                    $ul->innertext = $updatedHTML;
                                    $html_str = $html->save();
                                    $html->clear();

                                    $return = $this->site->storage()->writePage($file, $html_str);

                                    if( ! $return) {
                                        Log::error("siteid: $this->site->id file_put_contents returns false ".__FILE__);
                                    }

                                    $menuUpdated = true;
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                throw new Exception("This site ($this->site->id) is using an older version of the editor that does not support static menu");
            }
        }
        else
        {
            throw new Exception("Could not select site $this->site->id");
        }
    }
    function getUpdatedHTML($options, $parentId = 0)
    {
        $html = '';
        $class = '';
        $style = '';

        $allPages = Pages::where([
            ['siteid','=',$this->site->id],
            ['displayOnMenu','=','1'],
            ['active','=','1'],
            ['parentId','=', $parentId]
        ])->orderBY('pOrder')->get();

        $count = count($allPages);

        if( $count > 0){

            foreach($allPages as $page) {

                if( in_array($page->name, $this->excludePages) ) continue;

                $target = $page->target == '1' ? ' target="_blank"' : '';
                $href = $this->getHref($page);
                $rel = $this->getRel($page);
                $ul = $this->getUpdatedHTML($options, $page->id);

                $arrowClass = empty($ul) ? '' : ' sub';

                if($parentId > 0) {
                    $class = empty($options['class2']) ? '':' class="'.$options['class2'].$arrowClass.'"';
                } else {
                    $class = empty($options['class1']) ? '':' class="'.$options['class1'].$arrowClass.'"';
                    $style = (! empty($options['style']) && $options['sameSize'] == '1') ? ' style="'.$options['style'].'"' : '';
                }

                $html .= '<li'.$style.'>'.
                    '<a '.$rel.'data-title="'.$page->title.'" data-id="'.$page->id.'" data-external="'.$page->external.'"'.$class.' href="'.$href.'"'.$target.'>'.
                    '<span class="page-title">'.
                    '<span class="page-title-inner">'.$page->title.'</span>'.
                    '</span>'.
                    '</a>'.
                    $ul.
                    '</li>';
            }
        }

        if($parentId > 0 && !empty($html)) {
            $html = '<ul>'. $html . '</ul>';
        }

        return $html;
    }

    function getRel(Pages $page) {

        if($page->external == '1' && $this->siteLevel == 'Free') {

            $found = false;

            foreach($this->siteURL as $siteURL) {
                if( preg_match('%'.$siteURL.'%i', $page->url) ) {
                    $found = true;
                }
            }

            if(!$found) {
                return 'rel="nofollow" ';
            }
        }

        return '';
    }

    function getHref(Pages $page) {

        $url = '';
        if($page->external) {
            // Because I came to know page anchors for eg. about.html#goto-anchor-1447275616958 saved in pages[name] and not in pages[url] in DB
            $url = !empty($page->url) ? $page->url : $page->name;
        } else {
            switch($page->name) {
                case '__blog.html':
                    $url = 'blog';
                    break;
                case '__blog_post.html':
                    $url = 'blog/post/newest';
                    break;
                case '__store.html':
                    $url = 'store';
                    break;
                case '__store_product.html':
                    $url = 'store/product/newest';
                    break;
                case '__store_cart.html':
                    $url = 'store/cart';
                    break;
                case '__store_login.html':
                    $url = 'store/login';
                    break;
                case '__store_account.html':
                    $url = 'store/account';
                    break;
                default:
                    $url = $page->name;
                    break;
            }
        }

        return $url;
    }
}
