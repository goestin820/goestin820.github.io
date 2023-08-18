<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>萬年曆</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body class="background">
    <p class="title">SLAMDUNK Calendar</p>
    <!-- 萬年曆PHP -->
    <?php
    $month = $_GET['month'] ?? date("n");    //取得當前的月份
    $year = $_GET['year'] ?? date("Y"); //取得年份;
    $firstDateTime = strtotime("$year-$month-1");    //取得當前月份第一天
    $days = date("t", $firstDateTime);     //取得當前月份的總天數
    $finalDateTime = strtotime("$year-$month-$days");    //取得當前月份最後一天
    $firstDateWeek = date("w", $firstDateTime); //取得當前月份第一天的星期
    $finalDateWeek = date("w", $finalDateTime); //取得當前月份最後一天的星期
    $weeks = ceil(($days + $firstDateWeek) / 7);  //計算當前月份的天數會佔幾周
    $firstWeekSpace = $firstDateWeek - 1;       //計算當前月份第一周的空白日(或前一個月份佔幾天)
    $days = [];

    //使用迴圈來畫出當前月的周數
    for ($i = 0; $i < $weeks; $i++) {
        //使用迴圈來畫出當周的天數
        for ($j = 0; $j < 7; $j++) {
            //判斷當周是否為第一周或最後一周
            if (($i == 0 && $j < $firstDateWeek) || (($i == $weeks - 1) && $j > $finalDateWeek)) {
                $days[] = '&nbsp;';
            } else {

                $days[] = $year . "-" . $month . "-" . ($j + 7 * $i - $firstWeekSpace);
            }
        }
    }

    $holiday = [
        $year . '-1-1' => "元旦",
        $year . '-2-28' => "二二八紀念",
        $year . '-4-4' => "兒童節",
        $year . '-5-1' => "勞動節",
        $year . '-8-8' => "父親節",
        $year . '-10-10' => "國慶日",
        $year . '-12-25' => "行憲紀念日"
    ];

    if ($month == 1) {
        $prevYear = $year - 1;
        $prevMonth = 12;
    } else {
        $prevYear = $year;
        $prevMonth = $month - 1;
    }

    if ($month == 12) {
        $nextYear = $year + 1;
        $nextMonth = 1;
    } else {
        $nextYear = $year;
        $nextMonth = $month + 1;
    }
    ?>

    <!-- HTML  -->
    <div class="month">
        <span><?= $year; ?>年</span>
        <!-- <div class="button-lastyear"> -->
        <a href="index.php?year=<?= $prevYear; ?>&month=<?= $prevMonth; ?>">
            <?= $prevMonth; ?>月
            <img src="./images/arrow/pre.png" alt="" class="arrow">
        </a>

        <!-- </div> -->

        <span><?= $month; ?>月</span>

        <!-- <div class="next-month"> -->
        <a href="index.php?year=<?= $nextYear; ?>&month=<?= $nextMonth; ?>">
            <img src="./images/arrow/next.png" alt="" class="arrow">
            <?= $nextMonth; ?>月</a>
        <!-- </div> -->
        <input type="button" value="回當前年月日" class="input" name="button" onclick="location.href='index.php'">
    </div>

    <div class="wrap">
        <div class="aside">
            <!-- <img src="./images/player/" alt=""> -->

            <?php
            $month = $_GET['month'] ?? date("n");

            switch ($month) {
                case 1:
                    echo '<img src="images/player/' . $month . '.jpg" width="100%" height="656px">';
                    break;
                case 2:
                    echo '<img src="images/player/' . $month . '.jpg" width="100%" height="656px">';
                    break;
                case 3:
                    echo '<img src="images/player/' . $month . '.jpg" width="100%" height="656px">';
                    break;
                case 4:
                    echo '<img src="images/player/' . $month . '.jpg" width="100%" height="656px">';
                    break;
                case 5:
                    echo '<img src="images/player/' . $month . '.jpg" width="100%" height="656px">';
                    break;
                case 6:
                    echo '<img src="images/player/' . $month . '.jpg" width="100%" height="656px">';
                    break;
                case 7:
                    echo '<img src="images/player/' . $month . '.jpg" width="100%" height="656px">';
                    break;
                case 8:
                    echo '<img src="images/player/' . $month . '.jpg" width="100%" height="656px">';
                    break;
                case 9:
                    echo '<img src="images/player/' . $month . '.jpg" width="100%" height="656px">';
                    break;
                case 10:
                    echo '<img src="images/player/' . $month . '.jpg" width="100%" height="656px">';
                    break;
                case 11:
                    echo '<img src="images/player/' . $month . '.jpg" width="100%" height="656px">';
                    break;
                case 12:
                    echo '<img src="images/player/' . $month . '.jpg" width="100%" height="656px">';
                    break;
            }
            ?>
        </div>

        <div class="section">
            <div class="container">
                <div class="calendar">
                    <div>日</div>
                    <div>一</div>
                    <div>二</div>
                    <div>三</div>
                    <div>四</div>
                    <div>五</div>
                    <div>六</div>

                    <?php
                    for ($i = 0; $i < count($days); $i++) {
                        $today = date("Y-n-j");
                        $d = ($days[$i] != '&nbsp;') ? explode('-', $days[$i])[2] : '&nbsp;';

                        if ($today == $days[$i]) {
                            if (isset($holiday[$days[$i]])) {
                                echo "<div class='today'> {$d}";
                                echo "  <div>";
                                echo "<div class='holiday'> {$holiday[$days[$i]]} </div>";
                                echo "  </div>";
                                echo "</div>";
                            } else {
                                echo "<div class='today'> {$d} </div>";
                            }
                        } else if (date("w", strtotime($days[$i])) == 0 || date("w", strtotime($days[$i])) == 6) {

                            if (isset($holiday[$days[$i]])) {
                                echo "<div class='weekend'> {$d}";
                                echo "  <div>";
                                echo "<div class='holiday'> {$holiday[$days[$i]]} </div>";
                                echo "  </div>";
                                echo "</div>";
                            } else {
                                echo "<div class='weekend'> {$d} </div>";
                            }
                        } else {
                            if (isset($holiday[$days[$i]])) {
                                echo "<div> {$d}";
                                echo "  <div>";
                                echo "<div class='holiday'> {$holiday[$days[$i]]} </div>";
                                echo "  </div>";
                                echo "</div>";
                            } else {
                                echo "<div> {$d} </div>";
                            }
                        }
                    }

                    ?>
                </div>

                <!-- HTML -->
                <!-- <div class="month">
                    <a href="?year= &month= ">回當前月</a>
                </div> -->
            </div>
            <div class="select">
                <form action="index.php" method="GET">
                    <label for="year">選擇年份：</label>
                    <select name="year" id="year" class="option">
                        <?php
                        for ($i = 1901; $i <= 2050; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>
                    </select>

                    <label for="month">選擇月份：</label>
                    <select name="month" id="month" class="option">
                        <?php
                        for ($j = 1; $j <= 12; $j++) {
                            echo "<option value='$j'>$j</option>";
                        }
                        ?>
                        <!-- <option value="1">1月</option>
                        <option value="2">2月</option>
                        <option value="3">3月</option>
                        <option value="4">4月</option>
                        <option value="5">5月</option>
                        <option value="6">6月</option>
                        <option value="7">7月</option>
                        <option value="8">8月</option>
                        <option value="9">9月</option>
                        <option value="10">10月</option>
                        <option value="11">11月</option>
                        <option value="12">12月</option> -->
                    </select>

                    <input type="submit" value="前往" class="input">
                    <!-- <input type="button" value="回當前年月日" class="input" name="button" onclick="location.href='index.php'"> -->
                    <nbsp&>
                        <?php
                        date_default_timezone_set('Asia/Taipei');
                        $time = date('Y/m/d H:i:s');
                        echo '現在時間' . "&nbsp;" . $time;
                        ?>
                </form>
            </div>
        </div>

        <div class="motto">
            <div class="text">
                不到最後關頭，<br>
                絕不輕言放棄，<br>
                現在放棄的話，<br>
                比賽就結束了！<br>
            </div>
            <div class="tail">
            </div>
        </div>
    </div>

    <marquee behavior="scroll" direction="left" scrollamount="25" ALIGN="BOTTOM"><img src="./images/marquee.png" alt="">
    </marquee>
</body>

</html>