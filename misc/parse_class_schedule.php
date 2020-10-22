<?php

$fin = fopen("Class Schedule Listing.html", "r");

$fout = fopen("courses.csv", "w");

process_file($fin, $fout);

function process_file($fin, $fout) {
	$row = array("name","crn","dept","couse","section", "credits", "levels", "type", "time", "days", "where", "dates", "schedule_type", "instructors");
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
		if (strpos($line, "Levels") > 0) {
			$levels = preg_replace("/^.*span>/", "", $line);
			$row[] = $levels;
		}
		if ($line === '<th class="ddheader" scope="col">Instructors</th>') {
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
				$line = preg_replace("/<\/td>.*/", "", $line);
				$line = preg_replace("/ \(.*/", "", $line);
				$line = preg_replace("/<abbr title=\"To Be Announced\">TBA<\/abbr>/", "TBA", $line);
				$line = preg_replace("/&nbsp;/", "TBA", $line);
				#$row[$key] = $line;
echo "$line\n";
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
