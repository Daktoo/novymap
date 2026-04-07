<?php
include 'adm.phphidden';
pageView("del poi :wrench::triangular_flag_on_post::wastebasket:");
        if (isset($_GET['id'])){
            $daid = intval($_GET['id']);
            $namerow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM novy WHERE id=$daid"));
            $sql = "DELETE FROM `novy` WHERE `id` =  $daid;";
            $result = mysqli_query($conn, $sql);
            sqlEdit("deleted poi :wrench::checkered_flag::wastebasket: ```sql\n".$sql."````$result`");
            auditlog('delete', 'POI', [
                'name' => $namerow['name'] ?? "ID $daid",
                'id'   => $daid
            ]);
            header('Location: admin_poi');
        }
include '../shared/footer.php';
?>
