#!/bin/sh -x

cp admin_major_add.php admin_minor_add.php
cp admin_major_edit.php admin_minor_edit.php
cp admin_major_grid.php admin_minor_grid.php
cp admin_major_requirement_add.php admin_minor_requirement_add.php
cp admin_major_requirement_edit.php admin_minor_requirement_edit.php

for f in admin_minor_add.php admin_minor_edit.php admin_minor_grid.php admin_minor_requirement_add.php admin_minor_requirement_edit.php; do
  sed -i 's/Major/Minor/g' $f
  sed -i 's/major/minor/g' $f
done
