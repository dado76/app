<?php
/**
 * The FileManager is the central filesystem controller for the CMS. It enables administrators to safely and securely upload any file they choose and makes such files easily available throughout the CMS, allowing content
 * editors and administrators quickly add content in the pre-defined "templates" that the CMS provides and A+L codes. As one of the underlying principles of the CMS includes the ability for it to be installed on any environment
 * (running PHP), FileManager is able to upload files to either the server's local filesystem or on a remote content delivery network such as Amazon S3. This gives administrators the power to upload any file they choose,
 * regardless of file size, and because it is integrated with the CMS these files are handled just like everything else in the local filesystem. To the end user, files on S3 and files on the local "ufiles/" folder behave
 * exactly the same.
 *
 * @see AmazonS3 - part of the AWS PHP SDK and the driver behind all S3 communications (except file upload, which is handled using a straight HTTP POST from a <form>)
 */
class FileManager {
    /* properties */
    public $image = array('targetx'=>0,
        'targety'=>0,
        'quality'=>100);
    public $s3, $relPath;

    /**
     * If the proper configuration options are set, this constructor instantiates the FileManager object in the variable of your choice and simultaneously connects to the CDN of your choice. At this time, we are limiting
     * such connections to Amazon S3, however, at some point we will be supporting other CDN services run by Rackspace, Google, and Microsoft.
     *
     * @constructor
     */
    public function FileManager() {
        global $CDN_ACCESS_KEY, $CDN_BUCKET, $CDN_SECRET_KEY, $DOCUMENT_ROOT;
        require_once($DOCUMENT_ROOT.'cms/lib/aws/sdk.class.php');	// load the amazon web services SDK

        // connect to S3 and validate
        if ($CDN_ACCESS_KEY && $CDN_SECRET_KEY && $CDN_BUCKET) {
            //$this->s3 = new Zend_Service_Amazon_S3($CDN_ACCESS_KEY, $CDN_SECRET_KEY);
            $this->s3 = new AmazonS3($CDN_ACCESS_KEY, $CDN_SECRET_KEY);
        } else {
            $s3 = false; // fail gracefully
        }
    }

    /**
     * Creates a new folder in the local filesystem under $UPLOAD_DIR_REL.
     *
     * @param {string} $prefix - the relative path of this folder
     */
    public function newLocalFolder($pro) {
        global $UPLOAD_DIR_REL, $LOCAL_PATH, $console;
        $upDir  = $LOCAL_PATH.$UPLOAD_DIR_REL.$pro['relPath'];
        $folder = Str::sql2url($pro['folderName']);
        $path = $this->cleanSlashes($upDir.$folder);
        if (is_writable($upDir) && is_dir($upDir)) {
            if (!file_exists($path)) {
                $message .= (mkdir($path)) ? "The folder \"${folder}\" has been added." : "Error writing to filesystem.";
            } else {
                $message .= "Error writing to filesystem. Does this file or folder already exist?";
            }
        } else {
            $console->log("Error writing to filesystem: Bad permissions");
        }
    }

    /**
     * Creates a new folder in the S3 filesystem under the base CDN folder (default: "ufiles/").
     *
     * @param {array} $pro - a properties array that includes the the name of the new folder as well as its relative path (if applicable)
     */
    public function newRemoteFolder($pro) {
        global $CDN_FOLDER, $CDN_BUCKET;
        $folder = (isset($pro['relPath'])) ? $CDN_FOLDER.$pro['relPath'].'/'.$pro['folderName'] : $CDN_FOLDER.'/'.$pro['folderName'];
        $message .= ($this->s3->create_object($CDN_BUCKET, $folder.'/')) ? "The folder \"${folder}\" has been defined on S3." : "Error creating \"${folder}\" on S3...";
    }

