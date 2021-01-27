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

require_once('../../config.php');
require_once('lib.php');
//require_once(__DIR__ . '/classes/forms/new_text_form.php');

$cmid = required_param('id', PARAM_INT);

$url = new moodle_url('/mod/annotate/view.php', ['id' => $cmid]);
$PAGE->set_url($url);

if (! $cm = get_coursemodule_from_id('annotate', $cmid)) {
    print_error('invalidcoursemodule');
}

if (! $course = $DB->get_record('course', ['id' => $cm->course])) {
    print_error('coursemisconf');
}

require_course_login($course, false, $cm);

// if (! $annotate = annotate_get_annotate($cm->instance)) {
//     print_error('invalidcoursemodule');
// }

$context = context_module::instance($cmid);

// var_dump($cm);
// die();

// global $DB;
// $course = $DB->get_record('course', array('id' => $cm->course));
// $info = get_fast_modinfo($course);
// print_object($info);
// die();

// Create a new annotate instance that we can use
$annotate = new \mod_annotate\annotate($cm->instance);

$PAGE->set_title($annotate->name);
$PAGE->set_heading($annotate->name);
$PAGE->set_context($context);

$PAGE->requires->js_call_amd('mod_annotate/test', 'init');

#$outputpage = new \mod_annotate\output\view($annotate->name);
#$output = $PAGE->get_renderer('mod_annotate');

#echo $output->header();
#echo $output->render($outputpage);

// Load the text and its annotations.
// Setup the page differently based on the permissions
// of the user (based on the "Annotate type" field).
$outputpage = new \mod_annotate\output\view($annotate);
$output = $PAGE->get_renderer('mod_annotate');

echo $output->header();
echo $output->render($outputpage);
echo $output->footer();
die();

// If there is already a text for the instance, 
// render the annotation screen.
if ($text = $DB->get_field('annotate', 'text', ['id' => $id])) {
    echo html_writer::div("Text variable contains: $text");

    $outputpage = new \mod_annotate\output\view($text);
    $output = $PAGE->get_renderer('mod_annotate');
    echo $output->header();
    echo $output->render($outputpage);
    echo $output->footer();
} 
// If no text has been entered for the instance yet,
// provide an editor so it can be provided.
else {
    $output = $PAGE->get_renderer('mod_annotate');
    echo $output->header();
    echo $output->heading(get_string('edittextheading', 'annotate'), 2);
    echo $output->edit_text_form();
    echo $output->footer();
}