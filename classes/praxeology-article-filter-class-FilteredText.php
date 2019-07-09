<?php
declare(strict_types=1);
namespace Praxeology;

/**
 * Displays the filtered text.
 */
class FilteredText {
    
    /** @var string|null $text The pasted text to be filtered. */
    protected $text = '';
    
    public function __construct() {
        
    }
    
    /**
     * Inject the text.
     * 
     * @param string $text The text being filtered, such as an article or paragraph.
     *
     * @return void
     */
    public function input(string $text) {
        $this->text = $text;
    }
    
    /**
     * Prints the text.
     * 
     * @param string $text The text being filtered, such as an article or paragraph.
     *
     * @return void
     */
    public function show() {
        print $this->text;
    }
}