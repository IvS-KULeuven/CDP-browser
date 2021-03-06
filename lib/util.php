<?php
class Utils
{
  public  function checkGetKey($key,$default='')
  { return (array_key_exists($key,$_GET)&&($_GET[$key]!=''))?$_GET[$key]:$default;
  }

  public  function utilitiesDispatchIndexAction()
  {
  	if(!($indexActionInclude=$this->utilitiesCheckIndexActionAdmin('admin_users', 'common/content/user_admin.php')))
    if(!($indexActionInclude=$this->utilitiesCheckIndexActionAdmin('import_csv_file', 'cdp/content/import_csv_file.php')))
    if(!($indexActionInclude=$this->utilitiesCheckIndexActionAll('download_list', 'miri_cdp.bash')))
    if(!($indexActionInclude=$this->utilitiesCheckIndexActionAdmin('admin_metadata', 'metadata/content/metadata_admin.php')))
  	if(!($indexActionInclude=$this->utilitiesCheckIndexActionMember('deliver_cdp', 'cdp/content/deliver_cdp.php')))
    if(!($indexActionInclude=$this->utilitiesCheckIndexActionMember('undeliver_cdp', 'cdp/content/undeliver_cdps.php')))

  	if ($indexActionInclude == "") {
  		$indexActionInclude = 'cdp/content/list.php';
  	}

    return $indexActionInclude;
  }
  // Only logged in users can do this action
  public function utilitiesCheckIndexActionMember($action, $includefile)
  { global $loggedUser;
  if(array_key_exists('indexAction',$_GET) && ($_GET['indexAction'] == $action) && $loggedUser)
  	return $includefile;
  }
  // All users can do this action
  public function utilitiesCheckIndexActionAll($action, $includefile)
  { if(array_key_exists('indexAction',$_GET)&&($_GET['indexAction']==$action))
  	return $includefile;
  }
  // Only administrators can do this action
  public function utilitiesCheckIndexActionAdmin($action, $includefile)
  { if(array_key_exists('indexAction',$_GET) && ($_GET['indexAction'] == $action) && array_key_exists('admin', $_SESSION) && ($_SESSION['admin'] == "yes"))
  	return $includefile;
  }

  // Add the pager for the table
  public function addTablePager($id = "") {
  	echo "<!-- pager -->
          <div id=\"pager" . $id . "\" class=\"pager\">
           <form>
            <span class=\"glyphicon glyphicon-step-backward first\"></span>
            <span class=\"glyphicon glyphicon-backward prev\"></span>
            <span class=\"pagedisplay\"></span> <!-- this can be any element, including an input -->
            <span class=\"glyphicon glyphicon-forward next\"></span>
            <span class=\"glyphicon glyphicon-step-forward last\"></span>
            <select class=\"pagesize\" title=\"Items per page\">
             <option selected=\"selected\" value=\"10\">10</option>
             <option value=\"20\">20</option>
             <option value=\"30\">30</option>
             <option value=\"40\">40</option>
            </select>
            <select class=\"gotoPage\" title=\"Select page number\"></select>
           </form>
          </div>";
  }
  // Add the javascript for the table
  public function addTableJavascript($id = "") {
    // Make the table sorter, add the pager and add the column chooser
    echo "<script type=\"text/javascript\">";
    echo "$(\"table\").tablesorter({
            theme: \"bootstrap\",
            widthFixed: true,
            headerTemplate: '{content} {icon}',
            widgets: [\"uitheme\", \"filter\", \"zebra\"],
            widgetOptions : {
            }
          })

  		 var pagerOptions = {

    // target the pager markup - see the HTML block below
    container: $(\"#pager" . $id . "\"),

    // use this url format \"http:/mydatabase.com?page={page}&size={size}&{sortList:col}\"
    ajaxUrl: null,

    // modify the url after all processing has been applied
    customAjaxUrl: function(table, url) { return url; },

    // process ajax so that the data object is returned along with the total number of rows
    // example: { \"data\" : [{ \"ID\": 1, \"Name\": \"Foo\", \"Last\": \"Bar\" }], \"total_rows\" : 100 }
    ajaxProcessing: function(ajax){
      if (ajax && ajax.hasOwnProperty('data')) {
        // return [ \"data\", \"total_rows\" ];
        return [ ajax.total_rows, ajax.data ];
      }
    },

    // output string - default is '{page}/{totalPages}'
    // possible variables: {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
    output: '{startRow} to {endRow} ({totalRows})',

    // apply disabled classname to the pager arrows when the rows at either extreme is visible - default is true
    updateArrows: true,

    // starting page of the pager (zero based index)
    page: 0,

    // Number of visible rows - default is 10
    size: 10,

    // Save pager page & size if the storage script is loaded (requires $.tablesorter.storage in jquery.tablesorter.widgets.js)
    savePages : true,

    //defines custom storage key
    storageKey:'tablesorter-pager',

    // if true, the table will remain the same height no matter how many records are displayed. The space is made up by an empty
    // table row set to a height to compensate; default is false
    fixedHeight: true,

    // remove rows from the table to speed up the sort of large tables.
    // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
    removeRows: false,

    // css class names of pager arrows
    cssNext: '.next', // next page arrow
    cssPrev: '.prev', // previous page arrow
    cssFirst: '.first', // go to first page arrow
    cssLast: '.last', // go to last page arrow
    cssGoto: '.gotoPage', // select dropdown to allow choosing a page

    cssPageDisplay: '.pagedisplay', // location of where the output is displayed
    cssPageSize: '.pagesize', // page size selector - select dropdown that sets the size option

    // class added to arrows when at the extremes (i.e. prev/first arrows are disabled when on the first page)
    cssDisabled: 'disabled', // Note there is no period "." in front of this class name
    cssErrorRow: 'tablesorter-errorRow' // ajax error information row

  };

  $(\"table\")

    // Initialize tablesorter
    // ***********************
    .tablesorter({
      theme: 'blue',
      widthFixed: true,
      widgets: ['zebra']
    })

    // bind to pager events
    // *********************
    .bind('pagerChange pagerComplete pagerInitialized pageMoved', function(e, c){
      var msg = '\"</span> event triggered, ' + (e.type === 'pagerChange' ? 'going to' : 'now on') +
        ' page <span class=\"typ\">' + (c.page + 1) + '/' + c.totalPages + '</span>';
      $('#display')
        .append('<li><span class=\"str\">\"' + e.type + msg + '</li>')
        .find('li:first').remove();
    })

    // initialize the pager plugin
    // ****************************
    .tablesorterPager(pagerOptions);";

    echo "</script>";


  }
}
?>
