# script to run php documenter and create html file for documentation inline
# usage: build-docs.sh
# author: Pelle

PWD=`pwd`
cd `dirname $0`/..

#TARGET="assets/docs"
TARGET="templates/game/docs"
TEMPLATE="tools/phpdoc-template/themes/simple"


# check if phpDocumentor is installed
if ! command -v phpdoc &> /dev/null
then
    echo "phpDocumentor could not be found. Please install it first."
    exit
fi

# 

phpdoc \
    -d src/game \
    -t $TARGET  \
    --template=$TEMPLATE

# phpdoc -d src/Card -d src/Controller -t $TARGET  --template=$TEMPLATE
# Cleanup
cd $PWD
