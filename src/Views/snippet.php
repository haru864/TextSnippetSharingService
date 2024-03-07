<?php

use Settings\Settings;

$baseURL = Settings::env("BASE_URL");
?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Text Snippet Sharing Service</title>
    <link rel="stylesheet" type="text/css" href="<?= $baseURL ?>/css/snippet" />
</head>

<body>
    <div>
        Language: <?php echo $language; ?>
    </div>
    <div class="container">
        <div id="editor" style="width:800px;height:600px;border:1px solid grey"></div>
    </div>
    <button type=“button” onclick="location.href='<?= $baseURL ?>'">ホーム</button>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs/loader.min.js"></script>
    <script>
        const SNIPPET = `<?= $snippet ?>`;
        const LANGUAGE = '<?= $language ?>';
    </script>
    <script src="<?= $baseURL ?>/js/snippet"></script>
</body>

</html>