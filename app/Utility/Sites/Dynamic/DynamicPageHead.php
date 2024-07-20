<?php

    namespace App\Utility\Sites\Dynamic;

	class DynamicPageHead extends DynamicHead
	{
		var $includefolder = 'include/pageheads';
		var $head_file = false;
		var $json = false;

		function __construct($pagename,$storage)
		{
			$this->head_file = $pagename.'.json';
			$this->head_file = $this->includefolder. '/' .$this->head_file;
			$this->storage = $storage;
		}

        function get_json_with_page($site_json, $fromEditor=false)
        {
            $page_json = $this->load_json();

            $page_json = $this->addEntities($page_json);

            $json_to_load = array();

            if( ! empty($page_json))
            {
                foreach($page_json as $key => $val)
                {
                    $page_json[$key]['data-dynamic-entity'] = '3';
                }
            }

            if( ! empty($site_json))
            {
                foreach($site_json as $key => $val)
                {
                    $site_json[$key]['data-dynamic-entity'] = '2';
                }
            }

            // Assemble the json to load
            if(empty($page_json) && ! empty($site_json))
            {
                $json_to_load = $site_json;
            }
            else if( ! empty($page_json) && empty($site_json))
            {
                $json_to_load = $page_json;
            }
            else
            {
                $ids = array();
                $keys = array();

                foreach($page_json as $key => $e)
                {
                    $ids[] = $e['id'];
                    $keys[$e['id']] = $key;
                }

                foreach($site_json as $e)
                {
                    if( ! in_array($e['id'], $ids))
                    {
                        $json_to_load[] = $e;
                    }
                    else
                    {
                        $key = $keys[$e['id']];
                        $page_json[$key]['data-site-entity'] = str_replace('"', "'", json_encode($e));
                    }
                }

                $json_to_load = array_merge($json_to_load, $page_json);
            }

            return $json_to_load;
        }

        function addEntities($page_json)
        {
            $hasTitle = false;
            $props = $this->get_dynamic_props();

            foreach($page_json as $entity)
            {
                if(isSet($entity['node']) && $entity['node'] === 'title')
                {
                    $hasTitle = true;
                    break;
                }
            }

            if( ! $hasTitle && isSet($props['post_id']))
            {
                $post_id = $props['post_id'];
                $title = str_replace('-', ' ', $post_id);
                $page_url = 'http' . ($_SERVER['SERVER_PORT'] == '443' ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . '/blog/post/' . $post_id;

                $page_json[] = array('node' => 'title', 'id' => 'page-title', 'innerHTML' => $title);
                $page_json[] = array('node' => 'meta', 'id' => 'og-title', 'property' => 'og:title', 'content' => $title);
                $page_json[] = array('node' => 'meta', 'id' => 'og-url', 'property' => 'og:url', 'content' => $page_url);
                $page_json[] = array('node' => 'meta', 'id' => 'og-type', 'property' => 'og:type', 'content' => 'website');
            }

            return $page_json;
        }


	}
