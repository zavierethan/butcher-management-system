<!DOCTYPE html>
<html>
<head>
    <title>Advanced ESC/POS Printing from Javascript</title>
    <meta charset="utf-8" />
</head>
<body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qz-tray/2.1.0/qz-tray.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof qz === "undefined") {
        alert("QZ Tray is not loaded. Please check the script source.");
    } else {
        console.log("QZ Tray is loaded successfully.");
    }
});
async function printReceipt() {
    try {
        await qz.websocket.connect(); // Connect to QZ Tray
        const printer = await qz.printers.find(); // Get the default printer

        const config = qz.configs.create(printer);
        const data = [
            "\x1B\x40",  // ESC/POS Initialize
            "Hello, from Laravel!\n",
            "\x1B\x64\x02", // Feed 2 lines
            "\x1D\x56\x01"  // Cut paper
        ];

        await qz.print(config, data);
        alert("Print sent to " + printer);
    } catch (err) {
        console.error(err);
        alert("Failed to print: " + err.message);
    }
}
</script>

<button onclick="printReceipt()">Print Receipt</button>

</body>
</html>
