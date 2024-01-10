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
        <select id="language" required>
            <option value="cpp" selected>cpp</option>
            <option value="csharp">csharp</option>
            <option value="dart">dart</option>
            <option value="go">go</option>
            <option value="java">java</option>
            <option value="javascript">javascript</option>
            <option value="kotlin">kotlin</option>
            <option value="objective-c">objective-c</option>
            <option value="perl">perl</option>
            <option value="php">php</option>
            <option value="python">python</option>
            <option value="r">r</option>
            <option value="ruby">ruby</option>
            <option value="rust">rust</option>
            <option value="scala">scala</option>
            <option value="swift">swift</option>
            <option value="typescript">typescript</option>
        </select>
    </div>
    <div class="container">
        <div id="editor" style="width:800px;height:600px;border:1px solid grey"></div>
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
                    'language': document.getElementById('language').value
                };
                var formBody = [];
                for (var property in details) {
                    var encodedKey = encodeURIComponent(property);
                    var encodedValue = encodeURIComponent(details[property]);
                    formBody.push(encodedKey + "=" + encodedValue);
                }
                formBody = formBody.join("&");
                const response = await fetch('http://localhost:8000/TextSnippetSharingService/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: formBody
                });
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                alert(data['url']);
            } catch (error) {
                console.error('Error:', error);
                alert(`Error: ${error}`);
            }
        });
    </script>
</body>

</html>