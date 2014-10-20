<?php
// miri_cdp.bash
// exports a bash file to download the CDP files
header ( "Content-Type: text/plain" );
header ( "Content-Disposition: attachment; filename=\"miri_cdp_pipeline.bash\"" );

if (isset($_GET['release'])) {
  $release = $_GET['release'];
} else {
  $release = "";
}
miri_cdp_pipeline($release);

function miri_cdp_pipeline($release) {
  $loginErrorCode = "";
  $loginErrorText = "";
  require_once 'common/entryexit/preludes.php';
  
  global $ftp_server, $ftp_directory, $objCdp;
  
  print "#!/bin/bash
#
# bash script to syncronize the CDPs between the miri ftp repository
# and your drive. If you have DHAS installed and thus the environment
# variable MIRI_DIR defined, the CDPs will be put into the appropriate
# location for DHAS.
#
# After syncronization a md5sum check is run on all the files.
#
# miri_cdp_pipeline.bash --help 
# for help
#
# If you run into any problems email me wim.demeester@ster.kuleuven.be
#
function md5_check {
  echo \"\"
  echo \"Checking the MD5 hashes of the CDP files...\"
  echo \"\"
  
  failed=0";

  echo "
if [[ -z \$CDP_DIR ]]; then
  cdpdir=`pwd`
else
  cdpdir=\"\$CDP_DIR\"
fi
      ";
  
  // Here, we add all files which belong to a certain pipeline module.
  $modules = $objCdp->getPipelineModules ();
  
  foreach ( $modules as $module ) {
    // All filenames
    $items = $objCdp->getFilesForPipelineModule ( $module [0] );
    
    $pipelineSteps = $objCdp->getPipelineSteps ( $items );
    $refTypes = $objCdp->getRefTypes ( $items );
    $deliveries = $objCdp->getDeliveriesFromFiles ( $items, $release );
    $fileTypes = $objCdp->getFileTypes ( $items );
    
    foreach ( $pipelineSteps as $step ) {
      foreach ( $refTypes as $refType ) {
        foreach ( $deliveries as $delivery ) {
          foreach ( $fileTypes as $fileType ) {
            // Here, we check the filenames for the different pipeline steps
            $fileNames = $objCdp->getFileNames ( $module [0], $step, $refType, $delivery, $fileType );
            // If there are files, we make a directory for this combination and download the files
            if (count ( $fileNames ) > 0) {
              echo "
  cd \$cdpdir/" . $module [0] . "/" . $step . "/" . $refType . "/CDP" . $delivery . "/" . $fileType;
              echo "
  echo \"Checking files in \$cdpdir/" . $module [0] . "/" . $step . "/" . $refType . "/CDP" . $delivery . "/" . $fileType . "\"";
              foreach ( $fileNames as $file ) {
                
                echo "\n  file=\"" . $file . "\"
  if [[ -e \$file ]] ; then
    md5v=`grep \"" . $file . "\" md5_miri_cdps | uniq`
    if [ -n \"\$md5v\" ] ; then
      md5v=`echo \$md5v | awk '{if(NF != 2){print \"0\"} else {print \$1}}'`
    else
      md5v=\"1\"
    fi
    if [ \"\$md5v\" == \"1\" ]; then 
      echo \"\$file NO MD5 HASH\"
    else
      if [ `md5_value \$file` != \$md5v ] ; then
        echo \"\$file FAILED\"
        failed=1
      fi
    fi
  else
    echo \"\$file does not exist\"
    failed=1
  fi";
              }
              
              echo "\n  if [ \$failed == 1 ]; then
    echo \"Something has gone wrong in the transfer of these files.\"
    echo \"Please remove FAILED files by hand and start this script again\"
    echo \"\"
  else
    echo \"All files are correct\"
    echo \"\"
  fi";
            }
          }
        }
      }
    }
  }
  echo "
}

function remove_old {
  files=`ls MIRI_*.fits MRS_*`
  for file in \$files
  do
    okay=`grep \$file masterlist_dhas.txt | wc -l`
    if [ \$okay == 0 ] ; then
      #echo \$file\" \"old
      rm -f \$file
    fi
  done
}

function md5_value {
  case \"\$OSTYPE\" in
    \"linux\"*)
      md5sum $1 | awk '{print $1}'
      ;;
    \"darwin\"*)
      md5 -q $1
      ;;
    *)
      echo \"null\"
      ;;
  esac
}

while [ \"$1\" != \"\" ]
do
   case $1 in
    \"--test\")
     test=1
     ;;
    \"--check\")
     check=1
     ;;
    \"--remove_old\")
     remove_old
     exit
     ;;
    \"--clean\")
     remove_old
     exit
     ;;
    \"--help\")
     echo \"\"
     echo \"   miri_cdp_flat.bash [--check] [--remove_old] [--clean] [--test]\"
     echo \"\"
     echo \"when run without arguments it will sync all the delivered CDPs in a flat directory structure.\"
     echo \"  --check\"
     echo \"    for files in the delivery check if local files match those of the ftp\" 
     echo \"  --remove_old\"
     echo \"    remove any CDP files not in the CDP deliveries\"
     echo \"  --clean\"
     echo \"    same as --remove_old\"
     exit
     ;;
    *)
   esac
   shift
done

which lftp &> /dev/null
case $? in
 0)
    #echo okay
    ;;
 *)
    echo \"lftp is either not installed or non existent, please fix this\"
    echo \"E.g. on Mac OS X, install with 'fink install lftp'\"
    echo \"on debian/ubuntu, install with 'sudo apt-get install lftp'\"
    exit
