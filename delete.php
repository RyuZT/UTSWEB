<?php
include 'configevent.php';

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
    $sql = "DELETE FROM msevent_detail WHERE ID = ?";
    $stmt = $kunci->prepare($sql);
    $stmt->execute([$event_id]);

    header("Location: event_management.php");
} else {
    echo "ID Event tidak diberikan!";
    exit;
}
?>