    /**
     * Returns a listing of all files in a specific folder
     *
     * @param array $pro a properties array for on-the-fly configuration of scope and listing type ('local' or 'remote')
     */
    public function folderFileListing($pro) {
        global $MY_RANDOM_ID;
        $relPath = $pro['relPath'];
        $curPath = $pro['curPath'];
        $listingType = $pro['listingType'];
        $targetDiv = $pro['targetDiv'];

        if ($listingType == 'local') {
            // Get list of local folders
            $daFolderArray 	= $this->foldersLocalGet($pro);
            // Get list of local files
            $daFileArray 	= $this->filesLocalGet($pro);
        } else {
            // Get list of all remote objects
            $daObjectArray 	= $this->objectsRemoteGet($pro);
            // Break it up into folders and files
            $daFolderArray 	= $this->foldersRemoteGet($pro, $daObjectArray);
            $daFileArray   	= $this->filesRemoteGet($pro, $daObjectArray);
        }

        //

        // Calculate offset for indenting
        $nestCount = substr_count($relPath,'/');
        $offset = ($nestCount == 1) ? '14px' : 14 + (19 * ($nestCount - 1)) .'px';
        $offset = ($nestCount == 0) ? '8px' : $offset;


        $str = ''
            . '			<tr><td id="addnew_'.$MY_RANDOM_ID.'" class="file addnew" relPath="' . $relPath . '" listingType="' . $listingType . '" calledFrom="'.$calledFrom.'" style="padding-left:'. $offset .'">' . "\n"
            . '				+ Add New' . "\n"
            . '			</td>' . "\n"
            . '			</tr>' . "\n";
        for ($i=0; $i<count($daFolderArray); $i++) {
            $daCount = $daFolderArray[$i]['FileCount'];

            $str .= '			<tr>'."\n"
                .'				<td id="' . $daFolderArray[$i]['ID'] . '" class="file folder" files="' . $daFolderArray[$i]['File Count'] . '" relPath="' . $daFolderArray[$i]['relPath'] . '" listingType="' . $listingType . '" style="padding-left:'. $offset .'">' . "\n";

            // Display branch
            if ($nestCount > 0) {
                $str .= '				<div class="marker branch"></div>' . "\n";
            }
            $str .= '					<div class="marker folder"></div>' . "\n";
            $str .= '					<span class="name">' . $daFolderArray[$i]['Name'] . "</span>\n";
            // Display delete button if file count is 0
            if ($daCount == 0) {
                $str .= '				<div class="marker delete" title="Delete" myFile="' . Str::sql2pure($daFolderArray[$i]['Name'],30) . '"></div>' . "\n";
            }
            $str .= '				</td>' . "\n";
            $str .= '			</tr>' . "\n";

        }

        //
        // Display List of files
        for ($i=0; $i<count($daFileArray); $i++) {
            $dafileType = $this->convertExtToFileType($daFileArray[$i]['fileType']);
            $str .= '			<tr><td class="file" myID="' . $daFileArray[$i]['ID'] . '" relPath="' . $daFileArray[$i]['relPath'] . '" listingType="' . $listingType . '" style="padding-left:'. $offset .'">' . "\n";
            // Display branch
            if ($nestCount > 0) {
                $str .= '				<div class="marker branch"></div>' . "\n";
            }
            $str .= '					<div class="marker ' . $dafileType . '"></div>' . "\n";
            $str .= '					<span class="name">' . $daFileArray[$i]['CurrentFileName'] . "</span>\n";
            $str .= '					<div class="marker delete" title="Delete" calledFrom="'.$calledFrom.'" myFile="' . Str::sql2pure($daFileArray[$i]['CurrentFileName'],30) . '"></div>' . "\n";
            $str .= '				</td>' . "\n";
            $str .= '			</tr>' . "\n";
        }

        return $str;
    }

