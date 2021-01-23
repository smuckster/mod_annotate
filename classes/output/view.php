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

namespace mod_annotate\output;

use templatable;
use renderable;
use renderer_base;

defined('MOODLE_INTERNAL') || die();

/** Annotate renderable class */

class view implements templatable, renderable {
    /** @var string $name */
    protected $name;

    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * Function to export the renderer data in a format that
     * is suitable for a mustache template.
     * 
     * @param \renderer_base $output Used to do a final render
     * of any components that need to be rendered for export.
     * @return stdClass|array
     */
    public function export_for_template(\renderer_base $output) {
        $data = [];
        $data['name'] = $this->name;

        return $data;
    }
}