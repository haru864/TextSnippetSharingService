require.config({
    paths: {
        'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs'
    }
});
require(['vs/editor/editor.main'], function () {
    window.editor = monaco.editor.create(document.getElementById('editor'), {
        value: '',
        language: 'cpp'
    });
});
document.getElementById('language').addEventListener('change', function () {
    let language = this.value;
    let editor_model = window.editor.getModel();
    monaco.editor.setModelLanguage(editor_model, language);
});
document.getElementById("submit-btn").addEventListener("click", async function () {
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
        const response = await fetch(BASE_URL, {
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
