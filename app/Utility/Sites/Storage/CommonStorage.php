<?php

namespace App\Utility\Sites\Storage;

class CommonStorage {

    protected $api;
    protected $prefix = null;
    protected $error = [];

    // pass a Sites object or $site_id
    public function __construct() {
        $this->api = new CommonStorageAPI();
    }

    /* Public functions to be extracted into endpoints
     */
    public function readPage($path)
    {
        $path = $this->prefixPath($path);

        $response = $this->api->get('page', array(
            'path' => $path
        ));
        if(!property_exists($response,"contents")) {
            $backtrace = debug_backtrace(1,5);
            $st_tr = "<pre>".print_r(array($response,$path,$backtrace),true)."</pre>";
            /*
             * Leverage Laravel error_log
             */
            //error_log($st_tr, 3, "/tmp/storage-api.log");
            return null;
        }
        return $response->contents;
    }

    public function readFile($path)
    {
        $path = $this->prefixPath($path);

        $response = $this->api->get('file', array(
            'path' => $path
        ));

        return $response->contents;
    }

    public function writePage($path, $contents)
    {
        $path = $this->prefixPath($path);
        $response = $this->api->post('page', array(
            'path' => $path,
            'contents' => $contents
        ));

        return $response->code == 200 ? true: false;
    }

    public function writeFile($path, $contents)
    {
        $path = $this->prefixPath($path);
        $response = $this->api->post('file', array(
            'path' => $path,
            'contents' => $contents
        ));

        return $response->code == 200 ? true: false;
    }
    /*
     *  $path must be a valid existing file or symlink
     */
    public function delete($path, $symlink = false)
    {
        $path = urlencode($this->prefixPath($path));
        $route = $symlink ? "symlink?path=$path" : "file?path=$path";

        $response = $this->api->delete($route, array());

        return $response->code == 200 ? true: false;
    }

    public function exists($file) {

        $path = $this->prefixPath($file);

        $response = $this->api->post('pathexists', array(
            'path' => $path
        ));

        return $response->code == 200 ? true: false;
    }

    public function makeLinkToAbsPath($abstarget,$link) {

        $link = $this->prefixPath($link);

        $response = $this->api->post('makesymlink_to_abspath', array(
            'target' => $abstarget,
            'link' => $link
        ));
        return $response->code == 200 ? true: false;
    }

    public function createHTPasswd($file,$username,$password,$options) {

        $file = $this->prefixPath($file);

        $response = $this->api->post('create_htpasswd', array(
            'file' => $file,
            'username' => $username,
            'password'=>$password,
            'options'=>$options
        ));
        return $response->code == 200 ? true: false;
    }

    public function makeDynamicRenderLink($sitepath) {

        $sitepath = $this->prefixPath($sitepath);
        $response = $this->api->post('make_render_symlink', array(
            'sitepath' => $sitepath
        ));

        return $response->code == 200 ? true: false;
    }

    public function removeDynamicRenderLink($sitepath) {

        $sitepath = $this->prefixPath($sitepath);
        $response = $this->api->post('remove_render_symlink', array(
            'target' => $sitepath
        ));

        return $response->code == 200 ? true: false;
    }

    public function deleteFolder($path)
    {
		$endpoint = 'delfolder';
		$params = array('path' => $this->prefixPath($path));

		$response = $this->api->post($endpoint, $params);

        if($response->code != 200) {

			$error = array_merge((array) $response, [
				'params' => $params,
				'footprint' => debug_backtrace(1,5)
			]);

			array_push($this->error, $error);
            /*
             * Leverage Laravel error_log
             */
			//error_log(json_encode($error), 3, "/tmp/storage-api.log");

			return false;
		}

        return true;
    }

    public function changePermissions($path,$permission=0444)
    {

        $path = $this->prefixPath($path);
        $response = $this->api->post('permission', array(
            'file' => $path,
            'permission' => $permission
        ));

        return $response->code == 200 ? true: false;
    }

    public function rename($oldpagename,$newpagename)
    {
        $response = $this->api->post('renamepage', array(
            'oldname' => $oldpagename,
            'newname' => $newpagename
        ));

        return $response->code == 200 ? true: false;
    }

    public function renameAndDeleteTmpFile($tmpFile,$target)
    {
        $response = $this->api->post('renametemp', array(
            'tmpfile' => $tmpFile,
            'target' => $target
        ));

        return $response->code == 200 ? true: false;
    }

    public function downloadFile($url,$tmpFile)
    {

        $response = $this->api->post('download', array(
            'url' => $url,
            'tmpfile' => $tmpFile
        ));

        return $response->code == 200 ? true: false;
    }

    public function getMimeType($file)
    {

        $file = $this->prefixPath($file);
        $response = $this->api->post('mimetype', array(
            'path' => $file,
        ));

        return $response->code == 200 ? $response->contents: null;
    }

    public function getFileMType($file)
    {
        $file = $this->prefixPath($file);
        $response = $this->api->post('modtime', array(
            'path' => $file,
        ));

        return $response->code == 200 ? $response->contents: null;
    }

