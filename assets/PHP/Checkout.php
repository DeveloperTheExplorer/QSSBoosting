<?php
  $boostType = "";
  $soloDuo = "";
  $currRank = 0;
  $currDiv = 0;
  $server = "";
  $rankTo = 0;
  $numOfGames = 0;

  $forms = "";
  $displayBoost = "Division Boost";
  $wishRank = "";
  $wishDiv = "";
  $winPrice = 0;
  $divPrice = 0;
  $prices = [8, 8, 8, 8, 10, 10, 10, 10, 13, 15, 17, 20, 22, 24, 26, 30, 32, 35, 38, 45, 85, 100, 175, 275];
  $wins = [3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 6, 6, 6, 6, 8, 8, 8, 8, 12, 16, 20,  25];
  $ranks = ["iron", "bronze", "silver", "gold", "platinum", "diamond"];
  $divs = ["IV", "III", "II", "I"];



  if(isset($_GET["BT"]) && isset($_GET["SD"]) && isset($_GET["r1"]) && isset($_GET["d1"]) && isset($_GET["server"])) {
    $boostType = $_GET["BT"];
    $soloDuo = $_GET["SD"];
    $currentRank = $_GET["r1"];
    $currentDiv = $_GET["d1"];
    $server = $_GET["server"];

    if ($boostType == "div") {
        if(!isset($_GET["r2"]))
          header('Location: /');

          $rankTo = $_GET["r2"];
          $wishRank = $ranks[(intval($rankTo) - (intval($rankTo) % 4)) / 4];
          $wishDiv = $divs[intval($rankTo) % 4];

    } else if($boostType == "win") {
        if(!isset($_GET["numGames"]))
          header('Location: /');

          $numOfGames = $_GET["numGames"];

    } else {
      header('Location: /');
    }
  } else {
    header('Location: /');
  }


  if($boostType == "win") {
    $winPrice = $numOfGames * $wins[($currentRank * 4) + $currentDiv];
    $displayBoost = "Net Wins";

    if($soloDuo == "Duo")
      $winPrice = $winPrice * 1.5;

    $wish = '
    <h2 class="sm-mar-top"> <span class="txt-stylish">Number of Games: </span>
    <span class="txt-primary">'.$numOfGames.'</span>
    </h2>';
  } else {
    $divPrice = 0;
    $rankFrom = ($currentRank * 4) + $currentDiv;

    for ($i = $rankFrom; $i < $rankTo; $i++) {
      $divPrice += $prices[$i];
    }

    if($soloDuo == "Duo")
      $divPrice = $divPrice * 1.5;
    $wish = '
    <h2 class="sm-mar-top"> <span class="txt-stylish">Desired Rank: </span>
      <div class="checkoutRank">
        <div class="selectedDiv txt-primary">'.$wishDiv.'</div>
        <img class="rankImg" src="assets/img/ranks/'.$wishRank.'.png"/>
      </div>
    </h2>';
  }

  if ($divPrice < 0 || $winPrice < 0)
      header('Location: /');

  if($soloDuo == "Duo")
    $forms = '
    <div class="tb-container sm-mar-top duoRequired">
      <input id="usernamePurchase" name="Username" type="text" placeholder=" " autocomplete="new-password" class="aumd-tb purchaseInputs txt-grey required">
      <label for="Username" class="aumd-tb-label">In-Game Username*</label><span class="validation"></span>
    </div>';
  else
    $forms = '
    <div class="tb-container sm-mar-top soloRequired">
      <input id="loginPurchase" name="Login" type="text" placeholder=" " autocomplete="new-password" class="aumd-tb txt-grey purchaseInputs required">
      <label for="Login" class="aumd-tb-label">LoL Login Username*</label><span class="validation"></span>
    </div>
    <div class="tb-container sm-mar-top soloRequired">
      <input id="passPurchase" name="Password" type="password" placeholder=" " autocomplete="new-password" class="aumd-tb txt-grey purchaseInputs required">
      <label for="Password" class="aumd-tb-label">LoL Login Password*</label><span class="validation"></span>
    </div>';

  $finalPrice = $divPrice > 0 ? $divPrice : $winPrice;

  $currentRank = $ranks[$currentRank];
  $currentDiv = $divs[intval($currentDiv)];
  $rankImg = '<div class="selectedDiv txt-primary">'.$currentDiv.'</div><img class="rankImg" src="assets/img/ranks/'.$currentRank.'.png"/>';

?>