esac

if [[ -z \$CDP_DIR ]]; then
  cdpdir=`pwd`/MIRI_CDPS
else
  cdpdir=\"\$CDP_DIR\"
fi
mkdir -p \$cdpdir
cd \$cdpdir";
  
  echo "\n";
  // Here, we add all files which belong to a certain pipeline module.
  $modules = $objCdp->getPipelineModules ();
  
  foreach ( $modules as $module ) {
    // All filenames
    $items = $objCdp->getFilesForPipelineModule ( $module [0] );
    
    $pipelineSteps = $objCdp->getPipelineSteps ( $items );
    $refTypes = $objCdp->getRefTypes ( $items );
    $deliveries = $objCdp->getDeliveriesFromFiles ( $items, $release );
    $fileTypes = $objCdp->getFileTypes ( $items );
    
    foreach ( $pipelineSteps as $step ) {
      foreach ( $refTypes as $refType ) {
        foreach ( $deliveries as $delivery ) {
          foreach ( $fileTypes as $fileType ) {
            // Here, we check the filenames for the different pipeline steps
            $fileNames = $objCdp->getFileNames ( $module [0], $step, $refType, $delivery, $fileType );
            // If there are files, we make a directory for this combination and download the files
            if (count ( $fileNames ) > 0) {
              echo "mkdir -p " . $module [0] . "/" . $step . "/" . $refType . "/CDP" . $delivery . "/" . $fileType . "\n";
              
              echo "
                  HOST=\"$ftp_server\"
                  LCD=\"\$cdpdir/" . $module [0] . "/" . $step . "/" . $refType . "/CDP" . $delivery . "/" . $fileType . "\"
                  RCD=\"$ftp_directory\"
              
                  lftp -c \"set ftp:list-options -a;
                  open \$HOST ;
                  lcd \$LCD ;
                  cd \$RCD ;
                  mirror --verbose \
                  --include-glob md5_miri_cdps\"
              
                  if [ \$check ] ; then
                  md5_check
                  exit
                  fi
              ";
              
              echo "echo \"Updating CDP files to \"\$cdpdir/" . $module [0] . "/" . $step . "/" . $refType . "/CDP" . $delivery . "/" . $fileType . "
echo \"Beware that this can take quite a long time\"
echo \"\"
echo \"set ftp:list-options -a\"          >  lftp_script
echo \"open \$HOST \"                      >> lftp_script
echo \"lcd \$LCD \"                        >> lftp_script
echo \"cd \$RCD \"                         >> lftp_script
echo \"mirror --verbose \\\\\"              >> lftp_script";
              
              foreach ( $fileNames as $file ) {
                echo "\necho \"       --include-glob '" . $file . "' \\\\\" >> lftp_script";
              }
              
              echo "\necho \"       --parallel\"                >> lftp_script
              
              lftp -f lftp_script
              ";
            }
          }
        }
      }
    }
  }
  
  echo "\nmd5_check

# Remove all the md5_miri_cdps files.
cd \$cdpdir
find . -type f -name md5_miri_cdps -exec rm -f {} \\;
find . -type f -name lftp_script -exec rm -f {} \\;

echo \"\"
echo \"MIRI CDP synchronization finished\"
echo \"Files are located in \"\$cdpdir
echo \"\"";
}
?>