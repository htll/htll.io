<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"><title>Official HTLL Link Shortener</title>
<meta charset="UTF-8">
<meta name="robots" content="noindex, nofollow">
<link href="/board/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/gif" href="favico.gif">
</head>

<body>

<div class="title"><center><img src="title.png"></center></div>
<div class="box">
  <div class="container">

	<form method="post" action="shorten.php" id="shortener">
    <input name="longurl" id="longurl" type="text"> <button value="Shorten" class="icon" type="submit">Go</button>
	</form>

	<script src="jquery.min.js"></script>
	<script>
	$(function () {
		$('#shortener').submit(function () {
			$.ajax({data: {longurl: $('#longurl').val()}, url: 'shorten.php', complete: function (XMLHttpRequest, textStatus) {
				$('#longurl').val(XMLHttpRequest.responseText);
			}});
			return false;
		});
	});
	</script>
	
  </div>
</div>
</body>

</html>
