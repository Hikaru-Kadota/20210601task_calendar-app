<?php
$str = '';
$data = [];

$file = fopen('data/schedule.csv', 'r');
flock($file, LOCK_EX);
if ($file) {
  while ($line = fgets($file)) {
    $str .= "<tr><td>{$line}</td></tr>";
    array_push($data, $line);
  }
}

flock($file, LOCK_UN);
fclose($file);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/calendar.css">
  <title>SCHEDULE</title>
</head>

<body>
  <div class="page_title">
    <h2>イベント一覧</h2>
  </div>

  <div class="btn_wrapper">
    <a href="input.php" class="btn">登録画面へ</a>
  </div>

  <table>
    <tbody id="output">
    </tbody>
  </table>


  <div class="index">
    <a>表示：</a>
    <a class="standby_btn">準備期間</a>
    <a class="event_btn">イベント</a>
  </div>






  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    const hoge = <?= json_encode($data) ?>;
    const data = hoge.map(x => {
      return {
        id: x.split(' ')[0],
        title: x.split(' ')[1],
        start: x.split(' ')[2],
        deadline: x.split(' ')[3],
        deadline_end: x.split(' ')[4],
        contact: x.split(' ')[5],
        memo: x.split(' ')[6].split('\n').join(''),
      }
    })
    console.log(data);

    data.sort(function(a, b) {
      if (a.start < b.start) {
        return -1;
      } else {
        return 1;
      }
    });

    let day = new Date('2021-05-30')
    let today = day.getTime() / 86400000 - 18777;
    let max_span = [];
    for (let i = 0; i < data.length; i++) {
      let max_deadline_end = new Date(data[i].deadline_end)
      let max_deadline_endTime = max_deadline_end.getTime() / 86400000 - 18778;
      max_span.push(max_deadline_endTime);
    }
    let max_spanNumber = max_span.reduce(function(a, b) {
      return Math.max(a, b);
    });
    console.log(max_spanNumber);


    //ヘッダーに日付を表示するところ
    let spanArray = [];
    spanArray.push('<tr>');
    for (let i = 0; i < max_spanNumber + 1; i++) {
      day.setDate(day.getDate() + 1);
      let month = day.getMonth() + 1;
      let date = day.getDate();
      if (date == 1) {
        spanArray.push(`
      <td class="date">
      <p>${month+'月'}<br>${date+'日'}</p></td>
      `);
      } else {
        spanArray.push(`
      <td class="date"><p>${date+'日'}</p></td>
      `);
      }
    }
    spanArray.push('</tr>')



    //登録データをカレンダーに表示する部分
    for (let i = 0; i < data.length; i++) {
      let startDay = new Date(data[i].start)
      let startTime = startDay.getTime() / 86400000 - 18778;
      let deadline = new Date(data[i].deadline)
      let deadlineTime = deadline.getTime() / 86400000 - 18778;
      let standbyTime = deadlineTime - startTime;
      let deadline_end = new Date(data[i].deadline_end)
      let deadline_endTime = deadline_end.getTime() / 86400000 - 18778;
      let eventTime = deadline_endTime - deadlineTime;
      let event_title = data[i].title;
      let event_memo = data[i].memo;
      console.log("開始" + startTime);
      console.log("期限" + deadlineTime);
      console.log("準備" + standbyTime);
      console.log("イベント" + eventTime);


      spanArray.push('<tr>');


      //事前準備より前の部分
      for (let i = 0; i < startTime; i++) {
        spanArray.push(`
      <td id="" class="brank"></td>
      `);
      }

      //事前準備期間の部分
      for (let i = 0; i < standbyTime; i++) {
        spanArray.push(`
      <td id="setumei" class="standby">
      <div class="standby_title">
      <p class="announce">---- 準備期間 ----</p>
      <p><< イベント >></p>
      <p class="standby_content">${event_title}</P>
      <p><< メモ >></p>
      <p class="standby_content">${event_memo}</P>
      </div>
      </td>
      `);
      }

      //イベントの部分
      for (let i = 0; i < eventTime + 1; i++) {
        spanArray.push(`
      <td id="" class="event">
      <div class="event_title">
      <p class="announce">---- イベント ----</p>
      <p><< イベント >></p>
      <p class="event_content">${event_title}</P>
      <p><< メモ >></p>
      <p class="event_content">${event_memo}</P>
      </div>
      </td>
      `);
      }

      //最後に全部ぶち込んでブラウザ表示
      spanArray.push('</tr>');
      $('#output').html(spanArray);
    }

    $(function() {
      $('.standby_title').hide();
      $('td').hover(
        function() {
          $(this).children('.standby_title').fadeIn('fast');
        },
        function() {
          $(this).children('.standby_title').fadeOut('fast');
        });
    });

    $(function() {
      $('.event_title').hide();
      $('td').hover(
        function() {
          $(this).children('.event_title').fadeIn('fast');
        },
        function() {
          $(this).children('.event_title').fadeOut('fast');
        });
    });
  </script>



</body>

</html>