<?php
declare(strict_types=1);
namespace Praxeology;

/**
 * Tests the input string for appropriate character length.
 */
class Validate {
    
    public function __construct() {
    }
    
    /**
     * Validate the text.
     *
     * Looks for greater than zero but less than 40k characters. The latter
     * value may need to be increased.
     * 
     * @param string $text The text being validated, such as an article or paragraph.
     *
     * @return bool
     */
    public function text(string $text) {
        if (!empty($text)) {
                if (strlen($text) < 40000) {
                return true;
            }
        }
        return false;
    }
}