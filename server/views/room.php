<?php include('header.php');
if(IsSet($_GET['room_id'])) {
    $stmt = $db->prepare("SELECT * FROM rooms WHERE client_id=:client_id AND id=:room_id");
    $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':room_id', $_GET['room_id'], PDO::PARAM_INT);
    $stmt->execute();
    if($stmt->rowCount() == 1) {
        $room = $stmt->fetch(PDO::FETCH_ASSOC);
        /* Save default */
        if(IsSet($_POST['default_order'])) {
            /* Delete old orders */
            $stmt = $db->prepare("DELETE FROM default_orders WHERE client_id=:client_id AND room_id=:room_id");
            $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
            $stmt->bindValue(':room_id', $room['id'], PDO::PARAM_INT);
            $stmt->execute();

            /* Populate new orders */
            $stmt = $db->prepare("INSERT INTO default_orders (client_id, room_id, temperature) VALUES (:client_id, :room_id, :temperature)");
            $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
            $stmt->bindValue(':room_id', $room['id'], PDO::PARAM_INT);
            $stmt->bindValue(':temperature', $_POST['default_order'], PDO::PARAM_INT);
            $stmt->execute();
        }

        /* Save weekly */
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


        echo '<h2>'.$room['name'].'</h2>'; ?>
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Consigne actuelle</h3>
                </div>
                <div class="panel-body">
                    <?php echo get_current_order($room['id']); ?>°C
                </div>
            </div>
            </div>

            <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Consigne par défaut</h3>
                </div>
                <div class="panel-body">
                    <form action="/?page=room&room_id=<?php echo $_GET['room_id']; ?>" method="POST" class="form-inline">
                    <div class="input-group">
                        <input type="number" name="default_order" id="default_order" value="<?php echo get_default_order($room['id']); ?>" class="form-control" />
                        <span class="input-group-addon">°C</span>
                    </div>
                    <button type="submit" class="btn btn-default">Enregistrer</button>
                    </form>
                </div>
            </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Consignes hebdomadaires</h3>
            </div>
            <div class="panel-body">
                    <form action="/?page=room&room_id=<?php echo $_GET['room_id'] ?>" id="weeklyForm" method="POST">
        <input type="hidden" name="action" value="submitWeekly" />
        <div id='calendar' style="width: 100%;"></div>

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
        <button type="submit" id="submitWeekly" class="btn btn-default" style="margin-top: 5px;">Enregistrer</button>
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
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Dérogations</h3>
            </div>
                <form action="/?page=room&room_id=<?php echo $_GET['room_id']; ?>" method="POST" class="form-inline">
                <table class="table">
                    <tr>
                        <th></th>
                        <th>De</th>
                        <th>À</th>
                        <th>Température</th>
                    </tr>
                    <td>
                        <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" name="default_order" id="start1" class="form-control" />
                            <script type="text/javascript">
                                $(function () { $('#start1').datetimepicker({locale: 'fr'}); });
                                $("#start1").on("dp.change", function (e) {
                                    $('#stop1').data("DateTimePicker").minDate(e.date);
                                });
                            </script>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="datetime" name="default_order" id="stop1" class="form-control" />
                            <script type="text/javascript">
                                $(function () { $('#stop1').datetimepicker({locale: 'fr'}); });
                                $("#stop1").on("dp.change", function (e) {
                                    $('#start1').data("DateTimePicker").maxDate(e.date);
                                });
                            </script>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" name="default_order" id="temp1" value="<?php echo get_default_order($room['id']); ?>" class="form-control" />
                            <span class="input-group-addon">°C</span>
                        </div>
                    </td>
                </table>
                <?php
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
                ?>
                <div class="panel-body">
                    <p><a href="#">Ajouter une dérogation</a></p>
                </div>
        </div>

        <?php
    } else {
        echo 'ERREUR : La pièce avec l\'ID '.$_GET['room_id'].' n\'existe pas!';
    }
} else {
    echo 'ERREUR : Pas d\'ID transmis dans l\'URL';
}
?>
<?php include('footer.php'); ?>
