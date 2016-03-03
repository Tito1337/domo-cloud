<?php include('header.php');
if(IsSet($_GET['room_id'])) {
    $stmt = $db->prepare("SELECT * FROM rooms WHERE id=:id");
    $stmt->bindValue(':id', $_GET['room_id'], PDO::PARAM_INT);
    $stmt->execute();
    if($stmt->rowCount() == 1) {
        $room = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<h2>'.$room['name'].'</h2>';
        echo '<p>Consigne actuelle : '.get_current_order($room['id'])."</p>\n";

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
                defaultDate: '2016-01-12',
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    var temp = prompt('Entrez la température souhaitée :')
                    var eventData;
                    if (temp) {
                        eventData = {
                            title: temp + '°C',
                            start: start,
                            end: end
                        };
                        $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                    }
                    $('#calendar').fullCalendar('unselect');
                },
                editable: true,
                eventLimit: false,
                events: [
                ]
            });
        });
    </script>


    <?php
    } else {
        echo 'ERREUR : La pièce avec l\'ID '.$_GET['room_id'].' n\'existe pas!';
    }
} else {
    echo 'ERREUR : Pas d\'ID transmis dans l\'URL';
}
?>
<?php include('footer.php'); ?>