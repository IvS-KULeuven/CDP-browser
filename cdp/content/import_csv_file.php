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

// Adding the file upload button
echo "<form action=\"".$baseURL."index.php?indexAction=add_csv\" enctype=\"multipart/form-data\" method=\"post\"><div>";

echo "<div class=\"input-group\">
       <span class=\"input-group-btn\">
        <span class=\"btn btn-primary btn-file\">
         Select CSV file&hellip; <input type=\"file\" name=\"csv\">
        </span>
       </span>
       <input type=\"text\" class=\"form-control\" readonly>
      </div>
    
      <br>
      <br>";

echo "<input type=\"submit\" class=\"btn btn-primary\" name=\"change\" value=\"Deliver CDP files\" />";
echo "</form>";


echo " </div>";
echo "</div>";


echo "<script  type=\"text/javascript\">
$(document).on('change', '.btn-file :file', function() {
  var input = $(this),
      label = input.val().replace(/^.*\\\\/, \"\");
  input.trigger('fileselect', [label]);
});

$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, label) {
        var input = $(this).parents('.input-group').find(':text'),
            log = label;

        if( input.length ) {
            input.val(log);
        }
    });
});    </script>";
?>