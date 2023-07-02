
   
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
               $<?=round($repas['prixRepas'], 2)?>
            </span>
            <span class="boxLocalisation">
               <?=$repas['localisation']?>
            </span>

            <div class="imgDesc">
            <span class="imageTitle">
            <i class="fa-light fa-thumbs-up" style="color: #06841b;"></i>
            <?=noteMoyenneRepas($repas)?>
            <i class="fa-light fa-comment" style="color: #aa183d;"></i>
            <?=nombreCommentairs($repas)?>
            </span>
            </div>

            <a href="seulRepas.php?id=<?=$repas['repasId']?>">
               <div class="boxImgBtn">
                  <button type="button">Voir plus</button>
               </div>
            </a>
         </div>
      <?php endforeach;?>

      </div>
   </section>