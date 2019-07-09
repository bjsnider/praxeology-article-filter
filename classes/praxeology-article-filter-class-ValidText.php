<?php
declare(strict_types=1);
namespace Praxeology;

/**
 * Shows the validation result message, compatible with Bootstrap.
 */
class ValidText {
    
    /** @var string|null $text The pasted text to be filtered. */
    protected $text = '';
    
    public function __construct() {
        
    }
    
    /**
     * Set the message.
     *
     * Sets the validation message for use by Bootstrap's validation
     * system.
     * 
     * @param bool $valid The result of the validation test.
     *
     * @return string
     */
    public function result(bool $valid) {
        $this->text = ($valid === false) ? ' is-invalid' : '';
    }
    
    /**
     * Prints the text.
     * 
     * @param string $text The text of the validation message.
     *
     * @return void
     */
    public function show() {
        print $this->text;
    }
}