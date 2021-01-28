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

    // Get document text and format without overwriting the document property
    $tempdocument = $annotate->document['text'];
    $tempdocumentformat = $annotate->document['format'];

    $annotate->document = $tempdocument;
    $annotate->documentformat = $tempdocumentformat;

    // Add indexes to each tag in the html for the document.
    // This will make it easier to store annotations later on
    // (or that's the theory at least...)
    $index = 1;
    $appendto = true;
    $indexeddocument = '';
    $splitdocument = preg_split('/(<[^\/][A-Za-z0-9]*)/', $annotate->document, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    foreach($splitdocument as $split) {
        if ($appendto) {
            $indexeddocument .= $split . " data-index='$index'";
        } else {
            $indexeddocument .= $split;
        }
        $index++;
        $appendto = $appendto ? false : true;
    }
    $annotate->document = $indexeddocument;

    // var_dump($indexeddocument);
    // die();

    // Save annotation instance in the database
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
function annotate_update_instance($annotate, $mform) {
    global $DB;

    $record = $DB->get_record('annotate', ['id' => $annotate->instance]);

    foreach($record as $key => $val){
        if(isset($annotate->$key)){
            $record->$key = $val;
        }
    }

    $record->document = $annotate->document['text'];
    $record->documentformat = $annotate->document['format'];
    
    $DB->update_record('annotate', $record);
    return true;
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

/**
 * Returns an array of editor options
 * supplied to the fourth parameter when loading
 * the editor from a form.
 * 
 * @param string $context The editor's context
 * @return array
 */
function annotate_get_editor_options($context) {
    return [
        'subdirs' => 0,
        'maxbytes' => 0,
        'maxfiles' => 0,
        'changeformat' => 1,
        'context' => $context,
        'noclean' => 1,
        'trusttext' => 0,
        'enable_filemanagement' => true
    ];
}
