<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/input.css">
  <title>スケジュール登録</title>
</head>

<body>
  <div class="page_title">
    <h2>イベント登録</h2>
  </div>

  <div class="btn_wrapper">
    <a href="schedule.php" class="btn">一覧画面へ</a>
  </div>



  <div class="input_container">
    <form action="create.php" method="POST">
      <input type="hidden" name="id" id="id">
      <div class="input_wrapper input_title">
        タイトル<input type="text" name="title" value="">
      </div>
      <div class="input_wrapper">
        イベント開始<input type="date" name="deadline" value="">
      </div>
      <div class="input_wrapper">
        イベント終了<input type="date" name="deadline_end" value="">
      </div>
      <div class="input_wrapper">
        事前準備開始<input type="date" name="start" value="">
      </div>
      <div class="input_wrapper input_contact">
        連絡先<input type="text" name="contact" value="">
      </div>
      <div class="input_wrapper input_memo">
        <p>事前に準備すること</p>
        <input type="text" name="memo" value="" class="memo" size="50">
      </div class="input_wrapper">
      <button id="submit">登録します</button>
    </form>
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    let max = 1000000
    let min = 1
    let number = Math.floor(Math.random() * (max - min + 1)) + min;

    $('#submit').on('click', function() {
      $('#id').val(number);
    });
  </script>
</body>

</html>