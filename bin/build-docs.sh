# script to run php documenter and create html file for documentation inline
# usage: build-docs.sh

PWD=`pwd`
cd `dirname $0`/..

#TARGET="assets/docs"
TARGET="templates/card/docs"
TEMPLATE="tools/phpdoc-template/themes/simple"


# check if phpDocumentor is installed
if ! command -v phpdoc &> /dev/null
then
    echo "phpDocumentor could not be found. Please install it first."
    exit
fi

# 

phpdoc \
    -f src/Card/Card.php \
    -f src/Card/CardGraphic.php \
    -f src/Card/CardHand.php \
    -f src/Card/DeckOfCards.php \
    -f src/Controller/CardGameController.php ·\
    -f src/Controller/CardAPIController.php \
    -t $TARGET  \
    --template=$TEMPLATE
# phpdoc -d src/Card -d src/Controller -t $TARGET  --template=$TEMPLATE
# Cleanup
cd $PWD
