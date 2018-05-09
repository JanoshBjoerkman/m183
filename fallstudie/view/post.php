
<?php while ($data->issetCurrentPost()): ?>

  <div class="media <?php echo $data->getPostStatus()?>">
    <div class="media-left">
      <img src="<?php echo "media/" . $data->getPosterAvatar() ?>" class="media-object">
    </div>

    <div class="media-body">
      <h4 class="media-heading">
        <?php echo $data->getPosterFirstname() . " " . $data->getPosterLastname() ?>
        <small><i>Gepostet am: <?php echo $data->getPostDate() ?></i></small>
      </h4>
      <p><?php echo $data->getPostContent() ?></p>
      
      <!-- form area, area where user can make text input in order comment current post (hidden by default) -->
      <div class="comment-area">
        
        <form action="index.php?" method="POST">
          <div class="form-group">
            <label for="post-<?php echo $data->getPostId()?>">Kommentar</label>
            <textarea
              class="form-control"
              rows="3"
              id="post-<?php echo $data->getPostId()?>"
              name="content"
              required></textarea>
          </div>

          <!-- hidden field providing post-id of post to be commented -->
          <div class="form-group">
            <input
              type="hidden"
              class="form-control"
              name="postid"
              value="<?php echo $data->getPostId()?>">
            </input>
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" name="csfr" value="<?php echo $data->getCSFR() ?>"></input>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-default btn-xs" name="op" value="newcomment">Post</button>
          </div>
        </form>
      </div>

      <!-- button to unhide input-form for commenting current post -->
      <p class="comment-btn-area">
        <button type="button" class="btn btn-default btn-xs comment-btn">Kommentieren</button>
      </p>


      <?php
        if ($data->issetYoungestChild()) {
          $data->goToYoungestChild();
          include (VIEW_PATH . "/post.php");
        }
      ?>
    </div>
  </div>

  <?php
    if ($data->issetOlderSibling()) {
      $data->goToOlderSibling();
    } else {
      $data->goToParent();
      break;
    }
  ?>
<?php endwhile; ?>
  
