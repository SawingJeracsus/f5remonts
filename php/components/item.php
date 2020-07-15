
<div class="feed-item fsb">
  <!-- <img src="img/icon.png" class="feed-item-icon"> -->
  <div class="feed-item-info-wrapper fsb">
    <span class="id_for_loading hidden"><?php echo $settings['id'] ?></span>
    <span class="id"><?php echo $settings['id_publick'] ?></span>
    <div class="info-item">
      <img src="img/pearson.svg"  class="icon">
      <?php echo $settings['surname'] ?>
    </div>
    <div class="info-item">
      <img src="img/phone1.svg"  class="icon">
      <?php echo $settings['phone_num'] ?>
    </div>
    <div class="info-item">
      <img src="img/phone2.svg"  class="icon">
      <?php echo $settings['model'] ?>
    </div>
    <div class="info-item">
      <!-- <img src="img/pearson.svg"  class="icon"> -->
      <h3 class="info-item-title">Несправність:</h3>
      <?php echo $settings['broke'] ?>
    </div>
  </div>
</div>
