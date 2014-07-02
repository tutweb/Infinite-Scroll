<?php
$con = mysql_connect("localhost", "username", "password");
mysql_select_db("infinitescroll");

$result = mysql_query("select SQL_CALC_FOUND_ROWS * from photos order by id asc limit 2");

$row_object = mysql_query("Select Found_Rows() as rowcount");
$row_object = mysql_fetch_object($row_object);
$actual_row_count = $row_object->rowcount;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Infinite Scroll | Tutorial-Webdesign.com</title>
	<link rel="stylesheet" href="style.css">
	<script src="jquery-1.11.1.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            var page = 1;


            $(window).scroll(function () {
                $('#more').hide();
                $('#no-more').hide();

                if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
                    $('#more').css("top","400");
                    $('#more').show();
                }
                if($(window).scrollTop() + $(window).height() == $(document).height()) {

                    $('#more').hide();
                    $('#no-more').hide();

                    page++;

                    var data = {
                        page_num: page
                    };

                    var actual_count = "<?php echo $actual_row_count; ?>";

                    if((page-1)* 2 > actual_count){
                        $('#no-more').css("top","400");
                        $('#no-more').show();
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "data.php",
                            data:data,
                            success: function(res) {
                                $("#result").append(res);
                                console.log(res);
                            }
                        });
                    }

                }


            });

        </script>
</head>
<body>
	<div id="more">Loading More Content...</div>
	<div id="no-more">No More Content</div>
    <div class="header">
        <h2><a href="http://www.tutorial-webdesign.com">Tutorial-Webdesign.com</a></h2>
        <p>Scroll to load more content <br/><br/><a href="http://www.tutorial-webdesign.com/tutorial-membuat-infinite-scroll-dengan-php-mysql-jquery">Back To Tutorial &raquo;</a></p>
    </div>
	<div id="result">
		<?php
		while ($row = mysql_fetch_array($result)) {
		    echo "<div><img src='images/" . $row['name'] . ".jpg' /></div>";
		}
		?>
	</div>
</body>
</html>