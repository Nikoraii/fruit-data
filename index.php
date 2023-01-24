<?php

$url = 'https://fruityvice.com/api/fruit/all';
$json_data = file_get_contents($url);
$data = json_decode($json_data);

$family = [];
$genus = [];
$order = [];

foreach ($data as $fruit_data) {
  array_push($family, $fruit_data->family);
  array_push($genus, $fruit_data->genus);
  array_push($order, $fruit_data->order);
}

$family = array_unique($family);
$genus = array_unique($genus);
$order = array_unique($order);


?>
<!doctype html>
<html lang="en">
  <head>
    <title>Fruit</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    
    <div class="jumbotron jumbotron text-white text-center">
        <div class="container">
            <h1 class="display-3">Fruit Database</h1>
            <p class="lead">Simple Fruit display and filter application using <a id="api" href="https://fruityvice.com/" target="_blank">Fruityvice API <i class="fa fa-link" aria-hidden="true"></i></a></p>
            <!-- <p class="lead"><a href="https://github.com/Nikoraii/fruit" target="_blank" rel="noopener noreferrer">Github</a></p> -->
            <p>You can both combine and reset filtres.</p>
            <hr class="my-2">

            <div class="filters">
              <div class="ui-group">
                <p class="t-text">Family:</p>
                <select name="family" id="family" class="filter-select custom-select custom-select-lg" value-group="family">
                  <option value="">Family</option>
                  <?php foreach ($family as $fam) { ?>
                    <option value=".<?= $fam ?>"><?= $fam ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="ui-group">
                <p class="t-text">Genus:</p>
                <select name="genus" id="genus" class="filter-select custom-select custom-select-lg"  value-group="genus">
                    <option value="">Genus</option>
                    <?php foreach ($genus as $gen) { ?>
                      <option value=".<?= $gen ?>"><?= $gen ?></option>
                    <?php } ?>
                  </select>
              </div>
              <div class="ui-group">
                <p class="t-text">Order:</p>
                <select name="order" id="order" class="filter-select custom-select custom-select-lg"  value-group="order">
                    <option value="">Order</option>
                    <?php foreach ($order as $ord) { ?>
                      <option value=".<?= $ord ?>"><?= $ord ?></option>
                    <?php } ?>
                  </select>
              </div>
            </div>
            <button id="reset" class="btn btn-secondary reset">Reset</button>
            <p class="filter-count"></p>
        </div>
    </div>

    <main>
        <div class="container">
            <div class="row">

            <?php foreach ($data as $fruit) { ?>
              <div class="col-3 <?= $fruit->family ?> <?= $fruit->genus ?> <?= $fruit->order ?>" id="<?= $fruit->id ?>">
                <div class="card m-2">
                  <div class="card-header">
                    <h3 class="card-title m-0 m-0 name"><?= $fruit->name ?></h3>
                    <small><?= $fruit->family ?></small>
                  </div>
                  <div class="card-body">
                    <p class="card-text">Genus: <?= $fruit->genus ?></p>
                    <p class="card-text">Order: <?= $fruit->order ?></p>
                    <p class="card-text">Nutritions:</p>
                    <ul>
                        <li>carbohydrates- <?= $fruit->nutritions->carbohydrates ?></li>
                        <li>protein - <?= $fruit->nutritions->protein ?></li>
                        <li>fat - <?= $fruit->nutritions->fat ?></li>
                        <li>calories - <?= $fruit->nutritions->calories ?></li>
                        <li>sugar - <?= $fruit->nutritions->sugar ?></li>
                    </ul>
                  </div>
                </div>
              </div>
            <?php } ?>

            </div>
        </div>
    </main>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>
    <script>
      $(document).ready(function(){
        // init Isotope
        let $grid = $('.row').isotope({
          itemSelector: '.col-3'
        });

        // store filter for each group
        let filters = {};

        var iso = $grid.data('isotope');
        var $filterCount = $('.filter-count');

        function updateFilterCount() {
          $filterCount.text( iso.filteredItems.length + ' item(s)' );
        }

        updateFilterCount();

        $('.filters').on( 'change', function( event ) {
          let $select = $( event.target );
          // get group key
          let filterGroup = $select.attr('value-group');
          // set filter for group
          filters[ filterGroup ] = event.target.value;
          // combine filters
          let filterValue = concatValues( filters );
          // console.log(filterValue);
          // set filter for Isotope
          $grid.isotope({ filter: filterValue });
          // update count
          updateFilterCount();
        });

        // flatten object by concatting values
        function concatValues( obj ) {
          let value = '';
          for ( let prop in obj ) {
            value += obj[ prop ];
          }
          return value;
        }

        $("#reset").click(function(e) {
          $grid.isotope({ filter: "*" });
          $(".filter-select").val("");
          filters = {};
          // update count
          updateFilterCount();
        })

      });
    </script>
  </body>
</html>