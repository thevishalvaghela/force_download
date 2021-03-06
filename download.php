<?php

function validate_file_type($fname) {
// Returns false if a file's extension matches one of the
// extensions deemed invalid.

  $ext = strtolower(substr(strrchr($fname, '.'), 1));
  
  $invalid_ext = array('html', 'htm', 'php', 'asp');
  foreach($invalid_ext as $value) {
    if($ext == $value) return false;
  }
  
  // Return function as false if requested file has no extension.
  if($ext == false) { return false; }
  
  // Otherwise, return true.
  else { return true; }
  // return true;
}

function force_download($file_name) {
  validate_file_type($file_name) or die('Invalid File Type');
  
  // Check requested file exists.
  if(is_file($file_name)) {
    
    // Required by IE
    if(ini_get('zlib.output_comporession')) { ini_set('zlib.output_compression', 'Off'); }
    
    // Get mime type from file extension
    switch(strtolower(substr(strrchr($file_name,'.'),1))) {
      case 'pdf': $mime_type = 'application/pdf'; break;
      case 'zip': $mime_type = 'application/zip'; break;
      case 'gif': $mime_type = 'image/gif'; break;
      case 'jpeg':
        case 'jpg': $mime_type = 'image/jpg'; break;
      default: $mime_type = 'application/octet-stream';
    }
    
    // Set headers.
    header('Content-Description: Download');
    header('Content-Type: '.$mime_type);
    header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: '.filesize($file_name));
    header('Connection: close');
    
    // Erase and flush the output buffer
    ob_clean();
    flush();
    
    readfile($file_name);
    exit;
    
  }else{
    echo "<h1>Invalid Request</h1><br />";
    echo $file_name;
  }
  
}

// Replace {PATH_TO_FILE} with your method of specifying the file's name and path
// For example: this script was originally developed to receive a file specified
// by name in the URL, located in a specific directory.  My original code looked
// something like this...
//
// $fname = $_GET['f'];
// $file_path = '/downloads/'.$fname;
//
  
$file_path = "{PATH_TO_FILE}";
force_download($file_path);

?>
