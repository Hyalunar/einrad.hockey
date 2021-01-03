<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
require_once '../../logic/first.logic.php'; //autoloader und Session

/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LAYOUT///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
$titel = "25 Jahre | Deutsche Einradhockeyliga";
$content = "Spielerprofile für das 25. Jubiläum der Deutschen Einradhockeyliga";
include '../../templates/header.tmp.php';
?>

<h1 class="w3-text-primary">25 Jahre Deutsche Einradhockeyliga</h1>

<p>
I'm baby iceland hell of wolf direct trade, narwhal ennui church-key woke fingerstache distillery PBR&B aesthetic bicycle rights green juice. Single-origin coffee actually bitters man bun kickstarter DIY tumblr four dollar toast shoreditch yr trust fund la croix organic. Woke vegan tousled lyft. Snackwave drinking vinegar raw denim, gastropub health goth before they sold out beard blog artisan man bun subway tile venmo tilde literally. Asymmetrical shabby chic echo park intelligentsia food truck la croix. Freegan marfa subway tile tumeric cronut.
</p>
<p>
Vinyl sartorial flexitarian roof party aesthetic, dreamcatcher migas normcore paleo lomo helvetica cold-pressed church-key subway tile. Offal banjo fashion axe, normcore waistcoat food truck pork belly jean shorts af portland neutra tumeric echo park copper mug kale chips. Pabst asymmetrical fixie readymade. Kitsch +1 pickled swag. 8-bit thundercats vape polaroid cronut scenester lomo retro hexagon pinterest iceland keytar sriracha.
</p>
<p>
Everyday carry tilde food truck fanny pack jean shorts, blue bottle yr DIY selvage cliche whatever. IPhone organic fingerstache, VHS four loko photo booth bushwick lo-fi brunch you probably haven't heard of them chicharrones kitsch. Letterpress fixie authentic, intelligentsia ennui yuccie craft beer photo booth gluten-free street art raw denim. Shabby chic poke tbh tote bag, hell of leggings williamsburg trust fund. La croix chillwave wolf, lo-fi actually raclette vexillologist pop-up fixie lumbersexual cold-pressed.
</p>
<p>
Subway tile meditation mlkshk pork belly fam cronut. Williamsburg wolf snackwave normcore heirloom franzen iceland ugh. Crucifix taxidermy fanny pack listicle, street art whatever blue bottle vegan +1 chartreuse hell of readymade meditation. Pinterest godard freegan pug jianbing. La croix bitters offal slow-carb hammock etsy asymmetrical.
</p>
<p>
Iceland banjo dreamcatcher, snackwave marfa aesthetic vape photo booth YOLO godard ethical. Mumblecore lyft glossier mixtape, bushwick gastropub fam mustache 8-bit post-ironic single-origin coffee master cleanse cronut. Pok pok actually cloud bread migas readymade put a bird on it four loko small batch aesthetic gluten-free. Fixie artisan iceland bespoke af swag ennui beard man braid hot chicken. Fam thundercats keffiyeh roof party etsy, portland heirloom chillwave tacos fingerstache.
</p>

<!-- Erster Spielerabschnitt -->
<div class="w3-container w3-card-4 w3-primary w3-margin w3-round">
  <div class="w3-third w3-padding">
    <div class="w3-display-container w3-round w3-card" style="border: 1px solid white;">
      <img class="slideshow1 w3-round" src="../bilder/spielerprofile/Adrian.jpg" style="width:100%">
      <img class="slideshow1 w3-round" src="../bilder/spielerprofile/Adrian2.jpg" style="width:100%">
      <img class="slideshow1 w3-round" src="../bilder/spielerprofile/Adrian3.jpg" style="width:100%">
      <img class="slideshow1 w3-round" src="../bilder/spielerprofile/Adrian4.jpg" style="width:100%">
      <img class="slideshow1 w3-round" src="../bilder/spielerprofile/Adrian5.jpg" style="width:100%">
      <img class="slideshow1 w3-round" src="../bilder/spielerprofile/Adrian6.jpg" style="width:100%">
      <img class="slideshow1 w3-round" src="../bilder/spielerprofile/Adrian7.jpg" style="width:100%">
      <button class="w3-button w3-light-grey w3-display-left w3-opacity" onclick="plusDivs(-1, 0)">&#10094;</button>
      <button class="w3-button w3-light-grey w3-display-right w3-opacity" onclick="plusDivs(1, 0)">&#10095;</button>
    </div>
  </div>
  <div class="w3-twothird">
    <p class="w3c-margin">Das ist ein Text.</p>
  </div>
