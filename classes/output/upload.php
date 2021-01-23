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

class upload implements templatable, renderable {
    /** @var string $user */
    protected $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function export_for_template(renderer_base $output) {
        $data = [];
        $data['user'] = $this->user;

        return $data;
    }
}