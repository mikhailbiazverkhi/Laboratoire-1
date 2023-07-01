<li class="navItem">
               <label for="localisation">Localisation:</label>
               <select name="localisation" id="localisation">
               <option value="toutes">toutes</option>
               <?php foreach ($localisations as $localisation) : ?>
                  <option value="<?=$localisation?>"><?=$localisation?></option>
               <?php endforeach; ?>
               </select>
            </li>

            <li class="navItem">
               <label for="prix">Prix:</label>
               <select name="prix" id="prix">
                  <option value="croissant">Croissant</option>
                  <option value="decroissant">Décroissant</option>
               </select>
            </li>

            <li class="navItem">
               <form action="">
                  <input type="text"/>
                  <button type="button">Recherche</button>
               </form>

            </li>