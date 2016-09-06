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
    <div class='six shift-three error-msg red' id='file_size_limit'>
      <h1>File Size Limit Exceeded</h1>
      <p>
        We're sorry, but the size of the image you tried to upload was too big.
        Images have a maximum size of 1MB. Please give it another shot with a
        smaller file size. Don't know how to compress images? See the <a href='docs.php'>Docs</a>
        page.
      </p>
    </div>
    <div class='six shift-three error-msg red' id='file_type'>
      <h1>Wrong File Type</h1>
      <p>
        The image you tried to upload was not the correct type. Acceptable image
        types include GIF, JPG, JPEG, and PNG. If your image is in a different format
        and you don't know how to convert, see the <a href='docs.php'>Docs</a> page.
      </p>
    </div>
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
        What would you like to submit <br />
        <button id='select_band' class='btn'>A Band</button><button id='select_venue' class='btn'>A Venue</button><button id='select_event' class='btn'>An Event</button>
      </p>
    </div>
  </div>
  <div class='row'>
    <div class='eight shift-two' id='form_area'>
      <form id='band_form' class='form_submittable' action='handlers/band-handler.php' method='post' enctype='multipart/form-data'>
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

      <form id='venue_form' class='form_submittable' action='handlers/venue-handler.php' method='post' enctype='multipart/form-data'>
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

      <form id='event_form' class='form_submittable' action='handlers/event-handler.php' method='post' enctype='multipart/form-data'>
        <div class='input-field'>
          <label for='event_name'>Event Name (required)</label>
          <input type='text' name='event_name' required placeholder='Band A(NY)//Band B(GA)//Local Band//Local Band'/>
        </div>
        <div class='input-field'>
          <label for='event_venue'>Event Venue (required)</label>
          <input type='text' name='event_venue' required placeholder="Quarter's Rock 'n' Roll Palace"/>
        </div>
        <div class='input-field'>
          <label for='venue_address'>Address (Not required, but suggested. <a href='legal'>Read More</a>)</label>
          <input type='text' name='address_l1' placeholder='100 n 1st st' />
          <input type='text' name='address_l2' placeholder='Suite 3' />
          <label for='city'>City</label>
          <input type='text' name='city' placeholder='Milwaukee' />
        </div>
        <div class='input-field'>
          <label for='venue_link'>Venue Link on DIY:MKE</label>
          <input type='text' name='venue_link' placeholder='http://diymke.org/venue.php?id=1' />
        </div>
        <div class='input-field'>
          <label for='facebook_event'>Facebook Event Link</label>
          <input type='text' name='facebook_event' placeholder='http://facebook.com/events/129487498756' />
        </div>
        <div class='input-field'>
          <label for='other_link'>Other Event Link (MySpace? ReverbNation? Whatever...)</label>
          <input type='text' name='other_link' placeholder='http://example.com/event/your_event_name' />
        </div>
        <div class='input-field'>
          <label for='cover_charge'>Cover Charge</label>
          <input type='number' name='cover_charge' min='0' max='1000' step='0.5' value='0' />
        </div>
        <div class='input-field'>
          <label for='date'>Event Date (required)</label>
          <input type='date' name='date' required />
        </div>
        <div class='input-field'>
          <label for='start_time'>Start Time (required)</label>
          <input type='time' name='start_time' required />
        </div>
        <div class='input-field'>
          <label for='event_type'>Event Type (required)</label>
          <select name='event_type' required>
            <option value='art_show'>Art Show</option>
            <option value='concert'>Concert/Live Music</option>
            <option value='meeting'>Meeting (Org, Committee, etc)</option>
            <option value='potluck'>Potluck</option>
            <option value='benefit'>Fundraiser/Benefit Show</option>
            <option value='fest'>Festival</option>
            <option value='party'>Dance/Party</option>
            <option value='activism'>Protest/Demonstration/Activism</option>
            <option value='workshop'>Workshop/Skillshare</option>
          </select>
        </div>
        <div class='input-field'>
          <label for='age_restriction'>Age Restriction (required)</label>
          <select name='age_restriction' required>
            <option value='All Ages'>All Ages</option>
            <option value='18+'>18+</option>
            <option value='21+'>21+</option>
          </select>
        </div>
        <div class='input-field'>
          <label for='description'>Description</label>
          <small>
            Hot tip: to insert a line break, type "&lt;br&gt;"
          </small>
          <textarea name='description' placeholder='This show is gonna be off the chain!'></textarea>
        </div>
        <div class='input-field'>
          <label for='event_image'>Event Image/Flyer</label>
          <input type='file' accept='image/*' name='event_image'/>
        </div>
        <div class='input-field'>
          <label for='host_email'>Host Email Address (required)</label>
          <input type='email' name='host_email' required placeholder='you@example.com' />
        </div>
        <div class='input-field'>
          <button name='submit' value='submit' class='btn'>Submit</button>
        </div>
      </form>
    </div>
  </div>
</main>
<?php include 'inc/footer.php'; ?>
