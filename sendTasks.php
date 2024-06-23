<?php

function sendLineMessage($message)
{
    $accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');
    $userId = getenv('USER_ID_TO_SEND_MESSAGE');

    $url = 'https://api.line.me/v2/bot/message/push';
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    ];

    $postData = [
        'to' => $userId,
        'messages' => [
            [
                'type' => 'text',
                'text' => $message
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function getTodayTasks()
{
    // ここでその日のタスクを取得するロジックを実装します
    // 例として静的なタスクリストを返す
    return [
        '朝のミーティング',
        'プロジェクト作業',
        'レポート作成'
    ];
}

$tasks = getTodayTasks();
$message = "おはようございます！🌞\n今日も素敵な一日になりますように！\n\n今日のタスクは次の通りです：\n" . implode("\n", $tasks) . "\n\nがんばってください！💪";

sendLineMessage($message);
