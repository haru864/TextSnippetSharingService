<?php

use Settings\Settings;

$baseURL = Settings::env("BASE_URL");
?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Text Snippet Sharing Service</title>
    <style>
        .container {
            display: flex;
            align-items: center;
        }

        .container>div,
        .buttons>button {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div>
        language: <?php echo $language; ?>
    </div>
    <div class="container">
        <div id="editor" style="width:800px;height:600px;border:1px solid grey"></div>
    </div>
    <button type=“button” onclick="location.href='<?= $baseURL ?>'">ホーム</button>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs/loader.min.js"></script>
    <script>
        require.config({
            paths: {
                'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs'
            }
        });
        require(['vs/editor/editor.main'], function() {
            window.editor = monaco.editor.create(document.getElementById('editor'), {
                value: <?php echo json_encode($snippet); ?>,
                language: '<?php echo $language; ?>'
            });
        });
    </script>
</body>

</html>