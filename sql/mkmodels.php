<?php

$fin_csv = fopen("tables.csv", "r");

while ($fields = fgetcsv($fin_csv)) {
    if (!$fields[0]) continue;

    $table = $fields[0];

    echo "Table: $table\n";

$fout_txt = fopen($table.".php", "w");


fprintf($fout_txt, '<?php'."\n");
fprintf($fout_txt, "\n");
fprintf($fout_txt, 'require_once $_SERVER[\'DOCUMENT_ROOT\'] . \'/utils/init.php\';'."\n");
fprintf($fout_txt, "\n");
fprintf($fout_txt, 'class '.$table.' extends Model'."\n");
fprintf($fout_txt, '{'."\n");
fprintf($fout_txt, '    public function __construct()'."\n");
fprintf($fout_txt, '    {'."\n");
fprintf($fout_txt, '        parent::__construct("'.$table.'", "PRIMARY_KEY");'."\n");
fprintf($fout_txt, '    }'."\n");
fprintf($fout_txt, '}'."\n");
    
}
