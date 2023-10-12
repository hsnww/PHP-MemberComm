<?php
session_start(); // بدء الجلسة

// تدمير كل المعلومات المرتبطة بالجلسة الحالية
session_destroy();

// إعادة توجيه المستخدم إلى صفحة تسجيل الدخول
header("Location: login.php");
exit();
?>
