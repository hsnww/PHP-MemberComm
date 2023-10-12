<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/userHead.php'; ?>
<?php
require $_SERVER['DOCUMENT_ROOT'].'/eshopStores/vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;
// معالجة الصورة .. البداية
$userId = $_POST['user']; // قم بتحديث هذا بناءً على كيفية حفظ معرف المستخدم في الجلسة

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = Image::make($_FILES['image']['tmp_name']);

        $width = 120;
        $height = 120;

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

        $outputPath = $_SERVER['DOCUMENT_ROOT'].'/eshopStores/src/avatars/'.$filename;
        $image->save($outputPath);

    } else {
        echo "Error uploading the image.";
    }
}
// معالجة الصورة .. النهاية

if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {

    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $avatar = $filename;
    $phone = $_POST['phone'];
    $job = $_POST['job'];
    $address = $_POST['address'];
    $company = $_POST['company'];
    $country = $_POST['country'];
    $website = $_POST['website'];
    $twitter = $_POST['twitter'];
    $facebook = $_POST['facebook'];
    $instagram = $_POST['instagram'];
    $linkedin = $_POST['linkedin'];
    $bio = $_POST['bio'];

    $stmt = $conn->prepare("UPDATE profiles SET 
            first_name = ?, 
            last_name = ?, 
            avatar = ?, 
            phone = ?, 
            job = ?, 
            address = ?, 
            company = ?, 
            country = ?, 
            website = ?, 
            twitter = ?, 
            facebook = ?, 
            instagram = ?, 
            linkedin = ?, 
            bio = ? 
        WHERE user_id = ?");

    $stmt->bind_param('ssssssssssssssi', $firstName, $lastName, $avatar, $phone, $job, $address, $company, $country, $website, $twitter, $facebook, $instagram, $linkedin, $bio, $userId);

    if ($stmt->execute()) {
        $_SESSION['message'] = "تم تحديث الملف الشخصي بنجاح!";
        $_SESSION['bg'] = "success";
    } else {
        $_SESSION['message'] = "حدث خطأ أثناء تحديث الملف الشخصي.";
        $_SESSION['bg'] = "danger";

    }


    header('Location: inbox.php');
    exit();
} else {
    die("رمز CSRF غير صالح.");

}
?>