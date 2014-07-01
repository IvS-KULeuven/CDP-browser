<?php
global $objMetadata;

$filename = $_GET['filename'];
$size = $_GET['size'];

echo "<div class=\"container-fluid\">";

echo "<h2>Deliver " . $filename . "</h2>";

echo "<form role=\"form\" action=\"".$baseURL."index.php\" method=\"post\">
       <div class=\"input-group\">
        <label for=\"delivery\">Delivery</span>
        <select id=\"delivery\" name=\"delivery\" class=\"form-control\" required autofocus>";

$delivery = $objMetadata->getValidValues("DELIVERY");

echo "<option value=\"\"></option>";

foreach ($delivery as $key) {
  echo "<option value=\"" . $key['value'] . "\">" . $key['value'] . "</option>";
}

echo "  </select>
       </div>";
//        <div class=\"input-group\">
//         <span class=\"input-group-addon\">Location</span>
//         <select name=\"location\" class=\"form-control\">
//          <option value=\"FITS\">FITS</option>
//          <option value=\"External\">External</option>
//         </select>
//        </div>
//        <div class=\"input-group\">
//         <span class=\"input-group-addon\">Type</span>
//         <select name=\"type\" class=\"form-control\">
//          <option value=\"Integer\">Integer</option>
//          <option value=\"String\">String</option>
//          <option value=\"List\">List</option>
//         </select>
//        </div>
//        <div class=\"input-group\">
//         <span class=\"input-group-addon\">Default value</span>
//         <input type=\"text\" name=\"value\" class=\"form-control\" placeholder=\"Value\">
//        </div>
echo "  <input type=\"hidden\" name=\"indexAction\" value=\"deliver_cdp_file\" />
        <input type=\"hidden\" name=\"filename\" value=\"". $filename ."\" />
        <input type=\"hidden\" name=\"size\" value=\"". $size ."\" />
        <button class=\"btn btn-lg btn-primary\" type=\"submit\">
         Deliver CDP file
        </button>";
echo "</form>";

echo "</div>";
?>