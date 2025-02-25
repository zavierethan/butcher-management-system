<!DOCTYPE html>
<html>
<head>
    <title>Advanced ESC/POS Printing from Javascript</title>
    <meta charset="utf-8" />
    <script src="https://cdn.jsdelivr.net/npm/qz-tray/qz-tray.js"></script>
</head>
<body>
<h2>Print Thermal Receipt</h2>

<script>
    // ✅ Load the certificate
    // qz.security.setCertificatePromise((resolve, reject) => {
    //     fetch('/qz-tray.crt')
    //         .then(response => response.text())
    //         .then(resolve)
    //         .catch(reject);
    // });

    // // ✅ Secure signing via Laravel API
    // qz.security.setSignaturePromise(toSign => {
    //     return fetch('/sign-message', {
    //         method: 'POST',
    //         headers: { 'Content-Type': 'application/json' },
    //         body: JSON.stringify({ request: toSign })
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.signature) {
    //             return data.signature;
    //         } else {
    //             throw new Error("Failed to sign request");
    //         }
    //     });
    // });

    // ✅ List all available printers
    function listPrinters() {
        if (!qz.websocket.isActive()) {
            qz.websocket.connect()
                .then(() => getPrinters())
                .catch(err => console.error("QZ Tray connection failed:", err));
        } else {
            getPrinters();
        }
    }

    function getPrinters() {
        qz.printers.find()
            .then(printers => {
                let printerList = document.getElementById("printerList");
                printerList.innerHTML = ""; // Clear previous list

                printers.forEach(printer => {
                    let li = document.createElement("li");
                    li.textContent = printer;
                    printerList.appendChild(li);
                });
            })
            .catch(err => console.error("Error listing printers:", err));
    }

    // ✅ Print receipt to POS-58 thermal printer
    function printReceipt() {
        if (!qz.websocket.isActive()) {
            qz.websocket.connect()
                .then(() => sendPrintCommand("POS-58 (copy 1)")) // Adjust printer name
                .catch(err => console.error("QZ Tray connection failed:", err));
        } else {
            sendPrintCommand("POS-58 (copy 1)");
        }
    }

    function sendPrintCommand(printerName) {
        qz.printers.find(printerName)
            .then(printer => {
                let config = qz.configs.create(printer);

                let data = [
                    '\x1B\x40', // Initialize printer
                    '\x1B\x61\x31', // Center align
                    '\x1B\x21\x10', // Double height
                    'Priyadis Butchers\n',
                    '\x1B\x21\x00', // Reset to normal text
                    'Jl. Ciledug No.273\n',
                    'Telp: 08991848066\n',
                    '\n',
                    '\x1B\x61\x30', // Left align
                    '--------------------------------\n',
                    'No Transaksi  : P120250200060\n',
                    'Tanggal       : 17/02/2025\n',
                    'Kasir         : user1\n',
                    '--------------------------------\n',
                    'KARKAS                          \n',
                    '3.00 X 29,000 (Discount 500)    \n',
                    '\x1B\x61\x32',
                    '85,500\n',
                    '--------------------------------\n',
                    '\x1B\x61\x32',
                    'Total  57,000\n',
                    'Bayar (Cash)  0\n',
                    'Kembali  0\n',
                    '--------------------------------\n',
                    '\n\n\n',
                    '\x1D\x56\x41', // Cut paper (depends on printer)
                ];

                return qz.print(config, data);
            })
            .then(() => console.log("Print successful"))
            .catch(err => console.error("Print failed:", err));
    }

    // Auto-connect QZ Tray
    qz.websocket.connect().catch(err => console.error("QZ Tray not running:", err));
</script>

<button onclick="printReceipt()">Print Receipt</button>
<ul id="printerList"></ul>


</body>
</html>
