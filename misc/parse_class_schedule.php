<?php

$input_filename = $argv[1];
$output_filename = 'csv/' . basename($input_filename, ".html") . '.csv';

$fin = fopen($input_filename, "r");
$fout = fopen($output_filename, "w");

echo "Processing: $input_filename $output_filename\n";

process_file($fin, $fout);

echo "done.\n";

function process_file($fin, $fout) {
	$row = array("name","crn","dept","course","section", "credits", "levels", "type", "time", "days", "where", "dates", "schedule_type", "instructors");
	while ($line = fgets($fin)) {

		$line = preg_replace("/\n/", "", $line);
		$line = preg_replace("/\r/", "", $line);
	
		if (strpos($line, "ddtitle") > 0) {
			fputcsv($fout, $row);
			$line = preg_replace("/^.*\">/", "", $line);
			$line = preg_replace("/<.*/", "", $line);
			$line = preg_replace("/\n/", "", $line);
			$line = preg_replace("/ 2D -/", "", $line);
			$line = preg_replace("/^GRST - /", "", $line);
			$line = preg_replace("/\r/", "", $line);
			echo "Line: $line\n";
	
	
			list($name, $crn, $dept_course, $section) = preg_split("/ - /", $line);
			list($dept, $course) = preg_split("/ /", $dept_course);
	
			$row = array($name, $crn, $dept, $course, $section);
		}
		if (strpos($line, "Credits") > 0) {
			$credits = preg_replace("/Credits.*/", "", $line);
			$credits = preg_replace("/^  */", "", $credits);
			$row[] = $credits;
		}

		// <SPAN class=""fieldlabeltext"">Levels: </SPAN>
		if (strpos($line, "Levels") > 0) {
			$levels = preg_replace("/^.*SPAN>/", "", $line);
			$levels = preg_replace("/^.*span>/", "", $levels);
			$row[] = $levels;
		}
//		if ($line === '<th class="ddheader" scope="col">Instructors</th>') {
		if (preg_match('/th.*ddheader.*Instructors/', $line)) {
            //echo "ddheader: $line\n";
			while ($line = fgets($fin)) {
				$line = preg_replace("/\n/", "", $line);
				$line = preg_replace("/\r/", "", $line);
				if ($line === "<tr>") break;
			}
			foreach (array("type", "time", "days", "where", "dates", "schedule_type", "instructors") as $key) {
				$line = fgets($fin);
				$line = preg_replace("/\n/", "", $line);
				$line = preg_replace("/\r/", "", $line);
				$line = preg_replace("/^<td class=\"dddefault\">/", "", $line);
				$line = preg_replace("/^<td CLASS=\"dddefault\">/", "", $line);
				$line = preg_replace("/<\/td>.*/", "", $line);
				$line = preg_replace("/ \(.*/", "", $line);
				$line = preg_replace("/<abbr title=\"To Be Announced\">TBA<\/abbr>/", "TBA", $line);
				$line = preg_replace("/&nbsp;/", "TBA", $line);
				#$row[$key] = $line;
                echo "dddefault: $line\n";
				$row[] = $line;
			}
			while ($line = fgets($fin)) {
				$line = preg_replace("/\n/", "", $line);
				$line = preg_replace("/\r/", "", $line);
				if ($line === "</tr>") break;
			}
		}
	}
}
