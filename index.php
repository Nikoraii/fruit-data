<?php

$url = 'https://www.fruityvice.com/api/fruit/all';
$json_data = file_get_contents($url);
$data = json_decode($json_data);

$family = [];

foreach ($data as $family_data) {
  array_push($family, $family_data->family);
}
$family = array_unique($family);

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
    <link rel="stylesheet" href="assets/style.css">
  </head>
  <body>
    <div class="jumbotron jumbotron text-white text-center">
        <div class="container">
            <h1 class="display-3">Fruit Database</h1>
            <p class="lead">Some text</p>
            <hr class="my-2">
            <p>More info</p>

            <form class="form-inline">
                <div class="form-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Apple..." aria-describedby="helpId">
                    <button type="submit" class="btn btn-success">Search</button>
                </div>
            </form>
            <select name="family" id="family">
              <option value=""></option>
              <?php foreach ($family as $fam) { ?>
                <option value="<?= $fam ?>"><?= $fam ?></option>
              <?php } ?>
            </select>
            <button id="reset" class="btn btn-secondary">Reset</button>
        </div>
    </div>

    <main>
        <div class="container">
            <div class="row">

            <?php foreach ($data as $fruit) { ?>
              <div class="col-3" id="<?= $fruit->id ?>">
                <div class="card m-2">
                  <div class="card-header">
                    <h3 class="card-title m-0 m-0"><?= $fruit->name ?></h3>
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
    <script>
      $(document).ready(function(){
        $(".form-inline").submit(function(e) {
          e.preventDefault();
          let search = $("#search").val();
          $(".card-header").each(function() {
            let title = $(this).find("h3").text();
            $(this).parent().parent().fadeOut(500);
            if (title.toLowerCase().indexOf(search.toLowerCase()) >= 0) {
              let id = $(this).parent().parent().attr("id");
              let show = $("#" + id);
              show.fadeIn(500);
            }
          })
        });
      });
    </script>
  </body>
</html>