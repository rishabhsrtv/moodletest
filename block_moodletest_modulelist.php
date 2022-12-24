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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file contains the moodletest modulelist block.
 *
 * @package    block_moodletest_modulelist
 * @copyright  2022 onwards Rishabh
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/filelib.php');

class block_moodletest_modulelist extends block_list {
    public function init() {
        $this->title = get_string('pluginname', 'block_moodletest_modulelist');
    }

    public function get_content() {
        global $CFG, $DB, $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $course = $this->page->course;
        $modinfo = get_fast_modinfo($course);

        foreach ($modinfo->cms as $cm) {
            if (!$cm->uservisible || !$cm->has_view()) {
                continue;
            }
            $queryparams = array('coursemoduleid' => $cm->id, 'userid' => $USER->id);
            $compdata = $DB->get_record_sql("select completionstate from
            {course_modules_completion} where coursemoduleid = $cm->id and userid = $USER->id");
            if ($compdata->completionstate != '') {
                $status = "Completed";
            } else {
                $status = " ";
            }
            $date = date('d-M-Y', $cm->added);
            $anchor = "<a href='$CFG->wwwroot/mod/$cm->modname/view.php?id=$cm->id'> $cm->id - $cm->name - $date $status</a>";
            $this->content->items[] = $anchor;
        }
        return $this->content;
    }
    public function applicable_formats() {
        return array('course-view' => true);
    }
}


