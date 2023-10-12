<?php
function getFileIcon($file_extension) {
    switch ($file_extension) {
        case 'pdf':
            return '<i class="fas fa-file-pdf fa-2x text-danger"></i>'; // حجم 2x ولون خطر (أحمر)
        case 'doc':
        case 'docx':
            return '<i class="fas fa-file-word fa-2x text-primary"></i>'; // حجم 2x ولون معلومات (أزرق)
        case 'xlsx':
        case 'xls':
            return '<i class="fas fa-file-excel fa-2x text-success"></i>'; // حجم 2x ولون نجاح (أخضر)
        case 'txt':
            return '<i class="fas fa-file-alt fa-2x text-secondary"></i>';  // حجم 2x ولون افتراضي
        case 'zip':
        case 'rar':
            return '<i class="fas fa-file-archive fa-2x text-warning"></i>'; // حجم 2x ولون تحذير (برتقالي)
        default:
            return '<i class="fas fa-file fa-2x"></i>';  // حجم 2x ولون افتراضي
    }
}

//دالة لتحويل حجم الملف من بايت الى كيلوبايت \ ميقابايت \ جيجابايت \ تيرابايت حسب حجم الملف
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}


?>
