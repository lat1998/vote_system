<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Results Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #0066cc;
            border-bottom: 3px solid #0066cc;
            padding-bottom: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        .report-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #0066cc;
        }
        .info-item strong {
            display: block;
            color: #0066cc;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        th {
            background-color: #0066cc;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .rank {
            font-weight: bold;
            color: #0066cc;
        }
        .votes-badge {
            display: inline-block;
            background-color: #0066cc;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
        }
        .progress-container {
            background-color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            height: 30px;
            position: relative;
        }
        .progress-bar {
            background: linear-gradient(90deg, #0066cc, #004999);
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 10px;
            color: white;
            font-weight: bold;
            font-size: 12px;
            min-width: 40px;
        }
        .winner {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            text-align: right;
            color: #666;
            font-size: 12px;
        }
        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        .summary-box {
            background: linear-gradient(135deg, #0066cc, #004999);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .summary-box h3 {
            font-size: 28px;
            margin: 10px 0;
        }
        .summary-box p {
            font-size: 14px;
            opacity: 0.9;
        }
        @media print {
            body {
                background-color: white;
            }
            .container {
                box-shadow: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        {!! $html !!}
    </div>
</body>
</html>
