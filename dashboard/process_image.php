<?php
require '../vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = Image::make($_FILES['image']['tmp_name']);

        $width = 100;
        $height = 100;

        if ($width || $height) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        // ملف مؤقت
        $file = $_FILES['image']['tmp_name'];

        // احصل على امتداد الملف
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        // أنشئ اسمًا فريدًا للملف
        $filename = uniqid() . '.' . $ext;

        $outputPath = 'src/'.$filename;
        $image->save($outputPath);

        echo "Image uploaded and resized successfully!";
        echo "<br><img src='$outputPath'>";
    } else {
        echo "Error uploading the image.";
    }
}
?>
