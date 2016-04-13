<?php include('header.php');
if(IsSet($_GET['room_id'])) {
    $stmt = $db->prepare("SELECT * FROM rooms WHERE client_id=:client_id AND id=:room_id");
    $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':room_id', $_GET['room_id'], PDO::PARAM_INT);
    $stmt->execute();
    if($stmt->rowCount() == 1) {
        $room = $stmt->fetch(PDO::FETCH_ASSOC);
        if(IsSet($_POST['clientEvents'])) {
            $newOrders = json_decode($_POST['clientEvents'], true);
            /* Delete old orders */
            $stmt = $db->prepare("DELETE FROM weekly_orders WHERE client_id=:client_id AND room_id=:room_id");
            $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
            $stmt->bindValue(':room_id', $room['id'], PDO::PARAM_INT);
            $stmt->execute();

            /* Populate new orders */
            $stmt = $db->prepare("INSERT INTO weekly_orders (client_id, day, room_id, temperature, start, stop) VALUES (:client_id, :day, :room_id, :temperature, :start, :stop)");
            $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
            $stmt->bindValue(':room_id', $room['id'], PDO::PARAM_INT);

            foreach($newOrders as $order) {
                $stmt->bindValue(':day', $order['day'], PDO::PARAM_INT);
                $stmt->bindValue(':temperature', $order['temperature'], PDO::PARAM_STR);
                $stmt->bindValue(':start', $order['start'], PDO::PARAM_STR);
                if($order['end']=="00:00:00") $order['end']="23:59:59";
                $stmt->bindValue(':stop', $order['end'], PDO::PARAM_STR);
                $stmt->execute();
            }

        }
        echo '<h2>'.$room['name'].'</h2>';
        echo '<p>Consigne actuelle : '.get_current_order($room['id'])."</p>\n";

        echo '<h3>Consigne par défaut</h3>';
        echo '<p>Consigne par défaut actuelle : '.get_default_order($room['id'])."</p>\n";

        echo '<h3>Consignes de dérogation</h3>';
        $stmt = $db->prepare("SELECT * FROM derogative_orders WHERE client_id=:client_id AND room_id=:room_id AND stop>NOW()");
        $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
        $stmt->bindValue(':room_id', $_GET['room_id'], PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() < 1) {
            echo 'Pas de dérogations programmées';
        } else {
            $derogations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo '<ul>';
            foreach($derogations as $derogation) {
                echo '<li>Du '.$derogation['start'].' au '.$derogation['stop'].' : '.$derogation['temperature'].'°C</li>'."\n";
            }
            echo '</ul>';
        }
        echo '<p><a href="#">Ajouter une dérogation</a></p>';
        echo '<h3>Consignes hebdomadaires</h3>'; ?>
        <form action="/?page=room&room_id=<?php echo $_GET['room_id'] ?>" id="weeklyForm" method="POST">
        <input type="hidden" name="action" value="submitWeekly" />
        <div id='calendar' style="width: 75%;"></div>

        <script>
            $(document).ready(function() {
                $('#calendar').fullCalendar({
                    defaultView: 'agendaWeek',
                    firstDay: 1,
                    allDaySlot: false,
                    lang: 'fr',
                    selectOverlap: false,
                    columnFormat: 'dddd',
                    aspectRatio: 3,
                    header: {
                        left: '',
                        center: '',
                        right: ''
                    },
                    defaultDate: '2016-02-01',
                    selectable: true,
                    selectConstraint:{
                        start: '00:00',
                        end: '23:59',
                    },
                    selectHelper: true,
                    select: function(start, stop) {
                        var temp = prompt('Entrez la température souhaitée :')
                        var eventData;
                        if (temp) {
                            eventData = {
                                temperature: temp,
                                title: temp + '°C',
                                start: start,
                                end: stop,
                            };
                            console.log(eventData);
                            $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                        }
                        $('#calendar').fullCalendar('unselect');
                    },
                    editable: true,
                    eventLimit: false,
                    events: [
                    <?php
                    $stmt = $db->prepare("SELECT * FROM weekly_orders WHERE client_id=:client_id AND room_id=:room_id");
                    $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
                    $stmt->bindValue(':room_id', $_GET['room_id'], PDO::PARAM_INT);
                    $stmt->execute();
                    if($stmt->rowCount() > 0) {
                        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($orders as $order) {
                            echo '{';
                            echo 'title: "'.$order['temperature'].' °C",';
                            echo 'temperature: "'.$order['temperature'].'",';
                            echo 'start: "2016-02-0'.$order['day'].'T'.$order['start'].'",';
                            echo 'end: "2016-02-0'.$order['day'].'T'.$order['stop'].'",';
                            echo '},';
                        }
                    }
                    ?>
                    ]
                });
            });
        </script>

        <input type="hidden" id="clientEvents" name="clientEvents" value="" />
        <input type="submit" id="submitWeekly" value="Enregistrer" />
        <script>
        $('#weeklyForm').submit(function(eventObj) {
            var eventsFromCalendar = $('#calendar').fullCalendar('clientEvents');
            var eventsForServer = [];
            $.each(eventsFromCalendar, function(index,value) {
                var event = new Object();
                event.day = value.start.format("d");
                event.start = value.start.format("HH:mm");
                event.end = value.end.format("HH:mm");
                event.temperature = value.temperature;
                eventsForServer.push(event);
            });
            $('#clientEvents').attr('value',JSON.stringify(eventsForServer));
            return true;
        });
        </script>
        </form>


        <?php
    } else {
        echo 'ERREUR : La pièce avec l\'ID '.$_GET['room_id'].' n\'existe pas!';
    }
} else {
    echo 'ERREUR : Pas d\'ID transmis dans l\'URL';
}
?>
<?php include('footer.php'); ?>
