<!DOCTYPE html>
<html>
<title>Official HTLL Link Shortener</title>
<meta charset="UTF-8" />
<meta name="robots" content="noindex, nofollow">
<body>
	<form method="post" action="shorten.php" id="shortener">
	<label for="longurl">URL to shorten</label> <input type="text" name="longurl" id="longurl"> <input type="submit" value="Shorten">
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
</body>
</html>