    public function move($source,$destination)
    {

        $response = $this->api->post('movefile', array(
            'src' => $source,
            'des' => $destination
        ));

        return $response->code == 200 ? true: false;

    }

    public function copy($source,$destination)
    {

        $response = $this->api->post('copyfile', array(
            'src' => $source,
            'des' => $destination
        ));

        return $response->code == 200 ? true: false;

    }

    public function getFileSize($filename)
    {
        $filename = $this->prefixPath($filename);

        $response = $this->api->post('filesize', array(
            'path' => $filename,
        ));

        return $response->code == 200 ? $response->contents: null;
    }

    public function getImageSize($image)
    {
        $image = $this->prefixPath($image);

        $response = $this->api->post('imagesize', array(
            'path' => $image,
        ));

        return $response->code == 200 ? (array) $response->contents: array();
    }

    public function directorySize($folder,$options,$excludes=array()) {

        $params = array();
        $params['path'] = $folder;
        $params['options'] = $options;
        if(is_array($excludes) && count($excludes)>0) {
            $params['excludes'] = $excludes;
        }
        $response = $this->api->post('dirsize', $params);

        return isset($response->contents) ? $response->contents :0;
    }

    public function copyFolder($srcfoldr,$dest) {

        $response = $this->api->post('copyfolder', array(
            'src' => $srcfoldr,
            'des' => $dest
        ));

        return $response->code == 200 ? true: false;

    }

    public function makeDirectory($path,$permission,$recursive=0) {


        $response = $this->api->post('makefolder', array(
            'path' => $path,
            'permission' => $permission,
            'recursive' => $recursive
        ));

        return $response->code == 200 ? true: false;

    }

    public function tar($tarfile,$options,$included_paths,$pathToIncludes)   {

        $params = array();
        $params['tarfile'] = $tarfile;
        $params['options'] = $options;
        if(is_array($included_paths) && count($included_paths)>0) {
            $params['includes'] = $included_paths;
        }
        $params['path_to_includes'] = $pathToIncludes;

        $response = $this->api->post('tarcompress', $params);

        return $response->code == 200 ? true: false;
    }

    public function tarExtract($tarfile,$options,$flag,$pathToExtract)   {

        $params = array();
        $params['tarfile'] = $tarfile;
        $params['options'] = $options;
        $params['flag'] = $flag;
        $params['path_to_extract'] = $pathToExtract;

        $response = $this->api->post('tarextract', $params);

        return $response->code == 200 ? true: false;
    }

    public function touchFile($filename) {

        $response = $this->api->post('touchfile', array(
            'path' => $filename,
        ));

        return $response->code == 200 ? true: false;
    }

    public function getFileList($path,$types=array(),$extensions=array()) {

        $params = array();
        $params['path'] = $path;
        if(is_array($types) && count($types)>0) {
            $params['included_types'] = $types;
        }
        if(is_array($extensions) && count($extensions)>0) {
            $params['extensions'] = $extensions;
        }
        $response = $this->api->post('contents', $params);

        return isset($response->contents) ? $response->contents :array();

    }

    public function getFileInfo($path) {

        $path = $this->prefixPath($path);
        $response = $this->api->post('fileinfo', array(
            'path' => $path,
        ));

        return isset($response->contents) ? (array) $response->contents :false;

    }

    public function createSubdomain($subdomain,$webroot)
    {

        $response = $this->api->post('vhost/subdomain', array(
            'subdomain' => $subdomain,
            'webroot' => $webroot
        ));
        if($response->code != 200) {
            $backtrace = debug_backtrace(1,5);
            $st_tr = json_encode(array($response,$subdomain,$webroot,$backtrace));
            /*
             * Leverage Laravel error_log
             */
            //error_log($st_tr, 3, "/tmp/storage-api-sl.log");
        }
        return $response->code == 200 ? true: false;
    }

    public function deleteSubdomain($subdomain)
    {

        $response = $this->api->post('vhost/delete_subdomain', array(
            'subdomain' => $subdomain
        ));

        return $response->code == 200 ? true: false;
    }

    public function createDomain($domain,$webroot)
    {

        $response = $this->api->post('vhost/domain', array(
            'domain' => $domain,
            'webroot' => $webroot
        ));
        if($response->code != 200) {
            $backtrace = debug_backtrace(1,5);
            $st_tr = json_encode(array($response,$domain,$webroot,$backtrace));
            /*
             * Leverage Laravel error_log
             */
            //error_log($st_tr, 3, "/tmp/storage-api-sl.log");
        }
        return $response->code == 200 ? true: false;
    }

    public function deleteDomain($domain)
    {

        $response = $this->api->post('vhost/delete_domain', array(
            'domain' => $domain
        ));

        return $response->code == 200 ? true: false;
    }

    public function removeDomainLink($domain)
    {

        $response = $this->api->post('vhost/remove_domain_link', array(
            'domain' => $domain
        ));

        return $response->code == 200 ? true: false;
    }

    protected function prefixPath($path)
    {
        return $this->prefix . $path;
    }

	public function getError()
	{
		return count($this->error) == 1 ? $this->error[0] : $this->error;
	}



}
