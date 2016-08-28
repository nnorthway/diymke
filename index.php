<?php
include 'functions.php';
include 'inc/header.php';
?>
<div id='item-group' class='cta-group'>
  <div id='theList' class='grid'>
    <div class='gray item'>
      <h1>Browse Listings By Band</h1>
      <a href='bands' title='Browse By Bands' class='btn'>Let's Go<i class='material-icons'>keyboard_arrow_right</i></a>
    </div>
    <div class='gray item'>
      <h1>Browse Listings By Venue</h1>
      <a href='venues' title='Browse By Venues' class='btn'>Let's Go<i class='material-icons'>keyboard_arrow_right</i></a>
    </div>
    <div class='gray item'>
      <h1>Submit A Listing</h1>
      <p>
        Get your band or venue in our listings<br /><br />
        <a href='submit' title='Submit a Listing' class='btn'>Let's Go<i class='material-icons'>keyboard_arrow_right</i></a>
      </p>
    </div>
    <div class='gray item'>
      <h1>Next Event</h1>
      <?php $event = getNextEvent(); ?>
      <p>
        <?php echo $event['name']; ?><br />
        on <?php echo date("F j, Y", strtotime($event['date'])); ?>
      </p>
      <a href='event.php?id=<?php echo $event['id']; ?>' class='btn'>View Event<i class='material-icons'>keyboard_arrow_right</i></a>
    </div>
    <div class='gray item'>
      <h1>Search</h1>
      <p>
        <form action='search.php' method='post'>
          <div class='input-field'>
            <div class='radio-group'>
              <input type='radio' name='table' value='bands' required/>
              <p>Bands</p>
            </div>
            <div class='radio-group'>
              <input type='radio' name='table' value='venues' required/>
              <p>Venues</p>
            </div>
          </div>
          <div class='input-field'>
            <input type='text' name='term' placeholder='Search...' required/>
          </div>
          <input type='submit' name='sumbit' value='Submit' />
        </form>
      </p>
    </div>
  </div>
</div>
  <div class='row'>
    <div class='eight shift-two'>
      <h1>What We're About</h1>
      <p>
        DIY:MKE was started a long time ago and is the brainchild of Scott Cary
        and Nate Northway. They started this project with the idea of providing
        a center of information which would help bands and promotors get in touch
        with other bands and venues to set up a show. <br /><br />
        We're about providing an outlet for bands and venues to put themselves
        out there to play, host, and promote shows and other punk events.<br /><br />
        We're also about punk ethics - Afton and Gorilla Promotions, you
        can't hit people up using our platform. If we get reports that people are
        contacting bands and venues from 'pay-to-play' businesses, we will blacklist
        your IP address. Simple as that. <br /><br />
        Since we're about punk ethics, we're not going to use the information you
        provide to us to market to you. We also will not sell or share your
        information to market to you. With that in mind, remember that this is a
        public site, so there may be some spammers that get through the weeds.
        Though we will do our best to keep these bots and people out, we can't
        prevent this 100% of the time. <br /><br />
        To help ease spam and other unwanted contact, we do provide a few liberties:
        if you're a venue, you don't have to provide an address. If you're a public
        venue (such as a bar, community space, etc), we do strongly encourage you
        to use your real address to help people find your place. Additionally,
        your contact information can be obscured so that all contact through DIY:MKE
        will go to one inbox. The best way to do this is to set up an email account
        (we strongly recommend <a href='http://gmail.com' target='_blank'>GMail</a>)
        which is only used for this site or for booking purposes. For example,
        my band, Anergrams, has an email address just for organizing shows, <a href='mailto:bookanergrams@gmail.com'>bookanergrams@gmail.com</a>.<br />
      </p>
      <h1>How We Do This</h1>
      <p>
        DIY:MKE is maintained by <a href='http://natenorthway.com' target='_blank' title='Nate Northway'>Nate Northway</a>.<br />
        It is funded by our users and supporters via <a href='https://www.gofundme.com/diymke' target='_blank' title='GoFundMe'>GoFundMe</a>. All donations
        go towards (1) domain registration, (2) hosting, (3) licensing, (4) any
        other related costs. At the end of each quarter, any additional funds will
        be donated to local non-profits and charities, on a rotating basis. A few
        of the organizations we'll be donating to include <a href='http://plannedparenthood.org' target='_blank'>Planned Parenthood</a>
        , <a href='https://www.gsafewi.org/' target='_blank'>GSAFE</a>,
        and <a href='https://www.independencefirst.org/home' target='_blank'>Independence First</a>.
      </p>
  </div>
</main>
<?php include 'inc/footer.php'; ?>
