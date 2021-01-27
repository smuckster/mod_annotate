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

namespace mod_annotate;

require_once('lib.php');
class annotate {
    public $name;
    public $text;
    public $type;
    public $annotations;

    /**
     * Construct a new annotate object by accepting
     * its course module id then loading relevant data
     * from the database.
     * 
     * @param integer $cmid Course module id
     */
    public function __construct($cmid) {
        // Get records for this instance from the database
        if (! $annotate = annotate_get_annotate($cmid)) {
            print_error('invalidcoursemodule');
        }

        $this->name = $annotate->name;
        $this->document = format_text($annotate->document);
        $this->type = $annotate->type;
    } 
}