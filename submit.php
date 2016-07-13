<?php include 'inc/header.php'; ?>
  <div class='row'>
    <div class='twelve gray'>
      <h1>Submit a Listing</h1>
      <p>
        Use the form below to be listed on DIY:MKE
      </p>
    </div>
  </div>
  <div class='row'>
    <div class='six shift-three error-msg green' id='thanks'>
      <h1>Thanks</h1>
      <p>
        Thanks for your submission. You should see your list show up soon on it's page.
      </p>
      <small>
        If you submitted a venue, it will show up on the 'venues' page, or,
        if you submitted a band, it will show up on the 'bands' page
      </small>
    </div>
    <div class='six shift-three error-msg red' id='error'>
      <h1>There was an error :(</h1>
      <p>
        We're sorry. There was an error processing your request. Our code monkeys
        are working this out and you should be able to submit your post in a few
        minutes. If you try again soon and still see this message, please <a href='contact' title='Contact Us'>Contact Us</a>
        to let us know what's up.
      </p>
    </div>
    <div class='six gray shift-three' id='form_start'>
      <p class='lead'>
        Are you a <br />
        <button id='select_band'>Band</button> or <button id='select_venue'>Venue</button> ?
      </p>
    </div>
  </div>
  <div class='row'>
    <div class='eight shift-two' id='form_area'>
      <form id='band_form' action='handlers/band-handler.php' method='post' enctype='multipart/form-data'>
        <div class='input-field'>
          <label for='bandname'>Your Band's Name</label>
          <input type='text' name='bandname' required placeholder='Bandname' />
        </div>
        <div class='input-field'>
          <label for='location'>Location</label>
          <input type='text' name='location' required placeholder='Riverwest/Bay View/Etc' />
        </div>
        <div class='input-field'>
          <label for='email'>Booking Email</label>
          <input type='email' name='email' required placeholder='band@gmail.com' />
        </div>
        <div class='input-field'>
          <label for='facebook'>Facebook URL</label>
          <input type='text' name='facebook' placeholder='https://facebook.com/bandname' />
        </div>
        <div class='input-field'>
          <label for='music_link'>Link to Music</label>
          <input type='text' name='music_link' placeholder='https://bandname.bandcamp.com' />
        </div>
        <div class='input-field'>
          <label for='website'>Website URL</label>
          <input type='text' name='website' placeholder='https://bandname.com' />
        </div>
        <div class='input-field'>
          <label for='genres'>Genres (comma seperated)</label>
          <input type='text' name='genres' placeholder='punk, rock, punk rock' />
        </div>
        <div class='input-field'>
          <label for='description'>Description</label>
          <textarea name='description' placeholder='{Bandname} is a 3 piece punk rock band from {location}. Etc.'></textarea>
        </div>
        <div class='input-field'>
          <label for='est'>Year Established</label>
          <select name='est'>
            <?php
              $i;
              $earliestYear = 1999;
              for ($i = date('Y'); $i > $earliestYear; $i--) {
                echo "<option value=" . $i . ">" . $i . "</option>";
              }
            ?>
            <option value='0000'>1999 &amp; Before</option>
          </select>
        </div>
        <div class='input-field'>
          <button name='submit' id='submit' value='submit'>Submit</button>
        </div>
      </form>

      <form id='venue_form' action='handlers/venue-handler.php' method='post' enctype='multipart/form-data'>
        <div class='input-field'>
          <label for='venue_name'>Venue Name</label>
          <input type='text' name='venue_name' required placeholder='Venue XYZ' />
        </div>
        <div class='input-field'>
          <label for='address_l1'>Address (Not required, but suggested. <a href='legal'>Read More</a>)</label>
          <input type='text' name='address_l1' placeholder='100 n 1st st' />
          <input type='text' name='address_l2' placeholder='Suite 3' />
          <label for='city'>City</label>
          <input type='text' name='city' placeholder='Milwaukee' />
        </div>
        <div class='input-field'>
          <label for='email'>Email</label>
          <input type='email' name='email' placeholder='booking@yourvenue.com' />
        </div>
        <div class='input-field'>
          <label for='description'>Description</label>
          <textarea name='description' placeholder='Venue XYZ has been around since 1904, hosting mostly hardcore straight edge bands'></textarea>
        </div>
        <div class='input-field'>
          <label for='genres'>Genres (comma separated list)</label>
          <input type='text' name='genres' placeholder='punk, rock, punk rock, hardcore, straightedge' />
        </div>
        <div class='input-field'>
          <label for='est'>Year Established</label>
          <select name='est'>
            <?php
              $i;
              $earliestYear = 1999;
              for ($i = date('Y'); $i > $earliestYear; $i--) {
                echo "<option value=" . $i . ">" . $i . "</option>";
              }
            ?>
            <option value='0000'>1999 &amp; Before</option>
          </select>
        </div>
        <div class='input-field'>
          <label for='facebook'>Facebook URL</label>
          <input type='text' name='facebook' placeholder='https://facebook.com/venuexyz' />
        </div>
        <div class='input-field'>
          <label for='website'>Website</label>
          <input type='text' name='website' placeholder='https://venuexyz.com' />
        </div>
        <div class='input-field'>
          <button name='submit' value='submit'>Submit</button>
        </div>
      </form>
    </div>
  </div>
</main>
<?php include 'inc/footer.php'; ?>
