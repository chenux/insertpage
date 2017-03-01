<?php

defined('MOODLE_INTERNAL') || die();

/* Filtro insertar página */

class filter_insertpage extends moodle_text_filter {

    function filter($text, array $options = array()) {

        global $CFG, $COURSE, $DB;

        if (!preg_match('/\[page/i',$text)) { //added one more tag (dlnsk)
            return $text;
        }

        preg_match_all('/\[page\](.+?)\[\/page\]/i', $text, $matches, PREG_SET_ORDER);

#        return $text . print_r($matches, true);
        
        foreach ($matches as $insertpage) {

            $page = $DB->get_record("page", array("name" => trim($insertpage[1])));
            
            if (isset($page->content)) {
                if (strpos ($text, '<p>' . $insertpage[0] . '</p>')) {
                        $search = '<p>' . $insertpage[0] . '</p>';
                } else {
                        $search = $insertpage[0];
                }
                $text = str_replace($search, $page->content , $text);
            }

        }
        
        return $text;

    }
}
