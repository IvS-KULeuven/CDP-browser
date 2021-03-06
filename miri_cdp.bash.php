<?php 
// miri_cdp.bash
// exports a bash file to download the CDP files

header ("Content-Type: text/plain");
header ("Content-Disposition: attachment; filename=\"miri_cdp" . $_GET['release'] . ".bash\"");

ini_set('max_execution_time', 600);

$release = $_GET['release'];
miri_cdp($release);

function miri_cdp($release)
{ 
  $loginErrorCode = "";
  $loginErrorText = "";
  require_once 'common/entryexit/preludes.php';

  global $ftp_server, $ftp_directory, $ftp_user, $ftp_password, $objCdp;

  print"#!/bin/bash
#
# bash script to synchronize the CDPs between the miri ftp repository
# and your drive. If you have DHAS installed and thus the environment
# variable MIRI_DIR defined, the CDPs will be put into the appropriate
# location for DHAS.
#
# After syncronization a md5sum check is run on all the files.
#
# miri_cdp.bash --help 
# for help
#
# If you run into any problems email me F.Lahuis@sron.nl
#
function md5_check {
  echo \"\"
  echo \"Checking the MD5 hashes of the CDP files...\"
  echo \"\"
  
  failed=0";

// Here, we add all files which belong to the given CDP release.
$items = $objCdp->getFilesForCdpDelivery($release);
  
foreach ($items as $key) {

echo "\n  file=\"" . $key ['filename'] . "\"
    if [ -e \$file ] ; then
    md5v=`grep \"" . $key['filename'] . "\" md5_miri_cdps | uniq`
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
    echo \"\"
    echo \"Something has gone wrong in the transfer of these files.\"
    echo \"Please remove FAILED files by hand and start this script again\"
    echo \"\"
  else
    echo \"\"
    echo \"All files are correct\"
    echo \"\"
  fi
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
     echo \"   miri_cdp$release.bash [--check] [--remove_old] [--clean] [--test]\"
     echo \"\"
     echo \"when run without arguments it will sync the CDPs valid for the $release delivery.\"
     echo \"  --check\"
     echo \"    for files in the $release delivery check if local files match those of the ftp\" 
     echo \"  --remove_old\"
     echo \"    remove any CDP files not in the $release delivery\"
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
mkdir -p \"\$cdpdir\"
cd \"\$cdpdir\"
echo \"\"

HOST=\"" . $ftp_user . ":" . $ftp_password . "@" . $ftp_server . "\"
LCD=\"\$cdpdir\"
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

echo \"Updating CDP files to \"\$cdpdir
echo \"Beware that this can take quite a long time\"
echo \"\"
echo \"set ftp:list-options -a\"          >  lftp_script
echo \"open \$HOST \"                      >> lftp_script
echo \"lcd \$LCD \"                        >> lftp_script
echo \"cd \$RCD \"                         >> lftp_script
echo \"mirror --verbose \\\\\"              >> lftp_script";

// Here, we add all files which belong to the given CDP release.
$items = $objCdp->getFilesForCdpDelivery($release);
  
foreach ($items as $key) {
  echo "\necho \"       --include-glob '" . $key["filename"] . "' \\\\\" >> lftp_script";
}
echo "\necho \"       --parallel\"                >> lftp_script

lftp -f lftp_script

md5_check
    
# Remove all the md5_miri_cdps files.
cd \"\$cdpdir\"
find . -type f -name md5_miri_cdps -exec rm -f {} \\;
find . -type f -name lftp_script -exec rm -f {} \\;

echo \"\"
echo \"MIRI CDP synchronization finished\"
echo \"Files are located in \"\$cdpdir
echo \"\"";
  
}
?>