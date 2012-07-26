<table>
  <tr>
    <th>Description</th>
    <th>Year</th>
    <th>Make</th>
    <th>Model</th>
    <th>Actions</th>
  </tr>
<?php foreach ($cars as $item): ?>
  <tr>
    <td><?=$item['car_desc']?></td>
    <td><?=$item['car_year']?></td>
    <td><?=$item['car_make']?></td>
    <td><?=$item['car_model']?></td>
    <td>
      <a href="<?php echo site_url("cars/view/".$item['id']) ?>">View car</a>
      <a href="<?php echo site_url("cars/edit/".$item['id']) ?>">Edit car</a>
    </td>
  </tr>
<?php endforeach ?>
</table>
<p><a href="<?php echo site_url('cars/new/0')?>">Add new car</a></p>
<p>
