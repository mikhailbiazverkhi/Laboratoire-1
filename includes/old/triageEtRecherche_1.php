            
            
         <li class="navItem nav-item dropdown">
          <a class="navLink nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Localisation
          </a>

          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php foreach ($localisations as $localisation) : ?>
            <li><a class="dropdown-item" href="#"><?=$localisation?></a></li>
          <?php endforeach; ?>
            <!-- <li><a class="dropdown-item" href="#">Another action</a></li> -->
            <!-- <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li> -->
          </ul>
        </li>

        <li class="navItem nav-item dropdown">
          <a class="navLink nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Prix
          </a>

          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Croissant</a></li>
            <li><a class="dropdown-item" href="#">Décroissant</a></li>
          </ul>
        </li>
        

            
            
            
            
            
            
            
            
            
            
            
            <!-- <li class="navItem">
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

            </li> -->



            