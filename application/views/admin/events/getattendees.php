<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

?>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Event Title</th>
            <th>Attendee</th>
        </tr>
    </thead>
    <tbody>
        <?php 
			if(empty($attendees))
			{
				echo '<tr><td colspan="10">No Data</td></tr>';	
			}
			else { 
				$d=1;
				foreach ($attendees as $row):
            	$eId = $row['event_id']; 
        ?>
        <tr>
            <td><?php echo $d; ?></td>
            <td><?php echo date("M d, Y",strtotime($row['addDate'])); ?></td>
            <td><?php echo htmlspecialchars($row['event_title'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo $row['f_name'].'&nbsp;'.$row['l_name']; ?></td>
        </tr>
    <?php endforeach;
			}
	?>
    </tbody>
</table>
								