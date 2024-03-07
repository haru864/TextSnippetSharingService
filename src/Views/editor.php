<?php

use Settings\Settings;

$baseURL = Settings::env('BASE_URL');
?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Text Snippet Sharing Service</title>
    <link rel="stylesheet" type="text/css" href="<?= $baseURL ?>/css/editor" />
</head>

<body>
    <div>
        Language:
        <select id="language" required>
            <?php foreach ($languages as $language) { ?>
                <option value="<?= $language ?>"><?= $language ?></option>
            <?php } ?>
        </select>
    </div>
    <div>
        Effective Time:
        <select id="term_minute" required>
            <option value="10" selected>10 minutes</option>
            <option value="60">1 hours</option>
            <option value="1440">1 day</option>
        </select>
    </div>
    <div class="container">
        <div id="editor" style="width:800px; height:600px; border:1px solid grey;"></div>
    </div>
    <button type="button" id="submit-btn">Submit</button>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs/loader.min.js"></script>
    <script>
        const BASE_URL = '<?= $baseURL ?>';
    </script>
    <script src="<?= $baseURL ?>/js/editor"></script>
</body>

</html>