<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
  header("Location: login.php");
  exit();
}

$file = $_GET['file'] ?? '';
$cleanPath = htmlspecialchars($file);


$fullPath = __DIR__ . '/../' . $cleanPath;
if (!file_exists($fullPath)) {
    exit('File not found');
}

$pdfUrl = 'serve_file.php?file=' . urlencode($cleanPath);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Secure PDF Viewer</title>
  <style>
  body {
  margin: 0;
  background-color: #f4f4f4;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  min-height: 100vh;
}

#pdf-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
}

canvas {
  border: 1px solid #ccc;
  margin: 10px 0;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
  </style>
</head>
<body>
  <div id="pdf-container"></div>

  <script type="module">
    import * as pdfjsLib from '../js/pdfjs/build/pdf.mjs';

    pdfjsLib.GlobalWorkerOptions.workerSrc = '../js/pdfjs/build/pdf.worker.mjs';


    const url = '<?php echo $pdfUrl; ?>';

    const loadingTask = pdfjsLib.getDocument(url);
    loadingTask.promise.then(pdf => {
      const container = document.getElementById('pdf-container');

      for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
        pdf.getPage(pageNum).then(page => {
          const viewport = page.getViewport({ scale: 1.5 });
          const canvas = document.createElement('canvas');
          container.appendChild(canvas);
          canvas.width = viewport.width;
          canvas.height = viewport.height;

          const renderContext = {
            canvasContext: canvas.getContext('2d'),
            viewport: viewport
          };
          page.render(renderContext);
        });
      }
    }).catch(err => console.error(err));
  </script>
</body>
</html>
