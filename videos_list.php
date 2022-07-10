<?php include_once("header.php"); ?>
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">
                           <div class="btn-group float-right right-action">
                              <div class="dropdown-menu-right">
                                  <?php $urlArr=parse_url($_SERVER['REQUEST_URI']);
                                  parse_str($urlArr['query'], $request_uri);
                                  $selected_year="";
                                  $selected_type="";
                                  $selected_country="";
                                  $selected_genre="";
                                  $selected_rating="";
                                  $hidden_input="";
                                  if(count($request_uri)>0) {
                                      foreach($request_uri as $k=>$v) {
                                          if($v==="Страна"||$v==="Тип картины"||$v==="Год"||$v==="Жанр") {continue;}
                                          if($k==="year") {$selected_year=$v;continue;}
                                          if($k==="type") {$selected_type=$v;continue;}
                                          if($k==="country") {$selected_country=$v;continue;}
                                          if($k==="genre") {$selected_genre=$v;continue;}
                                          if($k==="rating") {$selected_rating=$v;continue;}
                                          if((strlen($v)>0||$k==="q")&&$k!=="p") {
                                              $hidden_input.="<input type='hidden' name='" . $k . "'  value='" . $v . "'>";
                                          }
                                      }
                                  }
                                  $actual_link_s= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                                          "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]?";
                                  foreach ($request_uri as $k=>$v) {
                                      if($k==="p"){continue;}
                                      if(count($request_uri)>0){
                                          $actual_link_s.=$k."=".$v."&";
                                      }else{
                                          $actual_link_s.=$k."=".$v;
                                      }
                                  }
                                  ?>
                                  <form action="<?php echo $actual_link_s;?>" method="get">
                                      <?php echo $hidden_input; ?>
                                      <div style="display: inline-flex;">
                                          <select class="custom-select" name="year" id="years" onchange="this.form.submit()">
                                              <?php
                                              for($i=0;$i<count($years_arr);$i++) {
                                                  if($selected_year===$years_arr[$i]) {
                                                      echo "<option selected value='" . $years_arr[$i] . "'>" . $years_arr[$i] . "</option>";
                                                  }else{
                                                      echo "<option value='" . $years_arr[$i] . "'>" . $years_arr[$i] . "</option>";
                                                  }
                                              }
                                              ?>
                                          </select>&nbsp;&nbsp;
                                          <select class="custom-select" name="type" id="type" onchange="this.form.submit()">
                                              <?php
                                              foreach($types_arr as $k => $v) {
                                                    if ($selected_type === $k) {
                                                        echo "<option selected value='" . $k . "'>" . $v . "</option>";
                                                    } else {
                                                        echo "<option value='" . $k . "'>" . $v . "</option>";
                                                    }
                                                }
                                              ?>
                                          </select>
                                          &nbsp;&nbsp;
                                          <select class="custom-select" name="rating" id="ratingKinopoiskVoteCount" onchange="this.form.submit()">
                                              <?php
                                              if ($selected_rating === "rating_ud") {
                                                  echo "<option selected value='rating_ud'>Рейтинг &nabla;</option>";
                                              } else {
                                                  echo "<option value='rating_ud'>Рейтинг &nabla;</option>";
                                              }
                                              if ($selected_rating === "rating_du") {
                                                  echo "<option selected value='rating_du'>Рейтинг &Delta;</option>";
                                              } else {
                                                  echo "<option value='rating_du'>Рейтинг &Delta;</option>";
                                              }
                                              ?>
                                          </select>
                                          &nbsp;&nbsp;
                                          <select class="custom-select" name="genre" id="genre" onchange="this.form.submit()">
                                              <?php
                                              if ($selected_genre === "Жанр") {
                                                  echo "<option selected value='Жанр'>Жанр</option>";
                                              } else {
                                                  echo "<option value='Жанр'>Жанр</option>";
                                              }
                                              foreach($genres as $k => $v) {
                                                  if ($selected_genre === $v[0]) {
                                                      echo "<option selected value='" . $v[0] . "'>" . $v[0] . "</option>";
                                                  } else {
                                                      echo "<option value='" . $v[0] . "'>" . $v[0] . "</option>";
                                                  }
                                              }
                                              ?>
                                          </select>
                                          &nbsp;&nbsp;
                                          <select class="custom-select" name="country" id="country" onchange="this.form.submit()">
                                              <?php
                                              foreach($countries as $k => $v) {
                                                  if ($selected_country === $v[0]) {
                                                      echo "<option selected value='" . $v[0] . "'>" . $v[0] . "</option>";
                                                  } else {
                                                      echo "<option value='" . $v[0] . "'>" . $v[0] . "</option>";
                                                  }
                                              }
                                              ?>
                                          </select>
                                      </div>
                                  </form>
                                  <br>
                              </div>
                           </div>
                           <h6>Результаты поиска <?php
								if(isset($_GET["year"])&&$_GET['year']!=="Год") {echo " по ".$_GET["year"]." году ";}
								elseif(isset($_GET["genre"])&&$_GET['genre']!=="Жанр") {echo " по жанру <b>\"".$_GET["genre"]."\"</b> ";}
                                echo "(найдено: " . $total_count . ")";
                                ?>
                           </h6>
                        </div>
                     </div>
                      <div class="col-md-12">
                          <nav>
                              <ul class="pagination justify-content-center pagination-sm mb-4">
                                  <?php
                                  if(isset($number_of_pages)&&$number_of_pages>0){
                                      $pageDisplayToLeft = 3;
                                      $pageDisplayToRight = 7;
                                      $pagesTotal = $number_of_pages;
                                      $currentPage = $page;

                                      $prev_disabled="";if($page==1) {$prev_disabled=" disabled";} ?>
                                      <li class="page-item<?php echo $prev_disabled;?>">
                                          <a class="page-link" href="<?php echo $actual_link_s;?>p=<?php echo $page-1; ?>" tabindex="-1">
                                              <i class="fas fa-angle-left"></i></a>
                                      </li>
                                      <?php
                                      if(($currentPage - $pageDisplayToLeft) > 1) {
                                          echo '<li class="page-item"><a class="page-link" href="'.$actual_link_s.'p=1">1</a></li>';
                                          echo '<li class="page-item"><a class="page-link disabled"> ... </a></li>';
                                      }

                                      $pageDisplay = max(1, $currentPage - $pageDisplayToLeft);
                                      while($pageDisplay < $currentPage) {
                                          $active="";$link_disabled="";if($page==$pageDisplay) {$active=" active";$link_disabled=" disabled";}
                                          echo '<li class="page-item'.$active.'"><a class="page-link'.$link_disabled.'" 
                                      href="'.$actual_link_s.'p=' . $pageDisplay . '">' . $pageDisplay . '</a></li>';
                                          $pageDisplay++;
                                      }
                                      echo '<li class="page-item active"><a class="page-link disabled" onclick="return false;" 
                                      href="'.$actual_link_s.'p=' . $pageDisplay . '">' . $pageDisplay . '</a></li>';

                                      $pageDisplay = min($pagesTotal, $currentPage + 1);
                                      while($pageDisplay < min($currentPage + $pageDisplayToRight, $pagesTotal)) {
                                          $active="";$link_disabled="";if($page==$pageDisplay) {$active=" active";$link_disabled=" disabled";}
                                          echo '<li class="page-item'.$active.'"><a class="page-link'.$link_disabled.'" 
                                      href="'.$actual_link_s.'p=' . $pageDisplay . '">' . $pageDisplay . '</a></li>';
                                          $pageDisplay++;
                                      }

                                      if(($currentPage + $pageDisplayToRight) < $pagesTotal) {
                                          echo '<li class="page-item"><a class="page-link disabled"> ... </a></li>';
                                      }
                                      if(($currentPage + $pageDisplayToRight) < $pagesTotal) {
                                          echo '<li class="page-item'.$active.'"><a class="page-link" 
                                      href="'.$actual_link_s.'p=' . $pagesTotal . '">' . $pagesTotal . '</a></li>';
                                      }

                                      $next_disabled="";if(intval($page)==intval($number_of_pages)) {$next_disabled=" disabled";}?>
                                      <li class="page-item<?php echo $next_disabled;?>">
                                          <a class="page-link" href="<?php echo $actual_link_s;?>p=<?php echo $page+1; ?>" tabindex="-1"><i class="fas fa-angle-right"></i></a>
                                      </li>

                                  <?php } ?>
                              </ul>
                          </nav>
                      </div>
                      <?php
                        foreach ($films_list as $k => $v) {
                            if($v[3]!==null) {
                                echo "<div class=\"col-xl-3 col-sm-6 mb-3\">
                                        <div class=\"channels-card\">";
                                         if(stripos($v[34],"мультфильм")) {
                                             echo "<div class=\"time\">Мультфильм</div>";
                                         }elseif($v[30]=="FILM") {
                                             echo "<div class=\"time\">Фильм</div>";
                                          }elseif ($v[30]=="TV_SERIES") {
                                             echo "<div class=\"time\">Сериал</div>";
                                          }elseif ($v[30]=="MINI_SERIES") {
                                             echo "<div class=\"time\">Мини-сериал</div>";
                                         }
                                        echo "<div class=\"channels-card-image\">                                      
                                        <a href=\"video-page.php?filmId=".$v[1]."\"><img class=\"img-fluid\" src=\"" . $v[7] . "\" alt=\"\"></a>
                                       <div class=\"channels-card-image-btn\"><button type=\"button\" onclick=\"window.location.href='video-page.php?filmId=".$v[1]."'\"
                                       class=\"btn btn-outline-secondary btn-sm\">" . $v[3] . " (".$v[22].")";
                                       if($v[11]>0||$v[13]>0){
                                           echo "<span style='padding-left: 8px;'><i class=\"fas fa-star\"></i>&nbsp;";
                                           if($v[11]>0){echo $v[11];}elseif($v[13]>0){echo $v[13];}
                                           echo "</span>";
                                       }
                                       echo "</a></button></div>
                                       </div>
                                        <div class=\"channels-card-body\">                                  
                                         <div class=\"channels-view\" style=' word-wrap:break-word;'>
                                         " . str_ireplace(",",", ",$v[34]) . "
                                        </div>
                                        </div>
                                        </div>
                                    </div>";
                            }
                        }
                      ?>
                      <div class="col-md-12">
                          <nav>
                              <ul class="pagination justify-content-center pagination-sm mb-4">                                
								  <?php
								  if(isset($number_of_pages)&&$number_of_pages>0){
								    $pageDisplayToLeft = 3;
									$pageDisplayToRight = 7;
									$pagesTotal = $number_of_pages;
									$currentPage = $page;

									$prev_disabled="";if($page==1) {$prev_disabled=" disabled";} ?>
									  <li class="page-item<?php echo $prev_disabled;?>">
										  <a class="page-link" href="<?php echo $actual_link_s;?>p=<?php echo $page-1; ?>" tabindex="-1">
                                              <i class="fas fa-angle-left"></i></a>
									  </li>
									<?php
									if(($currentPage - $pageDisplayToLeft) > 1) {
										echo '<li class="page-item"><a class="page-link" href="'.$actual_link_s.'p=1">1</a></li>';
										echo '<li class="page-item"><a class="page-link disabled"> ... </a></li>';
									}

									$pageDisplay = max(1, $currentPage - $pageDisplayToLeft);
									while($pageDisplay < $currentPage) {
										$active="";$link_disabled="";if($page==$pageDisplay) {$active=" active";$link_disabled=" disabled";}
										echo '<li class="page-item'.$active.'"><a class="page-link'.$link_disabled.'" 
                                      href="'.$actual_link_s.'p=' . $pageDisplay . '">' . $pageDisplay . '</a></li>';
										$pageDisplay++;
									}									
									echo '<li class="page-item active"><a class="page-link disabled" onclick="return false;" 
                                      href="'.$actual_link_s.'p=' . $pageDisplay . '">' . $pageDisplay . '</a></li>';

									$pageDisplay = min($pagesTotal, $currentPage + 1);
									while($pageDisplay < min($currentPage + $pageDisplayToRight, $pagesTotal)) {
										$active="";$link_disabled="";if($page==$pageDisplay) {$active=" active";$link_disabled=" disabled";}
										echo '<li class="page-item'.$active.'"><a class="page-link'.$link_disabled.'" 
                                      href="'.$actual_link_s.'p=' . $pageDisplay . '">' . $pageDisplay . '</a></li>';
										$pageDisplay++;
									}

									if(($currentPage + $pageDisplayToRight) < $pagesTotal) {
										echo '<li class="page-item"><a class="page-link disabled"> ... </a></li>';
									}
									if(($currentPage + $pageDisplayToRight) < $pagesTotal) {
										echo '<li class="page-item'.$active.'"><a class="page-link" 
                                      href="'.$actual_link_s.'p=' . $pagesTotal . '">' . $pagesTotal . '</a></li>';
									}

									$next_disabled="";if(intval($page)==intval($number_of_pages)) {$next_disabled=" disabled";}?>
                                  <li class="page-item<?php echo $next_disabled;?>">
                                      <a class="page-link" href="<?php echo $actual_link_s;?>p=<?php echo $page+1; ?>" tabindex="-1"><i class="fas fa-angle-right"></i></a>
                                  </li>

								  <?php } ?>
                              </ul>
                          </nav>
                          </div>
                      </div>
                  </div>
               <hr>
               
                </div>
            </div>
        </div>
            <!-- /.container-fluid -->
<?php include_once("footer.php");?>