</div>

<!-- Zweiter Spielerabschnitt -->
<div class="w3-container w3-card-4 w3-primary w3-margin w3-round">
  <div class="w3-twothird w3-right-align">
    <p>Das ist ein Text.</p>
  </div>
  <div class="w3-third w3-padding">
    <div class="w3-display-container w3-card w3-round" style="border: 1px solid white;">
      <img class="slideshow2 w3-round" src="../bilder/spielerprofile/Robert.jpg" style="width:100%">
      <img class="slideshow2 w3-round" src="../bilder/spielerprofile/Robert2.jpg" style="width:100%">
      <img class="slideshow2 w3-round" src="../bilder/spielerprofile/Robert3.jpg" style="width:100%">
      <img class="slideshow2 w3-round" src="../bilder/spielerprofile/Robert4.jpg" style="width:100%">
      <button class="w3-button w3-light-grey w3-display-left w3-opacity" onclick="plusDivs(-1, 1)">&#10094;</button>
      <button class="w3-button w3-light-grey w3-display-right w3-opacity" onclick="plusDivs(1, 1)">&#10095;</button>
    </div>
  </div>
</div>

<!-- Dritter Spielerabschnitt -->
<div class="w3-container w3-card-4 w3-primary w3-margin w3-round">
  <div class="w3-third w3-padding">
    <div class="w3-display-container w3-card w3-round" style="border: 1px solid white;">
      <img class="slideshow3 w3-round" src="../bilder/spielerprofile/Guenther_Post.jpg" style="width:100%">
      <img class="slideshow3 w3-round" src="../bilder/spielerprofile/Guenther_Post2.jpg" style="width:100%">
      <img class="slideshow3 w3-round" src="../bilder/spielerprofile/Guenther_Post3.jpg" style="width:100%">
      <img class="slideshow3 w3-round" src="../bilder/spielerprofile/Guenther_Post4.jpg" style="width:100%">
      <img class="slideshow3 w3-round" src="../bilder/spielerprofile/Guenther_Post5.jpg" style="width:100%">
      <img class="slideshow3 w3-round" src="../bilder/spielerprofile/Guenther_Post6.jpg" style="width:100%">
      <button class="w3-button w3-light-grey w3-display-left w3-opacity" onclick="plusDivs(-1, 2)">&#10094;</button>
      <button class="w3-button w3-light-grey w3-display-right w3-opacity" onclick="plusDivs(1, 2)">&#10095;</button>
    </div>
  </div>
  <div class="w3-twothird">
    <p class="w3c-margin">Das ist ein Text.</p>
  </div>
</div>


<div class="w3-container w3-card-4 w3-display-container w3-round w3-primary">
      <div class="slideshow4 w3-round">
        <p>Das ist nochmal ein Text1</p>
      </div>
      <div class="slideshow4 w3-round">
        <p>Das ist nochmal ein Text2</p>
      </div>
      <div class="slideshow4 w3-round">
        <p>Das ist nochmal ein Text3</p>
      </div>
      <div class="slideshow4 w3-round">
        <p>Das ist nochmal ein Text4
        </p>
      </div>
      <div class="slideshow4 w3-round">
        <p>Das ist nochmal ein Text5</p>
      </div>
      <button class="w3-button w3-light-grey w3-display-left w3-opacity" onclick="plusDivs(-1, 3)">&#10094;</button>
      <button class="w3-button w3-light-grey w3-display-right w3-opacity" onclick="plusDivs(1, 3)">&#10095;</button>
</div>

<!-- Script für die Slideshow -->
<script>
var slideIndex = [1,1,1,1];
var slideId = ["slideshow1","slideshow2","slideshow3","slideshow4"];
showDivs(1,0);
showDivs(1,1);
showDivs(1,2);
showDivs(1,3);

function plusDivs(n, no) {
  showDivs(slideIndex[no] += n, no);
}

function showDivs(n, no) {
  var i;
  var x = document.getElementsByClassName(slideId[no]);
  if (n > x.length) {slideIndex[no] = 1}
  if (n < 1) {slideIndex[no] = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex[no]-1].style.display = "block";  
}
</script>


<?php include '../../templates/footer.tmp.php';