    /**
     * Returns a list of folders for the current $relPath scope.
     *
     * @param {array} $pro
     * @return {array} an array of folder references
     */
    public function foldersLocalGet($pro) {
        $relPath = $pro['relPath'];
        $curPath = $pro['curPath'];

        $daArray = array();

        // Open a known directory, and proceed to read its contents
        if (is_dir($curPath)) {
            if ($dh = opendir($curPath)) {
                $num = 0;
                while (($file = readdir($dh)) !== false) {
                    $firstChar = substr($file, 0, 1);
                    if (($firstChar != ".") && ($firstChar != "_") && ($file != ".svn")) {
                        if (is_dir($curPath . $file)) {
                            $dir = $curPath . $file;

                            // Count total number of files in directory
                            $num_files = 0;
                            if ($dir = @opendir($dir)) {
                                while (($fileI = readdir($dir)) !== false) {
                                    if($fileI != "." and $fileI != "..") {
                                        $num_files++;
                                    }
                                }
                                closedir($dir);
                            }
                            array_push($daArray, array('ID' => "folder_" . $num, 'Name' => "${file}", 'FileCount' => $num_files, 'curPath' => $curPath, 'relPath' => Str::gpc2urlEscape($relPath . "/" . $file)));
                            $num++;
                        }
                    }
                }
                closedir($dh);
            }
        }
        //
        // Sort Folder Listing by Name
        $daArray = $this->array_sort($daArray, 'Name', SORT_ASC);
        //
        return $daArray;
    }

    /**
     * Queries the database and returns references to local files, which should be synchronized with the actual ufiles/ directory.
     *
     * @param {array} $pro - the properties array. allows the function to take optional parameters in any order and fill them with defaults, or produce custom error messages.
     * @return {array} files in the specified scope
     */
    public function filesLocalGet($pro) {
        global $database, $FOLDER_DEL, $UPLOAD_DIR_REL;
        //
        $relPath = $pro['relPath'];
        $curPath = $pro['curPath'];
        $relPathWithUfile = $pro['relPathWithUfile'];
        $orphanFiles = array();

        if (is_dir($curPath)) {
            // find all the files that have already been added
            $sql = "SELECT * FROM `AL_ManageFiles` WHERE `Path` = '${UPLOAD_DIR_REL}'";
            $dbFiles = $database -> query_array($sql);

            // scan ufiles dir for any files that aren't in DB
            if ($ufiles = openDir($curPath)) {
                while (($candidate = readdir($ufiles)) !== false) {
                    $firstChar = substr($candidate, 0, 1);

                    // don't add .files or folders/
                    if (($firstChar != ".") && !is_dir($curPath.$candidate)) {
                        $orphan = true;
                        foreach ($dbFiles as $file) {
                            // lowercase and uppercase files are different to *NIX, but not Windows (for IIS), this ensures that the condition will run properly
                            if (strtolower($file['CurrentFileName']) == strtolower($candidate)) {
                                $orphan = false;
                            }
                        }
                        // when an orphan is found, add it to the DB
                        if ($orphan) {
                            $newFile = $this->fileAddToDB(array('CurrentFileName' => $candidate,
                                'relPath' => Str::urlEscape2gpc($relPath),
                                'relPathWithUfile' => $relPathWithUfile,
                                'curPath' => $curPath));
                            array_push($dbFiles, $newFile);
                        }
                    }
                }
            }
        } else {
            $message .= "Error: Could not read directory ${UPLOAD_DIR_REL}...";
        }
        // Sort Folder Listing by Name
        $localFiles = $this->array_sort($dbFiles, 'CurrentFileName', SORT_ASC);
        return $localFiles;
    }
    /**
     * Accesses the chosen S3 bucket & folder and returns all objects inside it.
     *
     * @param {array} 		   $pro - the properties array. allows the function to take optional parameters in any order and fill them with defaults, or produce custom error messages.
     * @param {array} $daObjectsArr - an array of Amazon S3 objects pulled from this client's bucket
     * @return {array} folders in the specified scope
     */
    public function foldersRemoteGet($pro, $daObjectsArr) {
        global $database, $CDN_BUCKET, $CDN_FOLDER;

        $relPath = $pro['relPath'];
        $curPath = $pro['curPath'];
        $daArray = array();
        // build folder <tr> structure
        foreach($daObjectsArr as $name) {
            // check if this object is a folder first
            if (substr($name, -1) == "/") {

                // get a count of all objects in this folder and its subfolders
                $contents = $this->s3->get_object_list($CDN_BUCKET, array('prefix' => $name));
                $count = count($contents)-1;

                $name=str_replace('ufiles/', '', $name);
                $name=(substr($name, -1) == '/') ? substr($name, 0, strlen($name)-1) : $name;
                $nameArr=explode('/', $name);
                $folderName=$nameArr[count($nameArr)-1];

                // Build <tr>
                array_push($daArray, array(
                    'ID' => "folder_${folderName}",
                    'Name' => "${folderName}",
                    'FileCount' => $count,
                    'curPath' => $curPath,
                    'relPath' => $relPath.'/'.$folderName
                ));
            }
        }
        //
        // Sort Folder Listing by Name
        $daArray = $this->array_sort($daArray, 'Name', SORT_ASC);
        //
        return $daArray;

    }

