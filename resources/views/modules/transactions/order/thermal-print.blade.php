<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=58mm, initial-scale=1">
    <title>Print Receipt</title>
    <style>
        @page {
            size: 58mm 210mm;
            margin: 0;
        }
        body {
            width: 58mm;
            height: 210mm; /* Set the exact height of the receipt page */
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            box-sizing: border-box; /* Ensure padding and margin are accounted for */
        }
        .receipt {
            flex-grow: 1;
            padding: 5px;
            text-align: center;
            overflow: hidden; /* Prevent overflow beyond the page */
        }
        .receipt h2 {
            margin: 0;
            font-size: 14px;
        }
        .receipt p {
            margin: 5px 0;
        }
        .line {
            border-top: 1px dashed black;
            margin: 5px 0;
        }
        .content {
            text-align: left;
        }
        /* Adjust the content section to fit more neatly */
        .content p {
            margin: 3px 0;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <h2>Store Name</h2>
        <p>Address Line 1</p>
        <p>Address Line 2</p>
        <p>Date: <span id="date"></span></p>
        <div class="line"></div>
        <div class="content">
            <p>Item 1  x1  ......... $10.00</p>
            <p>Item 2  x2  ......... $20.00</p>
            <div class="line"></div>
            <p><strong>Total: $30.00</strong></p>
        </div>
        <div class="line"></div>
        <p>Thank You!</p>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#date').text(new Date().toLocaleString());
            window.print();
        });
    </script>
</body>
</html>
