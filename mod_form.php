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

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once(__DIR__ . '/lib.php');

// Annotation activity types
define('ANNOTATE_TYPE_TEACHER_WRITE_GROUP', 1);
define('ANNOTATE_TYPE_ALL_WRITE_GROUP', 2);
define('ANNOTATE_TYPE_ALL_WRITE_INDIVIDUAL', 3);

class mod_annotate_mod_form extends moodleform_mod {

    public function definition() {
        global $CFG;

        $mform =& $this->_form;

        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('text', 'name', get_string('annotatename', 'annotate'), ['size' => '64']);
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

        $this->standard_intro_elements(get_string('description', 'annotate'));
        
        $mform->addElement('header', 'annotation', get_string('annotationsection', 'annotate'));

        $options = [
            ANNOTATE_TYPE_TEACHER_WRITE_GROUP => get_string('type_teacherwritegroup', 'annotate'),
            ANNOTATE_TYPE_ALL_WRITE_GROUP => get_string('type_allwritegroup', 'annotate'),
            ANNOTATE_TYPE_ALL_WRITE_INDIVIDUAL => get_string('type_allwriteindividual', 'annotate')
        ];
        $select = $mform->addElement('select', 'type', get_string('type', 'annotate'), $options);
        $select->setSelected(ANNOTATE_TYPE_ALL_WRITE_INDIVIDUAL);
        $mform->addHelpButton('type', 'type', 'annotate');
        if($this->_cm) {
            $mform->freeze('type');
        }

        $mform->addElement('editor', 'document', get_string('document', 'annotate'), annotate_get_editor_options($this->context));
        $mform->setType('document', PARAM_RAW);
        $mform->addRule('document', null, 'required');

        $this->standard_coursemodule_elements();

        $this->add_action_buttons();
    }

    public function data_preprocessing(&$default_values) {
        if ($this->current->instance) {
            $format = $default_values['documentformat'];
            $text = file_prepare_draft_area($draftitemid, $this->context->id, 'mod_annotate',
                'document', 0, annotate_get_editor_options($this->context), $default_values['document']);

            $default_values['document'] = ['format'=>$format, 'text'=>$text];
        }
    }
}
