tinymce.init({
    selector: '#content',
    plugins: "paste",
    paste_as_text: true,
    width: 600,
    height: 300,
    plugins: [
      'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
      'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
      'media', 'table', 'emoticons', 'template', 'help'
    ],
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
      'forecolor backcolor emoticons | help',
      
    menubar: 'favs file edit view insert format tools table help',
    content_css: 'css/content.css'
  });

