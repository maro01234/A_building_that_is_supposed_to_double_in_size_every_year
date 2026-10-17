<?php
// 初年度のビルの高さ（メートル）
$prices = [10, 20, 30];
$names = ["ビルA", "ビルB", "ビルC"];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>毎年２倍になるはずのビル</title>
<style>
    body {
        font-family: sans-serif;
        background: #eef2f7;
        color: #243247;
        margin: 30px;
    }
    section {
        background: white;
        padding: 24px;
        margin-bottom: 24px;
        border-radius: 12px;
    }
    .buildings {
        display: flex;
        align-items: flex-end;
        gap: 24px;
        padding-top: 20px;
        border-bottom: 4px solid #526174;
    }
    .column {
        width: 130px;
        text-align: center;
    }
    .building {
        width: 90px;
        margin: 8px auto 0;
        border: 2px solid #294b75;
        box-sizing: border-box;
        background-color: #457bb3;
        background-image:
            repeating-linear-gradient(
                to top,
                transparent 0 12px,
                #c6eaff 12px 17px,
                transparent 17px 24px
            );
    }
    .wrong {
        background-color: #c55d59;
        border-color: #963b38;
    }
    .warning {
        color: #b13232;
        font-weight: bold;
    }
</style>
</head>
<body>

<h1>🏢 毎年２倍になるはずのビル</h1>
<p>開始時：ビルA＝10m、ビルB＝20m、ビルC＝30m</p>
<p>図は全年度共通で、高さ1mを1pxとして表示します。</p>

<?php for ($year = 1; $year <= 4; $year++): ?>

    <?php
    // この年の成長前の状態から、正しい結果を計算
    $expected = array_map(
        fn($height) => $height * 2,
        $prices
    );

    // １年経過：すべてのビルを２倍にする
    foreach ($prices as &$price) {
        $price *= 2;
    }

    // ここでは、まだ３棟とも正しく２倍になっている
    $beforeDisplay = implode(", ", $prices);

    // バグの原因：
    // $price がビルCへの参照になったまま！
    // unset($price); を入れると修正できる
    ?>

    <section>
        <h2><?= $year ?>年後</h2>
        <p>表示直前のデータ：<?= $beforeDisplay ?> m</p>

        <div class="buildings">
            <?php foreach ($prices as $index => $price): ?>
                <div class="column">
                    <strong><?= $names[$index] ?></strong>
                    <div><?= $price ?> m</div>
                    <small>本来：<?= $expected[$index] ?> m</small>

                    <div
                        class="building <?= $price !== $expected[$index]
                            ? 'wrong' : '' ?>"
                        style="height: <?= $price ?>px"
                    ></div>
                </div>
            <?php endforeach; ?>
        </div>

        <p class="warning">
            表示後のデータ：<?= implode(", ", $prices) ?> m
        </p>
    </section>

<?php endfor; ?>

</body>
</html>