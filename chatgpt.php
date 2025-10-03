<?php
// === Payment data (QR Platba format) ===
$iban = "CZ5855000000001234567899"; // FIO IBAN
$amount = "100.00"; // CZK
$message = "Test payment";
$vs = "12345678"; // Variable symbol
$ks = "0308";     // Constant symbol
$ss = "987654";   // Specific symbol
$dueDate = "2025-10-10"; // Due date

// Build QR Platba string with additional parameters
$qrString = "SPD*1.0*ACC:$iban*AM:$amount*CC:CZK*MSG:$message*VS:$vs*KS:$ks*SS:$ss*DT:$dueDate";

// Encode for URL
$qrUrl = "https://quickchart.io/qr?text=" . urlencode($qrString) . "&size=300";
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>QR Platba</title>
</head>
<body>
<h1>QR Platba – Test</h1>
<p>Naskenujte tento QR kód pro platbu:</p>
<img src="<?= $qrUrl ?>" alt="QR Platba" />
</body>
</html>
