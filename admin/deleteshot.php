<?php
include 'adm.phphidden';
pageView("Delete shot :wrench::triangular_flag_on_post::wastebasket:");
 if (isset($_GET['id'])){
            $daid = intval($_GET['id']);
   $sql = "SELECT `shot` FROM novy WHERE id = $daid;";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
			$shotid=$row['shot'];
		            }


if (is_file("/srv/http/shot2/".$shotid.".png")) {
	unlink("/srv/http/shot2/".$shotid.".png");
	}

            $sql = "UPDATE `novy` SET `shot` = 'No Screenshot' WHERE `id` =  $daid;";
            $result = mysqli_query($conn, $sql);
            sqlEdit("deleted screeshot :wrench::frame_photo::wastebasket: ```sql\n".$sql."````$result`");

            header('Location: editpoi?id='.$daid);
        }
include '../shared/footer.php';
?>

