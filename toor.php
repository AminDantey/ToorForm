<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $maghsad = htmlspecialchars($_POST['maghsad']);
    $nightNumber = htmlspecialchars($_POST['eghamat']);
    $bozorgsal = htmlspecialchars($_POST['bozorgsal']);
    $kodak = htmlspecialchars($_POST['kodak']);
    $hotelstar = htmlspecialchars($_POST['hotelstar']);

    // checking if any checkbox is checked, if not then assign an empty array
    if (isset($_POST['khadamat'])) {
        $khadamat = $_POST['khadamat'];
    } else {
        $khadamat = [];
    }

    $gPrice = bs_Price($hotelstar, $bozorgsal) + bc_Price($maghsad, $bozorgsal) + ks_Price($hotelstar, $kodak) + kc_Price($maghsad, $kodak) + khadamat($khadamat, $bozorgsal, $kodak);
}
//----- قیمت هتل برای بزرگسالان بر اساس ستاره و تعداد بزرگسال -----//
function bs_Price($hotelstar, $bozorgsal)
{
    if ($hotelstar == "3setare") {
        $hotelPrice = 150000;
    } else if ($hotelstar == "4setare") {

        $hotelPrice = 250000;
    } else if ($hotelstar == "5setare") {

        $hotelPrice = 400000;
    }
    $bs_Price = $hotelPrice * $bozorgsal;
    return $bs_Price;
}
//----- قیمت هتل برای کودکان بر اساس ستاره و تعداد کودکان -----//
function ks_Price($hotelstar, $kodak)
{
    if ($hotelstar == "3setare") {

        $hotelPrice = 150000 * 0.5;
    } else if ($hotelstar == "4setare") {

        $hotelPrice = 250000 * 0.5;
    } else if ($hotelstar == "5setare") {

        $hotelPrice = 400000 * 0.5;
    }
    $ks_Price = $hotelPrice * $kodak;
    return $ks_Price;
}

//----- نوع هتل -----//
function Star($hotelstar)
{
    if ($hotelstar == "3setare") {
        $Star = "هتل 3 ستاره";
    } elseif ($hotelstar == "4setare") {
        $Star = "هتل 4 ستاره";
    } elseif ($hotelstar == "5setare") {
        $Star = "هتل 5 ستاره";
    }
    print($Star);
}

//----- قیمت اقامت بر اساس کشور و تعداد بزرگسال -----//
function bc_Price($maghsad, $bozorgsal)
{
    if ($maghsad == "Dubai") {
        $cPrice =  1500000;
    } else if ($maghsad == "Turkey") {
        $cPrice =   1000000;
    } else if ($maghsad == "China") {
        $cPrice =  3000000;
    } else if ($maghsad == "Maleysia") {
        $cPrice = 1200000;
    }
    $bc_Price = $cPrice * $bozorgsal;
    return $bc_Price;
}
//----- قیمت اقامت بر اساس کشور و تعداد کودک -----//
function kc_Price($maghsad, $kodak)
{
    $cPrice = 0;
    if ($maghsad == "Dubai") {
        $cPrice =  1500000 * 0.5;
    } else if ($maghsad == "Turkey") {
        $cPrice =   1000000 * 0.5;;
    } else if ($maghsad == "China") {
        $cPrice =  3000000 * 0.5;
    } else if ($maghsad == "Malaysia") {
        $cPrice = 1200000 * 0.5;
    }
    $kc_Price = $cPrice * $kodak;
    return $kc_Price;
}


//----- قیمت خدمات بر اساس تعدادبزرگسالان و کودکان -----//
function khadamat($khadamat, $bozorgsal, $kodak)
{
    if ($khadamat == null) {
        return 0;
    } else {
        $kPrice = 0;
        foreach ($khadamat as $khad) {
            if ($khad == "1") {
                $kPrice = $kPrice + (300000 * $bozorgsal);
                $kPrice = $kPrice + (300000 * $kodak * 0.5);
            }
            if ($khad == "2") {
                $kPrice = $kPrice + (200000 * $bozorgsal);
                $kPrice = $kPrice + (200000 * $kodak * 0.5);
            }
            if ($khad == "3") {
                $kPrice = $kPrice + (150000 * $bozorgsal);
                $kPrice = $kPrice + (150000 * $kodak * 0.5);
            }
        }
        return $kPrice;
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="resultstyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>

    <form action="">

        <h1>سفارش شما ثبت شد</h1>
        <h2>اطلاعات رزرو:</h2>


        <div class="h3">
            <h3>نام کامل: <?php echo $name; ?> </h3>
            <h3>ایمیل: <?php echo $email; ?> </h3>
            <h3>کشور مقصد: <?php echo $maghsad; ?> </h3>
            <h3>تعداد شب های اقامت: <?php echo $nightNumber; ?> </h3>
            <h3>تعداد بزرگ سال: <?php echo $bozorgsal; ?> </h3>
            <h3>تعداد کودک: <?php echo $kodak; ?> </h3>
            <h3>نوع اقامت: <?php echo Star($hotelstar); ?> </h3>
            <h3>خدمات اضافی: <?php echo implode(", ", $khadamat); ?> </h3>
            <h3>قیمت کل تور: <?php echo number_format($gPrice) . " تومان"; ?> </h3>
        </div>
    </form>
</body>

</html>