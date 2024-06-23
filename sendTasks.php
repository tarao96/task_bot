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
    $jsonFile = 'tasks.json';
    if (!file_exists($jsonFile)) {
        return ['タスクが見つかりませんでした。'];
    }

    $jsonData = file_get_contents($jsonFile);
    $tasksData = json_decode($jsonData, true);

    $today = date('Y-m-d');
    return $tasksData[$today] ?? ['今日のタスクは設定されていません。'];
}

function getRandomEncouragement()
{
    $messages = [
        '今日も素晴らしい一日になりますように！💪',
        'がんばってください！✨',
        'あなたならできる！🔥',
        '応援しています！💖',
        '全力で行こう！🚀',
        '自信を持って取り組んでください！👍',
        '笑顔で頑張りましょう！😊',
        '素敵な一日をお過ごしください！🌈',
        'あなたの努力が報われますように！💪',
        '今日も最高の日にしましょう！🌟'
    ];
    return $messages[array_rand($messages)];
}

$tasks = getTodayTasks();
$encouragement = getRandomEncouragement();
$message = "おはようございます！🌞\n今日も素敵な一日になりますように！\n\n今日のタスクは次の通りです：\n" . implode("\n", $tasks) . "\n\n" . $encouragement;

sendLineMessage($message);
