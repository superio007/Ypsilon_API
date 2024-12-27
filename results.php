<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search Results</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .flight-result {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .price {
            font-size: 24px;
            font-weight: bold;
        }

        .flight-info {
            font-size: 16px;
        }

        .flight-info span {
            display: block;
        }

        .book-button {
            background-color: #f0ad4e;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .book-button:hover {
            background-color: #ec971f;
            color: #fff;
        }

        .available-seats {
            color: green;
            font-weight: bold;
        }

        .price-breakdown {
            color: blue;
            cursor: pointer;
        }

        .table-responsive {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Outbound</th>
                        <th>Outbound</th>
                        <th>Outbound</th>
                        <th>Outbound</th>
                        <th>Outbound</th>
                        <th>Outbound</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sun, 02.08</td>
                        <td>Mon, 03.08</td>
                        <td>Tue, 04.08</td>
                        <td>Wed, 05.08</td>
                        <td>Thu, 06.08</td>
                        <td>Fri, 07.08</td>
                        <td>Sat, 08.08</td>
                    </tr>
                    <tr>
                        <td>–</td>
                        <td>–</td>
                        <td>–</td>
                        <td>773.29</td>
                        <td>891.14</td>
                        <td>794.63</td>
                        <td>996.65</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flight-result">
            <div class="d-flex justify-content-between">
                <div class="price">755.49 AUD</div>
                <div>Price p.p.</div>
            </div>
            <div class="flight-info mt-3">
                <span>Total price: 1× Adults – 755.49 AUD</span>
                <div class="mt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Outbound</strong> special fare (UNI)
                        </div>
                        <div>Malaysia Airlines</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div>
                            <i class="fas fa-plane"></i> 13:15 05.06.2024 BOM Mumbai/Bombay
                        </div>
                        <div>
                            <i class="fas fa-clock"></i> 13:45 h 1 stop
                        </div>
                        <div>
                            <i class="fas fa-plane-arrival"></i> 07:00 06.06.2024 ADL Adelaide
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="available-seats">At least 9 seats available</div>
                        <button class="book-button">Book this offer</button>
                    </div>
                    <div class="mt-3">
                        <span class="price-breakdown">+ DISPLAY PRICE BREAKDOWN</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/74e6741759.js" crossorigin="anonymous"></script>
</body>

</html>
