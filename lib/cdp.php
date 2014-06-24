<?php
// cdp.php
// The cdp class collects all functions needed to read the files from the ftp server.

class Cdp
{
  // Returns a list with all files from the ftp server.
  public function getFilesFromFtpServer() {
    global $ftp_server;

    // set up an ftp connection
    $conn_id = ftp_connect($ftp_server);

    if (!$conn_id) {
      $entryMessage = "Couldn't connect to $ftp_server";
      return;
    } else {
      // try to login
      if (@ftp_login($conn_id, 'anonymous', '')) {
        if (is_array($children = @ftp_rawlist($conn_id, "/miri/CDP/"))) {
          $items = array();
      
          foreach ($children as $child) {
            $chunks = preg_split("/\s+/", $child);
            list($item['rights'], $item['number'], $item['user'], $item['group'], $item['size'], $item['month'], $item['day'], $item['time']) = $chunks;
            $item['type'] = $chunks[0]{0} === 'd' ? 'directory' : 'file';
            array_splice($chunks, 0, 8);
            if ($item["type"] == "file") {
              $items[implode(" ", $chunks)] = $item;
            }
          }
        }
      } else {
        $entryMessage = "Couldn't connect to $ftp_server";
      }
      
      // Close the connection to the ftp server
      ftp_close($conn_id);
      
      return $items;
    }
  }
}
?>