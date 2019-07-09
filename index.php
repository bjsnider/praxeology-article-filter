<?php
declare(strict_types=1);
namespace Praxeology;

include_once __DIR__ . '/classes/praxeology-article-filter-class-Controller.php';
include_once __DIR__ . '/classes/praxeology-article-filter-class-FilteredText.php';
include_once __DIR__ . '/classes/praxeology-article-filter-class-ValidText.php';
$validText = new ValidText();
$filteredText = new FilteredText();
$unfilteredText = '';
if (isset($_POST['articleText'])) {
    $controller = new Controller($_POST['articleText']);
    $unfilteredText = $_POST['articleText'];
    $valid = $controller->validArticle();
    // Show the user if the text input was valid.
    $validText->result($valid);
    // Filter the text.
    if ($valid) {
            $filteredText->input($controller->filter());
    }
}

// Temporary, for testing purposes
$version = phpversion();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <title>HTML Entities Filter</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>
    <style>
        .btn-clipboard {
            position: absolute;
            top: .5rem;
            right: .5rem;
            z-index: 10;
            display: block;
            padding: .25rem .5rem;
            font-size: 75%;
            color: #818a91;
            background-color: transparent;
            border: 0;
            border-radius: .25rem;
        }
            
        .btn-clipboard:hover {
            color: white;
            background-color: #027de7;
        }
    </style>
  </head>
  <body class="container">
    <header class="row justify-content-center my-2">
        <h2 class="col text-center">Praxeology.net Article Filter</h2>
    </header>
    <div class="row">
        <p class="col">This webapp will filter text and substitute appropriate characters with
        named HTML Entities. It will double or single encode characters depending on whether HTML
        markup is involved. It's therefore safe to paste articles containing HTML markup.</p>
        <p class="col-12 test">Current PHP version: <?php print $version; ?></p>
    </div>
    <div class="row">
        <div class="col">
            <form method="post">
                <div class="form-group">
                  <label for="articleText">Article Text</label>
                  <textarea class="form-control<?php $validText->show();?>"
                            id="articleText" name="articleText" rows="10" cols="35" placeholder="Paste the article here..."><?php echo $unfilteredText; ?></textarea>
                  <div class="invalid-feedback">
                    Either there is no text at all, or the pasted text is longer than 40,000 characters.
                  </div>
                </div>
                <div class="row no-gutters my-2">
                    <div class="col-auto"><button id="resetButton" type="reset" class="btn btn-warning">Reset</button></div>
                    <div class="col-auto ml-auto">
                        <button type="submit" class="btn btn-primary">Submit</button></div>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="row mt-5">
            <h4 class="col-12 text-center">Result</h4>
            <div class="col-auto ml-auto"><button class="btn-sm btn-clipboard clippy" data-clipboard-target="#result">
                Copy
            </button></div>
            <div class="col-12"><button id="resetFilteredButton" type="reset" class="btn btn-sm btn-warning">Reset</button></div>
            <code><p id="result" class="result col-12 mt-3"><?php $filteredText->show();?></p></code>
    </div>

    <!-- Instantiate clipboard by passing a string selector -->
    <script>
        var clipboard = new ClipboardJS('.clippy');
        clipboard.on('success', function(e) {
            console.log(e);
        });
        clipboard.on('error', function(e) {
            console.log(e);
        });
        </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        var resetButton = false;
        function clearText(event) {
            event.preventDefault();
            
            var articleText = document.getElementById('articleText');
            articleText.value = '';
        }
        
        resetButton = document.getElementById('resetButton');
        if (resetButton) {
            resetButton.addEventListener("click", clearText);
        }
        var resetFilteredButton = false;
        function clearFilteredText(event) {
            event.preventDefault();
            
            var filteredText = document.getElementById('result');
            filteredText.innerText = '';
            console.log(filteredText);
        }
        
        resetFilteredButton = document.getElementById('resetFilteredButton');
        if (resetFilteredButton) {
            resetFilteredButton.addEventListener("click", clearFilteredText);
        }
    </script>
  </body>
</html>
