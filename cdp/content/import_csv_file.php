<?php

echo " <div class=\"container-fluid\">";
print "<h2>Deliver CDP files using a CSV file.</h2>";

echo "<p>You can deliver a lot of CDP files at once using a CSV file.<br /> 
      The first line of this file should define the keywords, the next lines should
      define the CDP files to deliver. The fields should be separated by a '<strong>|</strong>'.</p>

      <p>For example :

    <pre><strong>Filename|DELIVERY|UPLOAD DATE|FILETYPE|PIPELINE MODULE|PIPELINE STEP|REFTYPE|DOCNAME|DEPENDENCY|DOCTYPE|DOCVERSION|ALGTYPE|ALGVERSION</strong>
MIRI_FM_IM_Bad_02.01.01.fits|2.1|2014-03-04|referencefile|CALDETECTOR1|data_rejection|MASK|MIRI-TN-00006-UA-Bad-Pixel-Mask.pdf|||||
MIRI_FM_LW_Bad_02.01.01.fits|2.1|2014-03-04|referencefile|CALDETECTOR1|data_rejection|MASK|MIRI-TN-00006-UA-Bad-Pixel-Mask.pdf|||||</pre>
    </p>";

echo " </div>";
echo "</body>";

?>