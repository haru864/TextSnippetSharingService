<?php

use Settings\Settings;

$baseURL = Settings::env('BASE_URL');
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
        programming language:
        <select id="language" required>
            <?php foreach ($languages as $language) { ?>
                <option value="<?= $language ?>"><?= $language ?></option>
            <?php } ?>
        </select>
    </div>
    <div>
        effective date:
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
        require.config({
            paths: {
                'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs'
            }
        });
        require(['vs/editor/editor.main'], function() {
            window.editor = monaco.editor.create(document.getElementById('editor'), {
                value: '',
                language: 'cpp'
            });
        });
        document.getElementById('language').addEventListener('change', function() {
            let language = this.value;
            let editor_model = window.editor.getModel();
            monaco.editor.setModelLanguage(editor_model, language);
        });
        document.getElementById("submit-btn").addEventListener("click", async function() {
            try {
                var details = {
                    'snippet': window.editor.getValue(),
                    'language': document.getElementById('language').value,
                    'term_minute': document.getElementById('term_minute').value
                };
                var formBody = [];
                for (var property in details) {
                    var encodedKey = encodeURIComponent(property);
                    var encodedValue = encodeURIComponent(details[property]);
                    formBody.push(encodedKey + "=" + encodedValue);
                }
                formBody = formBody.join("&");
                const response = await fetch('<?= $baseURL ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: formBody
                });
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const url = await response.text();
                alert(url);
            } catch (error) {
                console.error('Error:', error);
                alert(`Error: ${error}`);
            }
        });
    </script>
</body>

</html>