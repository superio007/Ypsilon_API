<?php
session_start();
$responseData = [
    'response' => [
        'flights' => [
            [
                'additionalServices' => [
                    [
                        'additionalServiceType' => 'Baggage',
                        'serviceDescription' => 'Extra Baggage',
                        'flightFares' => [
                            ['amount' => 50]
                        ]
                        ],
                        [
                            'additionalServiceType' => 'Baggage',
                            'serviceDescription' => 'Extra Baggage',
                            'flightFares' => [
                                ['amount' => 50]
                            ]
                        ],
                        [
                            'additionalServiceType' => 'Baggage',
                            'serviceDescription' => 'Extra Baggage',
                            'flightFares' => [
                                ['amount' => 50]
                            ]
                        ]
                ]
            ]
        ]
    ]
];
$maxQuantity = 10; // Example value, replace with your own
$price = 50; // Example value, replace with your own
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Counter</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div id="main" class="mb-3">
        <div id="outer-div">
            <div class="form-container">
                <div class="form-group col-6">
                    <label for="extra_baggage">Extra baggage*</label>
                    <?php 
                    $index = 0;
                    foreach ($responseData['response']['flights'] as $flight) : 
                        foreach ($flight['additionalServices'] as $additionalServices) : ?>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <p><?php echo $additionalServices['additionalServiceType']; ?></p>
                                    <p><?php echo "-" . $additionalServices['serviceDescription']; ?></p>
                                    <?php foreach ($additionalServices['flightFares'] as $flightFares) : ?>
                                        <p>&nbsp;<?php echo "$" . $flightFares['amount']; ?></p>
                                    <?php endforeach; ?>
                                </div>
                                <div class="d-flex price-counter">
                                    <button type="button" class="btn btn-outline-secondary price-minus" data-index="<?php echo $index; ?>">-</button>
                                    <input type="text" class="form-control text-center price-count" id="price-count-<?php echo $index; ?>" data-index="<?php echo $index; ?>" value="0" max="<?php echo $maxQuantity; ?>">
                                    <button type="button" class="btn btn-outline-secondary price-plus" data-price="<?php echo $price; ?>" data-index="<?php echo $index; ?>">+</button>
                                </div>
                            </div>
                            <?php $index++; ?>
                        <?php endforeach; 
                    endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // When the plus button is clicked
            $('.price-plus').click(function() {
                var index = $(this).data('index');
                var maxQuantity = parseInt($('#price-count-' + index).attr('max'));
                var currentCount = parseInt($('#price-count-' + index).val());
                
                if (currentCount < maxQuantity) {
                    $('#price-count-' + index).val(currentCount + 1);
                }
            });

            // When the minus button is clicked
            $('.price-minus').click(function() {
                var index = $(this).data('index');
                var currentCount = parseInt($('#price-count-' + index).val());

                if (currentCount > 0) {
                    $('#price-count-' + index).val(currentCount - 1);
                }
            });
        });
    </script>
</body>
</html>
