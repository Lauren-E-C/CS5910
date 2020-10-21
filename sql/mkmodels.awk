 BEGIN {
    FS=",";
 }
 {
    if ($1) {
        print "\n);\n";
        printf "CREATE TABLE "$1" (";
    } else {
        printf ",\n";
        if ($3 == "varchar") {
            printf "    "$2" "$3"("$4")";
        } else {
            printf "    "$2" "$3"";
        }
    }
 }
 END {
    print "Done\n";
 }