    /**
     * Makes a general call to S3 and grabs objects in the specified folder scope. Utility function for user-end methods like filesRemoteGet() and foldersRemoteGet().
     *
     * @param {array} $pro - the properties array. allows the function to take optional parameters in any order and fill them with defaults, or produce custom error messages.
     * @return {array} references to remote objects in the specified scope
     */
    public function objectsRemoteGet($pro) {
        global $CDN_BUCKET, $CDN_FOLDER;

        $relPathWithUfile=substr($pro['relPathWithUfile'], 1);
        if ($this->s3) {
            // download everything in the level immediately under this folder if we're not in the root folder (/ufiles)
            $daObjectsArr = $this->s3->get_object_list($CDN_BUCKET, array(
                'pcre' => '#'. $relPathWithUfile .'[^/]+(?:/$|$)#'
            ));
            return $daObjectsArr;
        } else {
            die("<br /><strong>Error:</strong> S3 was never initialized!");
        }
    }
    /**
     * Returns all remote file references in the database.
     *
     * @param  {array} 	   $pro - the properties array. allows the function to take optional parameters in any order and fill them with defaults, or produce custom error messages.
     * @param  {array} $objects - an array of Amazon S3 objects pulled from this client's bucket
     * @return {array} references to files in the specified scope
     */
    public function filesRemoteGet($pro, $objects) {
        global $database, $FOLDER_DEL, $CDN_BUCKET, $CDN_FOLDER;
        //
        $relPath = $pro['relPath'];
        $curPath = $pro['curPath'];
        $relPathWithUfile = $this -> cleanSlashes($pro['relPathWithUfile'] . '/' . $relPath);

        $orphanFiles = array();

        // Build remote URL path
        $urlPath = "http://${CDN_BUCKET}.s3.amazonaws.com/${CDN_FOLDER}/";


        // Get all files using a URL path.
        $sql 	 = "SELECT * FROM `AL_ManageFiles` WHERE `Path`='${urlPath}'";
        $dbFiles = $database -> query_array($sql);	// daArray

        // add orphan files to the DB
        foreach($objects as $key) {
            // keys that end in slashes are folders, and should be overlooked
            if (substr($key, -1) != "/") {
                $keySplit  	= explode("/", $key);
                $last 		= count($keySplit)-1;
                $keyName 	= $keySplit[$last];
                $keyPath	= str_replace($keyName,		"", $key);
                $keyRelPath = str_replace($CDN_FOLDER,	"",	$keyPath);
                $keyRelPath = substr($keyRelPath, 0, strlen($keyRelPath)-1);
                $urlPath    = "http://${CDN_BUCKET}.s3.amazonaws.com/${CDN_FOLDER}/";
                // look for a match
                $orphan = true;
                foreach($dbFiles as $file) {
                    $fileName = $file['CurrentFileName'];
                    $filePath = $file['Path'];

                    if ($keyName == $fileName) {
                        $orphan = false;
                    }
                }

                // add file to database
                if ($orphan) {
                    $newFile = $this->fileRemoteAddToDB(array(
                        'fileName' => $keyName,
                        'relPath' => $keyRelPath
                    ));
                    array_push($dbFiles, $newFile);
                }
            }
        }
        // sort by file name and return all remote filess
        $remoteFiles = $this->array_sort($dbFiles, 'CurrentFileName', SORT_ASC);
        return $remoteFiles;
    }

