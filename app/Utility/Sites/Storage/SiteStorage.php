<?php

namespace App\Utility\Sites\Storage;

/*

public function represent anything that will need to be extracted into an API call
the contents of the function will more or less be the code that needs to be run and returned
on the other end of the API call that it's extracted out to be

private/protected functions will need to be moved over to the API

Create Version of webstarts app that works with php7.2
*/

use App\Models\Sites;

class SiteStorage extends CommonStorage {

    protected $site;
    protected $site_folder;
    protected $prefix = null;
    protected $error = [];

    // pass a Sites object or $site_id
    public function __construct($site) {

        parent::__construct();

        if ($site instanceof Sites) {
            $this->site = $site;
        } else {

            $this->site = Sites::where("id = $site")->first();
            // Check if site with this id exists
            if( is_null($this->site)) {
                throw new Exception("SiteStorage::__construct requires a valid site object or site id");
            }
        }
        // Validate site
        if(is_null($this->site) || ! $this->site->id) {
            throw new Exception("SiteStorage::__construct requires a valid site object or site id");
        }

        $this->prefix = "sites/" . $this->site->foldername . '/';
        $this->site_folder = $this->prefix;

    }

    /* Public functions to be extracted into endpoints
     */

    public function readPageAsArray($pagename)
    {
        if( ! $this->isValidSiteFolderPath($this->site_folder)) {
            throw new Exception("Can't modify file with an invalid site path", 1);
        }
        $absFilePath = $this->getAbsoluteFilePath($pagename);
        return file($absFilePath);
    }

    public function checkOrCreateFolder($folder,$mode=0755,$recursive=false)
    {
        if( ! $this->isValidSiteFolderPath($this->site_folder)) {
            throw new Exception("Can't modify file with an invalid site path", 1);
        }
        if( ! $this->exists($this->getAbsoluteFilePath($folder))) {
            if ( ! $this->makeFolder($folder,$mode,$recursive)) {
                return false;
            }
            return true;
        }
        return true;


    }

    /*
     * TODO create S3SiteFiles object
     */
    public function processImageS3($image,$options)
    {
        if( ! $this->isValidSiteFolderPath($this->site_folder)) {
            throw new Exception("Can't modify file with an invalid site path", 1);
        }
        $absFilePath = $this->getAbsoluteFilePath($image);
        $S3SiteFiles = new S3SiteFiles;

        try {
            $S3SiteFiles->processImage($absFilePath, $options);
        } catch(Exception $e) {
            die(json_encode(array('success' => false, 'message' => $e->getMessage())));
        }
    }

    // not crazy about this function being a public api call (only because of efficiency), because usually
    // it's followed up by another api call if( ! hasFile) { writeFile }. But for some obscure parts of
    // the code it makes sense until further refactors
    public function fileExists($file) {
        return $this->exists($file);
    }

    // not crazy about this function being a public api call (only because of efficiency), because usually
    // it's followed up by another api call if( ! hasFile) { writeFile }. But for some obscure parts of
    // the code it makes sense until further refactors
    public function isLink($file) {
        return is_link(
            $this->getAbsoluteFilePath($file)
        );
    }

    public function symlinkToAbsPath($abstarget,$link)
    {
        return $this->makeLinkToAbsPath($abstarget,$link);
    }

    public function renderSymlinkCreate()
    {
        return $this->makeDynamicRenderLink("");
    }

    public function renderSymlinkRemove()
    {
        return $this->removeDynamicRenderLink("");
    }

    public function isValid($page)
    {
        return $this->isValidSiteFolderPath($this->site_folder . $page) ? $this->site_folder . $page : false;
    }

    public function notValidThrowException()
    {
        if (!$this->isValidSiteFolderPath($this->site_folder)) {
            throw new Exception("Can't modify file with an invalid site path", 1);
        }
    }

    function isFolderEmpty($folder,$against)
    {
        if (!$this->isValidSiteFolderPath($this->site_folder)) {
            throw new Exception("Can't modify file with an invalid site path", 1);
        }
        $absFolderPath = $this->getAbsoluteFilePath($folder);
        if (is_dir($absFolderPath)){
            $files = array_diff(scandir($absFolderPath), $against); // Empty pg folder from old-photogallery
            if (count($files) > 0)
                return false;
        }

        return true;
    }

    public function deleteFolderSite($path)
    {
        if ( ! $this->isValidSiteFolderPath($this->site_folder)) {
            throw new Exception("Can't modify file with an invalid site path", 1);
        }
        return $this->deleteFolder('');
    }

    /* Helper functions, to be moved internally to API
     */

    private function createNestedFolders($folders)
    {
        if( ! is_array($folders)) {
            $folders = explode('/', $folders);
        }

        if(empty($folders)) {
            return;
        }

        $path = $this->getAbsoluteFolderPath('');
        foreach($folders as $folder) {
            $path .= $folder;

            if( ! is_dir($path)) {
                mkdir($path, 0755);
            }

            $path .= '/';
        }
    }

