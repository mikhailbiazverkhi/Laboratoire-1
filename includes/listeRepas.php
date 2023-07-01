   
   
   <section class="productionSection section">
      <div class="sectionIntro">
         <div class="headerInfo container">
            <h2 class="title"><?=$pageTitle?><h2>
         </div>
      </div>
      <div class="boxesContainer container">

      <?php foreach ($tableauRepas as $repas) :?>

         <div class="boxContent">
            <div class="boxImgDiv">
               <img src="<?=$repas['cheminImage']?>" alt="Food Image" class="boxImg">
            </div>
            <div class="imgDesc">
               <span class="imageTitle"><?=$repas['nomRepas']?></span>
            </div>

            <span class="boxPrice">
               $<?=$repas['prixRepas']?>
            </span>
            <span class="boxLocalisation">
               <?=$repas['localisation']?>
            </span>

            <a href="seulRepas.php?id=<?=$repas['repasId']?>">
               <div class="boxImgBtn">
                  <button type="button">Voir plus</button>
               </div>
            </a>
         </div>
      <?php endforeach;?>

      </div>
   </section>