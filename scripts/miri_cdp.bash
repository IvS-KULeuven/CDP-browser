#!/bin/bash
#
# bash script to syncronize the CDPs between the miri ftp repository
# and your drive. If you have DHAS installed and thus the environment
# variable MIRI_DIR defined, the CDPs will be put into the approrpriate
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
  echo ""
  echo "Checking the fits files"
  echo ""
  
  failed=0
  while read file ; do
    if [ -e $file ] ; then
      md5v=`grep $file md5_miri_cdps | uniq`
      if [ -n "$md5v" ] ; then
        md5v=`echo $md5v | awk '{if(NF != 2){print "0"} else {print $1}}'`
      else
        md5v="1"
      fi
      if [ `md5_value $file` != $md5v ] ; then
        echo "$file FAILED"
        failed=1
      fi
    else
      echo "$file does not excist"
      failed=1
    fi
  done < masterlist_dhas.txt
        
  if [ $failed == 1 ]; then
    echo ""
    echo "Something has gone wrong in the transfer of these files."
    echo "Please remove FAILED files by hand and start this script again"
    echo ""
  else
    echo ""
    echo "All files are correct"
    echo ""
  fi
}

function remove_old {
  files=`ls MIRI_*.fits MRS_*`
  for file in $files
  do
    okay=`grep $file masterlist_dhas.txt | wc -l`
    if [ $okay == 0 ] ; then
      #echo $file" "old
      rm -f $file
    fi
  done
}

function md5_value {
  case "$OSTYPE" in
    "linux"*)
      md5sum $1 | awk '{print $1}'
      ;;
    "darwin"*)
      md5 -q $1
      ;;
    *)
      echo "null"
      ;;
  esac
}

while [ "$1" != "" ]
do
   case $1 in
    "--test")
     test=1
     ;;
    "--check")
     check=1
     ;;
    "--remove_old")
     remove_old
     exit
     ;;
    "--clean")
     remove_old
     exit
     ;;
    "--help")
     echo ""
     echo "   miri_cdp.bash [--check] [--remove_old] [--clean] [--test]"
     echo ""
     echo "when run without arguments it will sync the CDPs valid for the"
     echo "latest dhas build. These files are listed in masterlist_dhas.txt"
     echo "  --check"
     echo "    for files in masterlist_dhas.txt check if local files match those of the ftp" 
     echo "  --remove_old"
     echo "    remove any CDP files not listed in masterlist_dhas.txt"
     echo "  --clean"
     echo "    same as --remove_old"
     echo "  --test"
     echo "    for script modifications, does not download miri_cdp.bash from ftp"
     echo "    and prints some extra verbose information"
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
    echo "lftp is either not installed or non existent, please fix this"
    echo "E.g. on Mac OS X, install with 'fink install lftp'"
    echo "on debian/ubunto, install with 'sudo apt-get install lftp'"
    exit
esac

if [[ -z $CDP_DIR ]]; then
  cdpdir="$HOME/MIRI/CDP"
else
  cdpdir="$CDP_DIR"
fi
mkdir -p $cdpdir
cd $cdpdir
echo ""

md5_old=`md5_value miri_cdp.bash`
if [ $md5_old == 'null' ] ; then 
  echo "Don't know md5 checking command yet for $OSTYPE"
  echo "update script and report back to F.Lahuis@sron.nl"
  exit 
fi

HOST="ftp.ster.kuleuven.be"
LCD=$cdpdir
RCD="miri/CDP"

lftp -c "set ftp:list-options -a;
  open $HOST ; 
  lcd $LCD ;
  cd $RCD ;
  mirror --verbose \
         --include-glob md5_miri_cdps \
         --include-glob masterlist_dhas.txt"

if [ -z $test ] ; then
  lftp -c "set ftp:list-options -a;
    open $HOST ; 
    lcd $LCD ;
    cd $RCD ;
    mirror --verbose \
           --include-glob miri_cdp.bash" 
fi

if [ $check ] ; then 
  md5_check
  exit
fi

md5_new=`md5_value miri_cdp.bash`

if [ -n $test ] ; then echo $md5_old $md5_new ; fi
if [ "$md5_new" != "$md5_old" ]; then
  bash ./miri_cdp.bash
  exit
fi

echo "Updating CDP files to "$cdpdir
echo "Beware that this can take quite a long time"
echo ""
echo "set ftp:list-options -a"          >  lftp_script
echo "open $HOST "                      >> lftp_script
echo "lcd $LCD "                        >> lftp_script
echo "cd $RCD "                         >> lftp_script
echo "mirror --verbose \\"              >> lftp_script
while read file; do
  echo "       --include-glob $file \\" >> lftp_script
done < masterlist_dhas.txt
echo "       --parallel"                >> lftp_script

lftp -f lftp_script

md5_check

echo ""
echo "MIRI CDP synchronization finished"
echo "Files are located in "$cdpdir
echo ""
