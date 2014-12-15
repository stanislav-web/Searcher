#!/bin/sh
COVERAGE=""
METRICS="../phpunit/log/coverage.xml"

if [ "$1" == "--coverage" ]
then
  COVERAGE="--coverage-clover $METRICS"
  shift
fi

phpunit $COVERAGE $@

# exit with PHPUnit's return code
if [ $? -ne 0 ]
then
  exit $?
fi

if [ "$COVERAGE" != "" ]
then
  echo "====================== Code Coverage Summary ====================="
  FILTER_LINES="/<class/ { print \$2 } /<metrics method/ { print \$4,\$5 }"
  JOIN_LINES="\$!N;s/\n/ /"
  TRANSFORM="s/name=\"\([A-Za-z_]*\)\" statements=\"\([0-9]*\)\" coveredstatements=\"\([0-9]*\)\"/\1\t\2\t\3/"
  RESULTS=$(cat "$METRICS" | awk "$FILTER_LINES" | sed "$JOIN_LINES" | sed "$TRANSFORM" | tr '\t' '|')
  (for line in $RESULTS; do
    CLASS=`echo "$line" | cut -d '|' -f1`;
    STATEMENTS=`echo "$line" | cut -d '|' -f2`;
    COVERED=`echo "$line" | cut -d '|' -f3`;
    COVERAGE=0
    if [[ "$STATEMENTS" > "0" && "$COVERED" > "0" ]]
    then
      COVERAGE=$(echo | awk "{print $COVERED * 100 / $STATEMENTS}")
    fi
    echo "$CLASS $COVERAGE" | awk '{printf "%-60s %.2f%\n", $1, $2}'
  done) | sort -nr --key=2
  rm "$METRICS"
fi