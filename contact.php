<?php include 'header.php'; ?>
  <div class='row'>
    <div class='twelve gray'>
      <h1>Get In Touch</h1>
    </div>
  </div>
  <div class='row'>
    <div class='six shift-three error-msg green' id='thanks'>
      <h1>Thanks for Getting In Touch</h1>
      <p>
        We'll be getting back to you shortly.
      </p>
    </div>
    <div class='six shift-three error-msg red' id='error'>
      <h1>Well, this is embarrassing</h1>
      <p>
        Your message didn't send. Hrm. Care to email us at <a href='mailto:nate@natenorthway.com'>nate@natenorthway.com</a>?<br />
        We're so sorry for this invonvineince. Things must really be broken
      </p>
    </div>
    <div class='eight shift-two'>
      <form action='contact-handler.php' method='post' enctype='multipart/form-data'>
        <div class='input-field'>
          <label for='name'>Your Name</label>
          <input type='text' name='name' required placeholder='Alex Smith' />
        </div>
        <div class='input-field'>
          <label for='email'>Your Email</label>
          <input type='email' name='email' required placeholder='you@example.com' />
        </div>
        <div class='input-field'>
          <label for='subject'>Select A Subject</label>
          <select name='subject'>
            <option value='error'>I Received an Error</option>
            <option value='privacy'>I want to know about my data</option>
            <option value='question'>I have a different question</option>
            <option value='other'>Something Else</option>
          </select>
        </div>
        <div class='input-field'>
          <label for='message'>Your Message</label>
          <small>A few things to keep in mind: Screen shots help us determine error sources MUCH easier.
            Be precise as you can be when talking about errors - try to include the time of day,
            the URL of the page you were on, what you were trying to do, and the error number provided, if any.
            If you have a question about your data, read over the <a href='legal'>legal</a> page first, please!
          </small>
          <textarea name='message'></textarea>
        </div>
        <div class='input-field'>
          <div class="g-recaptcha" data-sitekey="6LdziiITAAAAAKPemAkvfK40zZ28iD1qPjKj2vYc"></div>
          <?php //TODO: fully implement recaptcha ?>
        </div>
        <div class='input-field'>
          <button name='submit' value='submit'>Submit</button>
        </div>
      </form>
    </div>
  </div>
</main>
<?php include 'footer.php'; ?>
