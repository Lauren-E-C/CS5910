#!/bin/sh

for f in course_data/*; do
  php -f parse_class_schedule.php $f
done
