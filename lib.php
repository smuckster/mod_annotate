<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>

defined('MOODLE_INTERNAL') || die();

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 * 
 * @param stdClass $annotate Add annotate instance
 * @param mod_annotate_mod_form $mform
 * @return int instance id
 */
function annotate_add_instance($annotate, $mform = null) {
    global $DB;

    $annotate->timecreated = time();
    $annotate->id = '';

    $annotate->id = $DB->insert_record('annotate', $annotate);

    return $annotate->id;
}

/**
 * Update an existing annotate module record and
 * return a boolean representing success/failure.
 * 
 * @param stdClass $annotate the object given my mod_annotate_mod_form
 * @return boolean
 */
function annotate_update_instance($annotate) {
    global $DB;
}

/**
 * Gets a full annotate record
 * 
 * @param int $annotateid
 * @return object|bool The annotate instance or false
 */
function annotate_get_annotate($annotateid) {
    global $DB;

    if ($annotate = $DB->get_record('annotate', ['id' => $annotateid])) {
        return $annotate;
    }

    return false;
}