    private function createNestedFoldersForFile($filename)
    {
        $parts = explode('/', $filename);

        // It's just the file, no preceeding paths
        if(count($parts) === 1) {
            return;
        }

        $foldersWithoutFile = array_slice($parts, 0, -1);

        return $this->createNestedFolders($foldersWithoutFile);
    }

    public function makeFolder($folder,$mode=0751,$recursive=false)
    {
        return $this->makeDirectory($this->getAbsoluteFolderPath($folder),$mode,$recursive);
    }

    public function deleteSiteFile($file,$symlink=false)
    {
        return $this->delete($this->getAbsoluteFolderPath($file),$symlink);
    }

    protected function getAbsoluteFilePath($file = '')
    {
        return $this->site_folder . $file;
    }

    protected function getAbsoluteFolderPath($folder = '')
    {
        return $this->site_folder . $folder;
    }

    public function createPasswordFile($AuthFileName,$username,$password,$options)
    {
        return $this->createHTPasswd($AuthFileName,$username,$password,$options);
    }
    /*
     * @param array $srcfolderInfo['is_sitebased'=>bool,'path'=>'relative_folder_path']
     * @param array $destfolderInfo['is_sitebased'=>bool,'path'=>'relative_folder_path']
     *
     * @return bool
     */
    public function copyFolderSite($srcfolderInfo,$destfolderInfo) {

        if($srcfolderInfo['is_sitebased']) {
            $srcfolderPath = $this->getAbsoluteFilePath($srcfolderInfo['path']);
        } else {
            $srcfolderPath = $srcfolderInfo['path'];
        }
        if($destfolderInfo['is_sitebased']) {
            $destfolderPath = $this->getAbsoluteFilePath($destfolderInfo['path']);
        } else {
            $destfolderPath = $destfolderInfo['path'];
        }

        return $this->copyFolder($srcfolderPath,$destfolderPath);

    }

    /*
     * @param array $srcfileInfo['is_sitebased'=>bool,'path'=>'relative_file_path']
     * @param array $destfileInfo['is_sitebased'=>bool,'path'=>'relative_file_path']
     *
     * @return bool
     */
    public function copyFileSite($srcfileInfo,$destfileInfo) {

        if($srcfileInfo['is_sitebased']) {
            $srcfilePath = $this->getAbsoluteFilePath($srcfileInfo['path']);
        } else {
            $srcfilePath = $srcfileInfo['path'];
        }
        if($destfileInfo['is_sitebased']) {
            $destfilePath = $this->getAbsoluteFilePath($destfileInfo['path']);
        } else {
            $destfilePath = $destfileInfo['path'];
        }

        return $this->copy($srcfilePath,$destfilePath);

    }

    /*
     * @param array $srcfileInfo['is_sitebased'=>bool,'path'=>'relative_file_path']
     * @param array $destfileInfo['is_sitebased'=>bool,'path'=>'relative_file_path']
     *
     * @return bool
     */
    public function renameSiteFile($srcPagename,$destPagename) {

        if($destPagename['is_sitebased']) {
            $oldpagename = $this->getAbsoluteFilePath($srcPagename['path']);
        } else {
            $oldpagename = $srcPagename['path'];
        }
        if($destPagename['is_sitebased']) {
            $newpagename = $this->getAbsoluteFilePath($destPagename['path']);
        } else {
            $newpagename = $destPagename['path'];
        }

        return $this->rename($oldpagename,$newpagename);

    }

    public function changePermissionsSite($path, $permission = 0444)
    {
        $absFilePath = $this->getAbsoluteFilePath($path);
        return $this->changePermissions($absFilePath, $permission);
    }

    public function getFileListSite($path,$types=array(),$extensions=array()) {

        $absFilePath = $this->getAbsoluteFilePath($path);
        return $this->getFileList($absFilePath,$types,$extensions);

    }

    // The only reason this isn't in the constructor of this object, is because it has an implementation detail
    // that the webstarts app shouldn't be concerned with when we extract this object out into an API
    // in the API this should likely be a check before every request to a site folder (perhaps Laravel Middleware)
    private function isValidSiteFolderPath($path)
    {
        return preg_match('%sites/\d{4}/.*@.*\..*/%i', $path);
    }

    public function getDirectorySize($folder,$options,$excludes=array()) {

        $absfolderPath = $this->getAbsoluteFilePath($folder);
        return $this->directorySize($absfolderPath,$options,$excludes);
    }

    public function tarSite($tarfile,$options,$included_paths,$pathToIncludes)   {
        $pathToIncludes = $this->getAbsoluteFilePath($pathToIncludes);
        return $this->tar($tarfile,$options,$included_paths,$pathToIncludes);
    }

    public function tarSiteExtract($tarfile,$options,$flag,$pathToExtract)   {
        $pathToExtract = $this->getAbsoluteFilePath($pathToExtract);
        return $this->tar($tarfile,$options,$flag,$pathToExtract);
    }

    public function getSiteDirectory() {
        return $this->site_folder;
    }

    public function getParentDirectory() {
        return $parent = dirname($this->site_folder).'/';
    }

    public function getParentFolderName() {
        return basename($this->site_folder,'/');
    }


}
