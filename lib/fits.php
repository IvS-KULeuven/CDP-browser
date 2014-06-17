<?php
// fits.php
// The fits class collects all functions needed to read the metadata from fits files.

$fits = new Fits();
$fits->getHeader("/lhome/wim/Downloads/MIRI_FM_IM_F1000W_PSF_02.00.01.fits");

class Fits
{
	public function getHeader($filename) {
		echo "Reading in : " . $filename;
		
		$handle = fopen($filename, "r");
		
		if($handle) {
		  $end = false;
          while (!$end) {
            // This loops over the header, till we reach END in the fits file.
            $buffer = fgets($handle, 81);
            // Process buffer here..
            print "<br />\n" .$buffer;
            if (strpos($buffer, "END") === 0) {
              $end = true;
            }
          }

          fclose($handle);
		} else {
          $entryMessage = "Problem reading fits file!";
		}
	}
}
?>