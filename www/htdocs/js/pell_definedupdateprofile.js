document.addEventListener("DOMContentLoaded", function () {

  var editor = window.pell.init({
    element: document.getElementById('editor'),
    defaultParagraphSeparator: 'p',
    actions: [
      'bold',
      'italic',
      'underline',
      'olist',
      'ulist',
      'link',
    ],
    onChange: html => {
      document.getElementById('campaign-html').value = html;
    }
  });

  var preload = <?= json_encode($rmbcandidate["Statement"] ?? "") ?>;

  if (preload) {
    editor.content.innerHTML = preload;
    document.getElementById('campaign-html').value = preload;
  }

});
