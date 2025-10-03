<?php

// QR Code Generator for FIO Bank Czech Payment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vs = isset($_POST['vs']) ? $_POST['vs'] : '';
    $ks = isset($_POST['ks']) ? $_POST['ks'] : '';
    $ss = isset($_POST['ss']) ? $_POST['ss'] : '';
    $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : 'Test payment';

    // Generate QR payment string (Short Payment Descriptor - SPD format)
    $qrString = generateQRPaymentString($amount, $vs, $ks, $ss, $message);
}

function generateQRPaymentString($amount, $vs, $ks, $ss, $message) {
    $iban = "CZ5855000000001234567899"; // FIO IBAN

    // Remove currency symbol and convert to number
    $amount = preg_replace('/[^0-9.]/', '', $amount);

    // Build SPD (Short Payment Descriptor) string for Czech QR payments
    $qrData = "SPD*1.0*";
    $qrData .= "ACC:" . $iban . "*";
    $qrData .= "AM:" . $amount . "*";
    $qrData .= "CC:CZK*";
    $qrData .= "MSG:" . $message . "*";

    if (!empty($vs)) {
        $qrData .= "X-VS:" . $vs . "*";
    }
    if (!empty($ks)) {
        $qrData .= "X-KS:" . $ks . "*";
    }
    if (!empty($ss)) {
        $qrData .= "X-SS:" . $ss . "*";
    }

    return $qrData;
}

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIO Bank QR Payment Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0052a3;
        }
        .qr-container {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .qr-container img {
            max-width: 300px;
            height: auto;
        }
        .info {
            background-color: #e7f3ff;
            padding: 15px;
            border-left: 4px solid #0066cc;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>FIO Bank - QR Platba</h1>

    <form method="POST" action="">
        <div class="form-group">
            <label for="vs">Variabilní symbol (VS):</label>
            <input type="text" id="vs" name="vs"
                   value="<?php echo isset($_POST['vs']) ? htmlspecialchars($_POST['vs']) : '606453348'; ?>"
                   placeholder="606453348">
        </div>

        <div class="form-group">
            <label for="ss">Specifický symbol (SS):</label>
            <input type="text" id="ss" name="ss"
                   value="<?php echo isset($_POST['ss']) ? htmlspecialchars($_POST['ss']) : '5052621117'; ?>"
                   placeholder="5052621117">
        </div>

        <div class="form-group">
            <label for="amount">Částka (Kč):</label>
            <input type="text" id="amount" name="amount"
                   value="<?php echo isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : '12690'; ?>"
                   placeholder="12690" required>
        </div>

        <button type="submit">Generovat QR kód</button>
    </form>

    <?php if (isset($qrString)): ?>
        <div class="qr-container">
            <h3>Váš QR kód:</h3>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?php echo urlencode($qrString); ?>"
                 alt="QR Code">
            <p style="margin-top: 15px; color: #666; font-size: 14px;">
                Naskenujte tento QR kód v mobilní aplikaci vaší banky
            </p>
        </div>
    <?php endif; ?>

    <div class="info">
        <strong>ℹ️ Informace:</strong><br>
        Tento QR kód lze naskenovat v mobilních aplikacích bank a provést platbu automaticky s předvyplněnými údaji.
    </div>

    <div class="info">
        <strong>ℹ️ debug:</strong><br>
        <code>https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?php echo urlencode($qrString); ?></code>
    </div>
</div>
</body>
</html>