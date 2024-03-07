<?php

use Database\DatabaseHelper;
use Logging\Logger;
use Settings\Settings;

try {
    date_default_timezone_set(Settings::env("TIMEZONE"));
    $logger = Logger::getInstance();
    $logger->logInfo('バッチ処理開始: 期限切れレコードの削除処理を開始します。');
    DatabaseHelper::deleteExpiredSnippets();
    $logger->logInfo('バッチ処理終了: 期限切れレコードの削除処理が正常に完了しました。');
} catch (Throwable $t) {
    $logger->logInfo('エラー終了: 期限切れレコードの削除処理中にエラーが発生しました。');
    $logger->logError($t);
}
