<?php echo validation_errors(); ?>
<?php echo form_open_multipart('cars/save'); ?>
  <?php echo form_hidden('id', $id) ?>
  <table>
    <tr>
      <th>Description:</th>
      <td>
        <?php echo form_textarea(array('name' => 'car_desc', 'value' => $car_desc)) ?>
      </td>
    </tr>
    <tr>
      <th>Year:</th>
      <td>
        <?php echo form_input(array('name' => 'car_year', 'value' => $car_year, 'size' => 4)) ?>
      </td>
    </tr>
    <tr>
      <th>Make:</th>
      <td>
        <?php echo form_input(array('name' => 'car_make', 'value' => $car_make, 'size' => 20)) ?>
      </td>
    </tr>
    <tr>
      <th>Model:</th>
      <td>
        <?php echo form_input(array('name' => 'car_model', 'value' => $car_model, 'size' => 20)) ?>
      </td>
    </tr>
    <tr>
      <th>Image file:</th>
      <td>
        <img src="<?php echo base_url("application/user_images/car$id.jpg")?>" />
        <input type="file" name="userfile" size="20" />
        <?php echo $this->upload->display_errors() ?>
      </td>
    </tr>
    <tr><td><input type="submit" name="save" value="Save" /></td></tr>
  </table>
</form>
<p><a href="<?php echo site_url('cars')?>">List cars</a></p>

