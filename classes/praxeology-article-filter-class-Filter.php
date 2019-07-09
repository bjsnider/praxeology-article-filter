<?php
declare(strict_types=1);
namespace Praxeology;

/**
 * Filters the input text to create a version with safe, named html entities.
 * Also removes leading and trailing whitespace.
 */
class Filter {
    
    public function __construct() {
        
    }
    
    /**
     * Filter the text.
     *
     * Filters the text through trim and the translation tables used by htmlentites().
     * Runs the latter function twice to also create an entity for the ampersand.
     * Otherwise it's impossible to copy the entity. The browser always converts it
     * to its character. Checks for HTML tags and encodes them once only. Encodes
     * quotes once only. Finally, it replaces the instances of newline characters
     * with HTML break tags.
     * 
     * @param string $text The text being filtered, such as an article or paragraph.
     *
     * @return string
     */
    public function text(string $text) {
        $htmlEntitiesQuotes = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES | ENT_HTML5, "UTF-8");
        $htmlEntitiesNoQuotes = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES | ENT_HTML5, "UTF-8");
        unset($htmlEntitiesQuotes['='], $htmlEntitiesQuotes[':'], $htmlEntitiesQuotes['/'], $htmlEntitiesQuotes[PHP_EOL],
              $htmlEntitiesNoQuotes['='], $htmlEntitiesNoQuotes[':'], $htmlEntitiesNoQuotes['/'], $htmlEntitiesNoQuotes[PHP_EOL]);
        $text = trim(strtr($text, $htmlEntitiesQuotes));
        $text = preg_replace("/=/", "=\"\"", $text);
        $text = preg_replace("/&quot;/", "&quot;\"", $text);
        $tags = "/&lt;(\/|)(\w*)(\ |)(\w*)([\\\=]*)(?|(\")\"&quot;\"|)(?|(.*)?&quot;(\")|)([\ ]?)(\/|)&gt;/i";
        $replacement = "<$1$2$3$4$5$6$7$8$9$10>";
        $text = preg_replace($tags, $replacement, $text);
        $text = preg_replace(["/=\"\"/", "/&quot;\"/"], ["=", "&quot;"], $text);
        $text = strtr($text, $htmlEntitiesNoQuotes);
        $text = preg_replace("/&amp;quot&semi;/", "&quot;", $text);
        $filtered = nl2br($text, false);
        return $filtered;
    }
}