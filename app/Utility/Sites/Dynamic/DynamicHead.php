<?php

    namespace App\Utility\Sites\Dynamic;

    use App\Utility\Sites\Dynamic\DynamicPageHead;

	class DynamicHead
	{
		public $includefolder = 'include';
        public $head_file = 'head.json';

        public $head_place_holder = '<head>';
        public $head_pattern = '%<head>%si';
        public $end_body_place_holder = '</body>';
        public $body_pattern = '%<\/body>%si';
        public $start_body_pattern = '%<body[^>]*>%si';

        public $render_viewports_id = 'renderViewports';
        public $converted_viewports_id = 'convertedViewports';
        public $json = false;
        public $html_file = false;

        public $head_html = '';
        public $end_body_html = '';
        protected $storage = null;

		function __construct($storage=null)
		{
			$this->head_file = $this->includefolder. '/' .$this->head_file;
            $this->storage = $storage;
		}

        public static function remove_node($folder, $id)
        {
            if (empty($folder)) {
                return FALSE;
            }

            if(substr($folder, -1) != '/') { // Make sure we have a slash at the end
                $folder .= '/';
            }

            $dh = new DynamicHead();
            $dh->remove_json_entity($folder, $id, TRUE);
        }

        public static function sort_entities($entities)
        {
            // Create a mappable array of entities by order
            $map = array();
            foreach($entities as $key => $entity)
            {
                $map[$entity['id']] = $key;
            }

            // Create a dependency configuration, so that we can ensure that dependencies are loaded before their dependants
            $dependencyConfig = array(
                'store-widgets.js' => array('react-bundle.js'),
                'blog-widgets.js' => array('react-bundle.js')
            );
            foreach($dependencyConfig as $dependant => $dependencies)
            {
                foreach($dependencies as $dependency)
                {
                    // Verify that the dependant and dependency are both available before continuing
                    // NOTE: This only handles sorting, not injecting when a dependency is missing
                    if( ! isset($map[$dependency])) continue;
                    if( ! isset($map[$dependant])) continue;

                    // If a dependency is showing after a dependant, then show it before
                    $map[$dependency] = min($map[$dependency], $map[$dependant]);
                }
            }

            // Go through and sort based on the updated mapping
            usort($entities, function($a, $b) use ($map) {
                $av = $map[$a['id']];
                $bv = $map[$b['id']];

                if ($av == $bv) {
                    return 0;
                }

                return ($av < $bv) ? -1 : 1;
            });

            return $entities;
        }

        function get_html_with_common_head($folder, $html, $file, $fromEditor=false,$storage)
        {
            if(!empty($storage)) {}
            $this->storage = $storage;
            $this->html_file = $file;

            if( $this->storage->fileExists($this->head_file) ) {
                $this->getHTML($fromEditor);

                if( ! empty($this->head_html))
                {
                    $html = str_replace($this->head_place_holder, "<head>\n".$this->head_html, $html);
                }

                if( ! empty($this->start_body_html))
                {
                    $html = preg_replace($this->start_body_pattern, "$0\n" . $this->start_body_html, $html);
                }

                if( ! empty($this->end_body_html))
                {
                    $html = str_replace($this->end_body_place_holder, $this->end_body_html . "\n</body>", $html);
                }
            }
            return $html;
        }

        function load_json($path='')
        {
            $json_str = '';

            if(is_object($this->storage)) {
                $clazz = get_class($this->storage);
                if(stristr($clazz,'CommonStorage')) {
                    if( $this->storage->exists($path.$this->head_file) ) {
                        $json_str = $this->storage->readPage($path.$this->head_file);
                    }
                } else {
                    if( $this->storage->fileExists($path.$this->head_file) ) {
                        $json_str = $this->storage->readPage($path.$this->head_file);
                    }
                }
            }
            if(!empty($json_str)){
                $this->json = json_decode($json_str, true);
            } else {
                $this->json = array();
            }
            return $this->json;
        }

        function save_json_entities($entities, $update = true,$path="")
        {
            foreach($entities as $entity) {
                $entity_arr = array();

                foreach($entity as $key => $val) {
                    $entity_arr[$key] = $val;
                }

                $this->save_json_entity($entity_arr, false,$path);
            }

            if($update) {
                $json_str = json_encode( $this->json, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
                $this->storage->writePage($this->head_file, $json_str);
            }
        }

        function save_json_entity($obj, $update = true,$path="") {

            if($this->json === false){
                $this->load_json($path);
            }

            if($this->json !== false){

                if(!empty($obj['id'])){
                    $entity = &$this->getEntityById($this->json, $obj['id']);

                    $obj = $this->timestampEntity($obj);

                    if(!empty($entity)){
                        $entity = $obj;
                    } else {
                        array_push($this->json, $obj);
                    }

                    $json_str = json_encode( $this->json, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP  );

                    $directories = explode('/', $this->head_file);
                    $dir = "";
                    for($i = 0; $i < count($directories) - 1; $i++) {
                        $dir .= $directories[$i];
                        if($path != "") {
                            if(!$this->storage->exists($path.$dir)) {
                                $this->storage->makeDirectory($path.$dir);
                            }
                        } else {
                            $this->storage->checkOrCreateFolder($dir);
                        }
                        $dir .= '/';
                    }

                    if($update) {
                        $this->storage->writePage($path.$this->head_file, $json_str);
                    }
                }

                return true;
            } else {
                return false;
            }
        }

        function timestampEntity($entity)
        {
            if( ! array_key_exists('node', $entity)) return $entity;

            $siteCssRegex = '/(https?:)?\/\/static.secure.website\/client-site-resources\/[0-9]*\/css\//i';
            $isSiteCssFile = $entity['node'] === 'link' && array_key_exists('href', $entity) && (substr($entity['href'], 0, 4) === 'css/' || preg_match($siteCssRegex, $entity['href']));

            if($isSiteCssFile)
            {
                $delimiter = '?';

                if(strrpos($entity['href'], '?') !== false)
                {
                    $delimiter = substr($entity['href'], -1) === '?' ? '' : '&';
                    if (preg_match('/\?r=(\d{14})$/', $entity['href'])) {
                        $entity['href'] = preg_replace('/\?r=(\d{14})$/', '', $entity['href']);
                        $delimiter = '?';
                    }
                }

                $entity['href'] = $entity['href'].$delimiter.'r=' . date('YmdHis');
            }

            return $entity;
        }

        function remove_json_entities($entities, $update = true, $path='') {
            foreach($entities as $id) {
                $this->remove_json_entity( $id, false,$path);
            }

            if($update) {
                $json_str = json_encode( $this->json, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
                $this->storage->writePage($path.$this->head_file, $json_str);
            }
        }

        function remove_json_entity( $id = '', $update = true, $path=''){
            if($this->json === false){
                $this->load_json($path);
            }

            if($this->json !== false){
                $found = false;

                foreach($this->json as $key => $item) {
                    if($item['id'] == $id) {
                        unset($this->json[$key]);
                        $this->json = array_values($this->json);
                        $found = true;
                        break;
                    }
                }

                if($found) {
                    $json_str = json_encode( $this->json, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );

                    if($update) {
                        $this->storage->writePage($path.$this->head_file, $json_str);
                    }
                }
            }
        }

        function &getEntityById(&$items, $id=''){
            foreach ($items as &$item) {
                if ($item['id'] == $id) {
                    return $item;
                }
            }
            $emptyArray = array();
            return $emptyArray;
        }

        function getHTML( $fromEditor=false)
        {
            $html = array(
                'meta'  => '',
                'title' => '',
                'css'   => '',
                'js'    => '',
                'other' => ''
            );

            $start_body_html = '';
            // This is for closing body tag html
            $end_body_html = '';

            /* Baseline Meta */
            $html['meta'] .= '<meta charset="utf-8" data-dynamic-entity="1">'."\n";
            $html['meta'] .= '<meta http-equiv="X-UA-Compatible" content="IE=edge" data-dynamic-entity="1">'."\n";

            if(isset($_GET['dynamicRouting'])) {
                $html['meta'] .= '<meta name="fragment" content="!">';
            }

            /* Baseline CSS */
            $html['css'] .= '<link rel="stylesheet" data-dynamic-entity="1" type="text/css" href="https://static.secure.website/library/users/common.css">'."\n";

            // Try to insert jquery via a cdn
            $html['js'] .= '<script type="text/javascript" data-dynamic-entity="1" data-editor-friendly="1" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>'."\n";

            // If the CDN fails, then this script will inject jquery from a static.secure.website source
            $html['js'] .= '<script type="text/javascript" data-dynamic-entity="1" data-editor-friendly="1">' .
                                'if (typeof jQuery === "undefined") {' .
                                    'document.write(unescape(\'%3Cscript src="https://static.secure.website/library/jquery/jquery-1.11.1.min.js" data-dynamic-entity="1" type="text/javascript"%3E%3C/script%3E\'));' .
                                '}'.
                            '</script>'."\n";

            // Make jquery play nice with other frameworks
            $html['js'] .= '<script type="text/javascript" data-dynamic-entity="1" data-editor-friendly="1">' .
                                'var $j = jQuery.noConflict();'.
                            '</script>';

            $html['js'] .= '<script type="text/javascript" data-dynamic-entity="1" data-editor-friendly="1" src="https://static.secure.website/library/users/common.js"></script>'."\n";

            if (isSet($_SERVER['PREVIEW_VERSION'])){
                $html['js'] .= '<script type="text/javascript" data-dynamic-entity="1" src="https://static.secure.website/library/users/site-versions-listener.js"></script>'."\n";
            }

            $json = $this->load_json();

            $PageHead = new DynamicPageHead($this->html_file,$this->storage);
            $json_to_load = $PageHead->get_json_with_page($json, $fromEditor);
            $json_to_load = DynamicHead::sort_entities($json_to_load);

            // dataonly nodes are turned into a JS Object, and put in a script tag prior to any other javascript
            $dataonly = array();
            $dataonly_json = '{}';

            if( ! empty($json_to_load)) {

                // Get the viewports to render
                $viewports_to_render = $this->get_viewports_to_render($json_to_load);

                foreach($json_to_load as $entity) {

                    // Check to see if this entity should be rendered, based on site config (viewports to render)
                    if( ! $this->passes_viewport_render_check($viewports_to_render, $entity))
                        continue;

                    $node = isset($entity['node']) ? $entity['node'] : FALSE;

                    // Special data only node
                    if($node === 'dataonly')
                    {
                        $key = $entity['id'];
                        $dataonly[$key] = $this->get_value_from_data_entity($entity);
                    }
                    else
                    {
                        $ent = $this->get_html_from_entity($entity) . "\n";

                        $bodyNode = isset($entity['closingBody']) ? $entity['closingBody'] : FALSE;

                        if($bodyNode)
                        {
                            $end_body_html .= $ent;
                        }
                        else
                        {
                            switch($node) {
                                case 'title':
                                    $html['title'] .= $ent;
                                    break;
                                case 'meta':
                                    $html['meta'] .= $ent;
                                    break;
                                case 'link':
                                case 'style':
                                    $html['css'] .= $ent;
                                    break;
                                case 'script':
                                    $html['js'] .= $ent;
                                    break;
                                default:
                                    $html['other'] .= $ent;
                                    break;
                            }
                        }
                    }
                }

                if( ! empty($dataonly))
                {
                    $dataonly_json = json_encode( $dataonly, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
                }
            }

            $props = $this->get_dynamic_props();
            $props_json = empty($props) ? '{}' : json_encode($props);

            $html['js'] = '<script type="text/javascript" data-dynamic-entity="4" data-editor-friendly="1">var _wsConfig = '.$dataonly_json.';var _wsProps = '.$props_json.';</script>'."\n".$html['js'];

            $results =  "\n<!-- Meta -->\n" . $html['meta'] . $html['title'] .
                        "\n<!-- CSS -->\n" . $html['css'] .
                        "\n<!-- JS -->\n" . $html['js'];

            if($html['other'] !== '')
            {
                $results .= "\n<!-- Extras -->\n" . $html['other'];
            }

            $results .= "\n<!-- HC -->\n";

            $this->head_html = $results;
            $this->start_body_html = $start_body_html;
            $this->end_body_html = $end_body_html;

            return $results;
        }

        function get_dynamic_props()
        {
            $props = array();
            $prefix = 'ws_prop_';

            foreach($_GET as $key => $val)
            {
                if(substr($key, 0, strlen($prefix)) === $prefix)
                {
                    if(ctype_digit($val)) {
                        $val = intval($val);
                    }

                    $props[str_replace($prefix, '', $key)] = $val;
                }
            }

            return $props;
        }

        function passes_viewport_render_check($viewports_to_render, $entity)
        {
            if(isset($entity['data-viewport']) && ! in_array($entity['data-viewport'], $viewports_to_render))
                return false;

            return true;
        }
        function get_viewports_to_render($json)
        {
            if(isset($_COOKIE['forceDesktopView']) && $_COOKIE['forceDesktopView'] == 1) return array('desktop');

            $results = array('desktop');

            // Get the viewports to render
            $render_entity = $this->getEntityById($json, $this->render_viewports_id);

            if( ! empty($render_entity))
            {
                $converted_entity = $this->getEntityById($json, $this->converted_viewports_id);

                if( ! empty($converted_entity))
                {
                    $render_viewports = $this->get_value_from_data_entity($render_entity, array('response' => 'array', 'default' => 'desktop'));
                    $converted_viewports = $this->get_value_from_data_entity($converted_entity, array('response' => 'array', 'default' => 'desktop'));
                    $results = array_intersect($render_viewports, $converted_viewports);
                }
            }

            return $results;
        }
        /**
        * example: array('node'=>'dataonly', id => 'renderViewports', 'value' => 'desktop|phone', 'delimiter' => '|');
        **/
        function get_value_from_data_entity($obj, $args = array())
        {
            $default = isset($args['default']) ? $args['default'] : '';
            $value = isset($obj['value']) ? $obj['value'] : $default;

            if(isset($obj['delimiter']))
            {
                $value = explode($obj['delimiter'], $value);
            }
            else if(isset($args['response']) && $args['response'] === 'array')
            {
                $value = array($value);
            }

            return $value;
        }
        /**
        * example: array('node'=>'link', 'type'=>'text/css', 'rel'=>'stylesheet', 'href'=>'https://fonts.googleapis.com/css?family=Aclonica|Kaushan+Script');
        **/
        function get_html_from_entity($obj)
        {
            $html = '<'.$obj['node'].' ';
            $innerHTML = '';
            $noClosingNode = array("meta","img","link","br","area","input","base","embed","hr");

            // 1 = Preloaded Entities (these show up for all users on all sites)
            // 2 = Site Entity        (these are entities that appear on all pages of a users site)
            // 3 = Page entity        (these are entities that appear on 1 page of a users site)
            // 4 = Mix of Site/Page Data
            // 5 = Unknown Entity     (entity wasn't specified, you shouldn't see this one)
            $obj['data-dynamic-entity'] = isset($obj['data-dynamic-entity']) ? $obj['data-dynamic-entity'] : '5';

            foreach($obj as $key => $val) {

                if($key=='node' || $key=='closingBody') {
                    continue;
                } else if($key=='style') {

                    if(is_array($val)){
                        $html .= $key . '="';
                        foreach($val as $selector => $rule){
                            $html .= $selector . ':'. $rule .';';
                        }
                        $html .= '" ';
                    } else {
                        $html .= $key . '="'. $val .'" ';
                    }

                } else if($key=='innerHTML') {
                    $innerHTML = $val;
                } else {
                    $html .= $key . '="'. $val .'" ';
                }
            }

            if( in_array($obj['node'], $noClosingNode) ) {
                $html .= '/>';
            } else {
                $html .= '>'.$innerHTML.'</'.$obj['node'].'>';
            }

            return $html;
        }

        function get_user_input_nodes($json)
        {
            $user_input_nodes = array();

            foreach($json as $entity) {
                if(isset($entity['data-user-input']) && $entity['data-user-input']) {
                    $user_input_nodes[] = $entity;
                }
            }

            return $user_input_nodes;
        }

        function get_paste_code_data($json)
        {
            $pasteHead = array(
                'nodes' => $this->get_user_input_nodes($json),
                'readable' => ''
            );

            foreach($pasteHead['nodes'] as $node)
            {
                $pasteHead['readable'] .= $this->get_html_from_entity($node) . "\n";
            }

            return $pasteHead;
        }

        function read_page($file)
        {
            return file_get_contents($file);
        }

        function write_page($file, $html_content)
        {
            return file_put_contents($file, $html_content);
        }

	}