    /**
     * Uploads a file from a user's machine to the local filesystem.
     *
     * @param {array} $pro - the properties array. allows the function to take optional parameters in any order and fill them with defaults, or produce custom error messages.
     * @return the results of the SQL query.
     */
    public function fileUpload($pro) {
        global $_FILES, $LOCAL_PATH, $UPLOAD_DIR_REL, $database, $user_id, $message;

        $mainTable = isset($pro['mainTable']) ? $pro['mainTable'] : "AL_ManageFiles";
        $relPath = isset($pro['relPath']) ? $pro['relPath'] : '';
        //
        // Clean relPath for all . and ..
        $relPath = str_replace(".", "", $relPath);

        if ($_FILES['Filedata']['name'] <> "" && $_FILES['Filedata']['error'] == false) {

            $relPathWithUfile = $UPLOAD_DIR_REL . $relPath . "/";
            $uploaddir = $LOCAL_PATH . $relPathWithUfile;
            $origFileName = $_FILES['Filedata']['name'];

            $arr = $this -> fileCleanName($uploaddir, $origFileName);
            //
            $ext = $arr[0];
            $daFileName = $arr[1];
            $daFileNameNew = $arr[2];
            //
            $uploadfile = $uploaddir . $daFileNameNew;
            //
            //
            if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadfile)) {

                // Set permissions
                chmod("$uploadfile", 0777);

                // Get image size
                $size = getimagesize($uploadfile);

                $daImgWidth = $size[0];
                $daImgHeight = $size[1];
                //
                $daFileSize = filesize($uploadfile);
                //

                //
                // put the new file into the db
                $sql = "INSERT $mainTable SET `OrigFileName` = '${origFileName}' , `CurrentFileName` = '${daFileNameNew}' , `Description` = '${daFileNameNew}' , `Path` = '${relPathWithUfile}' , `Extension` = '${ext}' , `FileSize` = '${daFileSize}' , `DateUploaded` = NOW() , `OwnerID` = '$user_id' , `ImgHeight` = '${daImgHeight}' , `ImgWidth` = '${daImgWidth}',  `SortOrder` = '1', `AthUserID` = '0'";
                $sql_res = $database -> query($sql);

                if ($sql_res == 1) {
                    $message .= "File uploaded successfully <br>\n";
                } else {
                    $message .= "File upload error: Saving to DB <br>\n";
                }
            } else {
                $message .= "File upload error: Moving file <br>\n";
            }
            //$FILE = $_POST['path'];
        } else if ($_FILES['Filedata']['error'] == UPLOAD_ERR_INI_SIZE) {
            $message .= "<span style='color:#f00;'>Error: File size exceeds server limit </span><br />\n";
        }

        // return the results
        $sql = "SELECT LAST_INSERT_ID()";
        $res = $database -> query_array($sql);
        $file = $res[0];
        return $res;
    }

    /**
     * Removes a file from the local filesystem and deletes its references from the database.
     *
     * @param {int} $id - the ID of this file's row in the database
     */
    public function deleteLocalFile($id) {
        global $database, $message;

        // get relevant file metadata
        $file = '..'.getPathFromID($id);

        // if the file was deleted successfully, remove refs to it in the database
        if (unlink($file)) {
            $sql = "DELETE FROM `AL_ManageFiles` WHERE `ID` = '${id}'";
            $rowDeleted = $database->query($sql);
            $message .= ($rowDeleted > 0) ? "File deleted." : "There was an error removing file references from the database, but the file has been removed from local filesystem.";
        } else {
            $message .= "Error removing file from local filesystem. Does it exist?";
        }
    }


    /**
     * Removes a folder from the local filesystem.
     *
     * @param {array} $pro - the properties array. allows the function to take optional parameters in any order and fill them with defaults, or produce custom error messages.
     */
    public function deleteLocalFolder($pro) {
        global $UPLOAD_DIR_REL, $message;

        $name = $pro['name'];
        $relPath = ("/".$name != $pro['relPath']) ? $pro['relPath'] : "";
        $path = $UPLOAD_DIR_REL.$relPath;

        // make sure this is actually a directory and we have permissions to write
        if (is_dir('../'.$path.$name) && is_writable('../'.$path)) {
            $message .= (rmdir('..'.$path.$name)) ? "Folder removed successfully." : "Error removing folder from filesystem.";
        } else {
            $message .= "You don't have permission to write to ${path}/";
        }
    }

    /**
     * Removes an object from the S3 filesystem. Since S3 doesn't differentiate between folders & files, this function is sufficient for both actions.
     *
     * @param {string} $name - the name of this object and the path leading to it. basically, a valid Amazon S3 key without the $CDN_FOLDER attached to it.
     */
    public function deleteRemoteObject($pro) {
        // variables
        global $CDN_FOLDER, $CDN_BUCKET, $database, $console;
        $folder  = (isset($pro['folder'])) 	? $pro['folder'] 			 : null;						// name of the folder (if applicable)
        $fileID	 = (isset($pro['file'])) 	? Str::gpc2sql($pro['file']) : null;						// id of the file (if applicable)
        $relPath = ("/".str_replace("/", "", $folder) != $pro['relPath']) ? $pro['relPath'] : null;		// remove relPath reference if it's self-referential

        // build key referencing this object
        if ($folder != null) {
            //$key = ($relPath != null) ? $CDN_FOLDER."/".$relPath."/".$pro['folder'] : $CDN_FOLDER."/".$pro['folder'];
            $key = $CDN_FOLDER.'/'.$folder;
            $console->log("deleting $key");
        } else if ($fileID != null) {
            // files are passed as ID, and require a database call
            $sql = "SELECT `CurrentFileName` FROM `AL_ManageFiles` WHERE `ID` = ${fileID}";
            $res = $database->query_array($sql);
            $file = Str::sql2pure($res[0]['CurrentFileName']);
            $key = ($relPath != null) ? $CDN_FOLDER.$relPath."/".$file : $CDN_FOLDER."/".$file;
        } else {
            // throw an error if $folder and $fileID are both null
            $message .= "Error: No pointer passed into deleteRemoteObject()...";
        }

        // make the call to S3
        $res = $this->s3->delete_object($CDN_BUCKET, $key);
        if ($res->isOK()) {
            // call DB if this is a file and refs need to be removed
            if ($fileID != null) {
                $sql = "DELETE FROM `AL_ManageFiles` WHERE `ID`=${fileID}";
                $fileRefsRemoved = $database->query($sql);
                // report to console
                if ($fileRefsRemoved) {
                    $message .= "Deleted ${key} from the CDN.";
                } else {
                    $message .= "Could not remove database references for ${key}...";
                }
            }
        } else {
            $message .= "There was a problem deleting the object \"${key}\" from the CDN...";
        }
    }

    /**
     * After a local file is uploaded, this adds a new record in the database for it.
     *
     * @param {array} $pro - the properties array. allows the function to take optional parameters in any order and fill them with defaults, or produce custom error messages.
     */
    public function fileAddToDB($pro) {
        global $actionFunctions, $database, $user_id;

        $origFileName = $daFileNameNew = $pro['CurrentFileName'];
        $curPath = $pro['curPath'];
        $relPathWithUfile = $pro['relPathWithUfile'];
        //
        // Clean File Name
        $arr = $this -> fileCleanName($uploaddir, $origFileName);
        //
        $ext = $arr[0];
        $daFileName = $arr[1];
        $daFileNameNew = $arr[2];

        $uploadfile = $curPath . $daFileNameNew;
        //
        // rename the file if needed
        if ($origFileName != $daFileNameNew) rename($curPath . $origFileName, $curPath . $daFileNameNew);
        // Get image size
        $size = getimagesize($uploadfile);
        //
        $daImgWidth = $size[0];
        $daImgHeight = $size[1];
        //
        $daFileSize = filesize($uploadfile);
        //
        //
        // check if file is writable
        if (is_writable($uploadfile) && fileperms("$uploadfile") < 0777) {
            chmod("$uploadfile", 0777);
        }
        //
        // put the new file into the db
        $sql = "INSERT `AL_ManageFiles` SET `OrigFileName` = '${origFileName}' , `CurrentFileName` = '${daFileNameNew}' , `Description` = '${daFileNameNew}' , `Path` = '${relPathWithUfile}' , `Extension` = '${ext}' , `FileSize` = '${daFileSize}' , `DateUploaded` = NOW() , `OwnerID` = '$user_id' , `ImgHeight` = '${daImgHeight}' , `ImgWidth` = '${daImgWidth}'";
        $sql_res = $database -> query($sql);

        $sql_res = $database -> query_array("SELECT LAST_INSERT_ID();");

        $daLastID = $sql_res[0][0];

        return array('ID' => $daLastID, 'Name' => "${daFileNameNew}", 'curPath' => $curPath, 'relPath' => Str::gpc2urlEscape($relPathWithUfile), 'fileType' => $ext);

    }

    /**
     * After a remote file has been uploaded to S3, this function adds its metadata into the database. Keeping all files references in the same table allows the CMS to easily and efficiently build a folder
     * structure without over-querying Amazon's API. Dumb by design, this function is not only called after a file has successfully been uploaded from the CMS to S3, but also when a file is found in S3 and not
     * found in the database, helping keep S3 and our database in sync with one another...
     *
     * @param {array} $pro - the properties array.
     *							'fileName' => the name and extension of the file on S3
     *							'relPath' => the relative folder path (excluding /ufiles) this file is located in.
     */
    public function fileRemoteAddToDB($pro) {
        global $actionFunctions, $database, $user_id, $CDN_BUCKET, $CDN_FOLDER;

        // set vars
        $fileName = $pro['fileName'];
        $relPath  = $pro['relPath'];
        $absPath  = 'http://'.$CDN_BUCKET.'.s3.amazonaws.com/'.$CDN_FOLDER.$relPath.'/';
        $urlPath  = $absPath.$fileName;

        // parse filename and find extension
        $filePath = pathinfo($fileName);
        $ext = $filePath['extension'];


        // download the whole file if it's an image (to find dimensions)
        if ($this->isImage($ext)) {
            $imgSize = getimagesize($urlPath);
        }

        // find file size (in bytes) from cURL HTTP HEAD request
        $curl = curl_init($urlPath);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); //not necessary unless the file redirects (like the PHP example we're using here)
        $data = curl_exec($curl);
        curl_close($curl);

        // grab Content-Length from HTTP HEAD and parse it into $daFileSize
        if ($data === false) {
            $console->error('curl failed');
        } else {
            $daFileSize = (preg_match('/Content-Length: (\d+)/', $data, $matches)) ? (int)$matches[1] : 0;

        }

        // find image dimensions from size array, if set
        $daImgWidth  = isset($imgSize) ? $imgSize[0] : 0;
        $daImgHeight = isset($imgSize) ? $imgSize[1] : 0;

        /*global $console;
        $console->log("Type: ".$this->convertExtToFileType($ext));
        $console->log("Dimensions: $daImgWidth x $daImgHeight");
        $console->log("Filesize: $daFileSize bytes");*/

        //
        // put the new file into the db
        $sql = "INSERT `AL_ManageFiles` SET `OrigFileName` = '${fileName}' , 
											`CurrentFileName` = '${fileName}' , 
											`Description` = '${fileName}' , 
											`Path` = '${absPath}' , 
											`Extension` = '${ext}' , 
											`FileSize` = '${daFileSize}' , 
											`DateUploaded` = NOW() , 
											`OwnerID` = '${user_id}' , 
											`ImgHeight` = '${daImgHeight}' , 
											`ImgWidth` = '${daImgWidth}'";
        $sql_res = $database -> query($sql);

        // return results
        $sql_res = $database -> query_array("SELECT LAST_INSERT_ID();");
        $daLastID = $sql_res[0][0];
        return array('ID' => $daLastID, 'Name' => "${fileName}", 'curPath' => $relPath, 'relPath' => $relPath, 'fileType' => $ext);
    }

    /**
     * Runs a number of regular expressions and validations on the given file name
     */
    public function fileCleanName($uploaddir, $origFileName) {
        $fileNameArr = explode("." , $origFileName);

        $ext = array_pop($fileNameArr);
        // clean the file name
        $str = implode(".",$fileNameArr);
        //
        $daCleanFileName = $daFileNameNew = preg_replace("/[^a-z0-9_]/", "-", strtolower($str));

        //
        // check uploaded file name to be unique
        $i = 0;
        $fileFound = true;
        //
        //
        while ($fileFound) {
            // build file name
            if ($i <> 0) $daFileNameNew =  $daCleanFileName . "-" . $i;
            // if file doesn't exist then proceed
            if (!file_exists($uploaddir . $daFileNameNew . "." . $ext)) break;
            // increment
            $i++;
        }
        // build path and to unique file
        $daFileName = $daFileNameNew . "." . $ext;
        return array($ext, $daCleanFileName, $daFileName);

    }

    /**
     * Helper function that denotes all file formats "supported" by the UI, meaning these are the extensions we have icons for. Any file that is under the max upload limit will be available on the File Manager,
     * but may not have a descriptive icon.
     */
    public function convertExtToFileType($ext) {
        switch ($ext) {

            //* Image Markers
            case "jpg" :
                return "jpg";
            case "gif" :
                return "gif";
            case "png" :
                return "png";
            case "tif" :
            case "bmp" :
            case "bmp" :
                return "img";

            //* Video Markers
            case "mp4" :
            case "mov" :
            case "mpeg" :
            case "mpg" :
            case "avi" :
                return "vid";

            //* Flash Markers
            case "flv" :
            case "swf" :
                return "flv";

            //* File Not Found
            case "fnf" :
                return "fnf";

            //* Document Markers
            case "pdf" :
                return "pdf";
            case "doc" :
            case "txt" :
            case "xls" :
                return "doc";

            //* Default Marker
            default :
                return "doc";
        }
    }

    /**
     * Tests if the given file extension is an image or not.
     *
     * @param {String} $ext - A valid file extension.
     */
    public function isImage($ext) {
        switch($ext) {
            case "jpg" :
            case "gif" :
            case "png" :
            case "tif" :
            case "bmp" :
                return true;
                break;
            default:
                return false;
                break;
        }
    }
    /**
     * A helper function that removes extra slashes. I
     */
    public function cleanSlashes($str) {
        $str = str_replace("//", "/", $str);
        return $str;
    }

    /**
     * A helper function for _FileManager and cropAndImage that cleans the relative path.
     */
    function cleanRelPath($str) {

        $str = $this->cleanSlashes($str);				// convert double-slashes into single slashes

        $lastChar = substr($str, -1);
        $firstChar = substr($str, 0, 1);

        $str = str_replace("ufiles/", "", $str);	// strip "ufiles"

        if ($lastChar == '/') {
            $str=substr($str, 0, strlen($str)-1);	// strip trailing slash
        }
        $str = $this->cleanSlashes($str);				// convert double-slashes into single slashes

        return $str;
    }

    /**
     * Removes slashes from a given string if they are the first and/or last character of the string. This allows us to clean path strings which may have extra slashes due to inconsistencies in code design.
     *
     * @param {String} $str - The string we are operating on. This ideally will have a "/" as the first or last character. If not, it's returned verbatim as no functionality has been applied.
     */
    public function deSlashify($str) {
        $f = (substr($str, 0, 1) == '/') 	? true : false;
        $l = (substr($str, -1) == '/') 		? true : false;

        if ($f && $l) {
            $str=substr($str, 1, strlen($str)-1);
        } else if ($f) {
            $str=substr($str, 1);
        } else if ($l) {
            $str=substr($str, 0, strlen($str)-1);
        }

        return $str;
    }

    /**
     * Sorts an array using the Merge Sort algorithm: http://en.wikipedia.org/wiki/Merge_sort
     *
     * @param {array} $array - The array to be sorted.
     * @param {string}
     */
    public function array_sort($array, $on, $order=SORT_ASC) {
        $new_array = array();
        $sortable_array = array();
        $new_linear_array = array();
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = strtolower($v2);
                        }
                    }
                } else {
                    $sortable_array[$k] = strtolower($v);
                }
            }
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        foreach ($new_array as $k => $v) {
            array_push($new_linear_array, $v);
        }
        return $new_linear_array;
    }
}
?>
