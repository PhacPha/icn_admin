<?php
// กำหนด path ของโฟลเดอร์เก็บรูปภาพ
define('IMAGE_UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/iconnex_thailand_db_backup/img/');
define('IMAGE_UPLOAD_PATH', '/iconnex_thailand_db_backup/img/');

// ตรวจสอบและสร้างโฟลเดอร์ img หากยังไม่มี
if (!file_exists(IMAGE_UPLOAD_DIR)) {
    mkdir(IMAGE_UPLOAD_DIR, 0777, true);
}