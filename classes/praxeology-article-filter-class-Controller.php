<?php
declare(strict_types=1);
namespace Praxeology;

/**
 * Runs the validation and filtration classes on the text provided through
 * the form. Returns the filtered text.
 */
class Controller {
    
    /** @var string|null $text The pasted text to be filtered. */
    protected $text = '';
    
    /**
     * Inject the text.
     *
     * Also runs the load method, which includes the classes used by the
     * controller.
     * 
     * @param string $text The text being filtered, such as an article or paragraph.
     *
     * @return void
     */
    public function __construct(string $text) {
        $this->text = $text;
        $this->load();
    }
    
    /**
     * Load the classes.
     *
     * @return void
     */
    private function load() {
        $classes = ['Validate', 'Filter'];
        foreach ($classes as $class) {
            include_once __DIR__ . '/praxeology-article-filter-class-' . $class . '.php';
        }
    }
    
    /**
     * Validate the text.
     *
     * Instantiate the validation class and check the text.
     *
     * @return string
     */
    public function validArticle() {
        $validate = new Validate();
        return $validate->text($this->text);
    }
    
    /**
     * Filter the text.
     *
     * Instantiates the filter class and uses it to filter the
     * text. Also passes the markup parameter, which tells the
     * filter class if there was markup in the text.
     * 
     * @param bool $markup The presence of HTML markup in the text.
     *
     * @return string
     */
    public function filter(bool $markup = false) {
        $filter = new Filter();
        return $filter->text($this->text, $markup);
    }
}